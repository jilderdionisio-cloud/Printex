<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Course;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatbotService
{
    public function answer(string $question): array
    {
        $products = $this->findRelevantProducts($question);
        $courses = $this->findRelevantCourses($question);
        $context = $this->buildContext($products, $courses);

        $systemPrompt = <<<SYS
Eres un asistente de la plataforma Printex.

REGLAS IMPORTANTES:
- Respondes siempre en español.
- Nunca inventes cursos ni productos.
- El backend te envía una lista en JSON con los cursos/productos que COINCIDEN con la búsqueda del usuario.
- Si esa lista está vacía, significa que NO hay coincidencias.

COMPORTAMIENTO:

1) Si la lista JSON NO está vacía:
   - Responde normalmente según lo que el usuario pide.

2) Si la lista JSON está VACÍA y el usuario preguntó por algo específico (por ejemplo "Bob Sponja"):
   - Di claramente que ese curso o producto NO existe o no está disponible.
   - NO muestres listas ni otros cursos/productos.
   - Opcional: puedes preguntar amablemente si quiere ver la lista general de cursos o productos, pero NO la muestres hasta que él lo pida.

3) SOLO cuando el usuario diga algo como:
   - "muéstrame la lista de cursos"
   - "lista de productos"
   - "qué cursos tienes"
   Entonces sí puedes mostrar la lista de nombres.
SYS;

        $userPrompt = "Pregunta del usuario: {$question}\n\nContexto (productos y cursos):\n{$context}";

        try {
            $response = $this->ollamaClient()
                ->post('/api/chat', [
                    'model' => config('ollama.model'),
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'stream' => false,
                    'options' => [
                        'temperature' => (float) config('ollama.temperature', 0.2),
                        'num_predict' => (int) config('ollama.num_predict', 60),
                    ],
                ])
                ->throw();
        } catch (ConnectionException $e) {
            Log::warning('chatbot.ollama.connection_failed', [
                'error' => $e->getMessage(),
                'host' => config('ollama.host'),
            ]);
            throw new \RuntimeException('No se pudo conectar con el modelo Ollama en la nube.', 0, $e);
        } catch (RequestException $e) {
            Log::warning('chatbot.ollama.request_failed', [
                'error' => $e->getMessage(),
                'host' => config('ollama.host'),
                'status' => optional($e->response)->status(),
                'body' => optional($e->response)->body(),
            ]);
            throw new \RuntimeException('El servicio de chat no respondio correctamente.', 0, $e);
        }

        $content = data_get($response->json(), 'message.content');

        if (! is_string($content) || trim($content) === '') {
            throw new \RuntimeException('El modelo no devolvio contenido util.');
        }

        return [
            'answer' => trim($content),
            'products' => $products,
            'courses' => $courses,
        ];
    }

    private function ollamaClient(): PendingRequest
    {
        $client = Http::baseUrl(rtrim(config('ollama.host'), '/'))
            ->timeout((int) config('ollama.request_timeout', 30))
            ->acceptJson();

        if (! config('ollama.verify_ssl', true)) {
            $client = $client->withoutVerifying();
        }

        if ($apiKey = config('ollama.api_key')) {
            $client = $client->withToken($apiKey);
        }

        return $client;
    }

    private function findRelevantProducts(string $question): Collection
    {
        $keywords = $this->extractKeywords($question);
        $limit = (int) config('ollama.max_results', 10);

        $query = Product::query()
            ->select(['id', 'name', 'description', 'price', 'stock', 'purchase_count', 'category_id', 'supplier_id'])
            ->with(['category:id,name', 'supplier:id,name']);

        if ($keywords->isNotEmpty()) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orWhere('name', 'like', '%' . $word . '%')
                        ->orWhere('description', 'like', '%' . $word . '%');
                }
            });
        }

        $products = $query
            ->orderByDesc('purchase_count')
            ->limit($limit)
            ->get();

        if ($products->isEmpty()) {
            $products = Product::query()
                ->select(['id', 'name', 'description', 'price', 'stock', 'purchase_count', 'category_id', 'supplier_id'])
                ->with(['category:id,name', 'supplier:id,name'])
                ->latest()
                ->limit($limit)
                ->get();
        }

        return $products;
    }

    private function findRelevantCourses(string $question): Collection
    {
        $keywords = $this->extractKeywords($question);
        $limit = (int) config('ollama.max_results', 10);

        $query = Course::query()
            ->select(['id', 'name', 'description', 'price', 'duration_hours', 'modality', 'slots', 'instructor', 'enrollment_count']);

        if ($keywords->isNotEmpty()) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orWhere('name', 'like', '%' . $word . '%')
                        ->orWhere('description', 'like', '%' . $word . '%')
                        ->orWhere('instructor', 'like', '%' . $word . '%');
                }
            });
        }

        $courses = $query
            ->orderByDesc('enrollment_count')
            ->limit($limit)
            ->get();

        if ($courses->isEmpty()) {
            $courses = Course::query()
                ->select(['id', 'name', 'description', 'price', 'duration_hours', 'modality', 'slots', 'instructor', 'enrollment_count'])
                ->latest()
                ->limit($limit)
                ->get();
        }

        return $courses;
    }

    private function extractKeywords(string $question): Collection
    {
        $normalized = Str::of($question)
            ->lower()
            ->replaceMatches('/[^a-z0-9\\x{00C0}-\\x{017F}\\s]/u', ' ')
            ->squish();

        return collect(explode(' ', (string) $normalized))
            ->filter(fn ($word) => strlen($word) > 3)
            ->unique()
            ->take(10)
            ->values();
    }

    private function buildContext(Collection $products, Collection $courses): string
    {
        $productLines = $products->isEmpty()
            ? ['No hay productos registrados para recomendar.']
            : $products->map(function (Product $product) {
                $description = Str::limit($product->description ?? 'Sin descripcion', 120, '...');
                $category = $product->category->name ?? 'Sin categoria';
                $supplier = $product->supplier->name ?? 'Proveedor no registrado';

                return "- {$product->name} | Precio: S/ " .
                    number_format((float) $product->price, 2) .
                    " | Stock: {$product->stock} | Cat: {$category} | Prov: {$supplier} | Desc: {$description}";
            })->all();

        $courseLines = $courses->isEmpty()
            ? ['No hay cursos registrados para recomendar.']
            : $courses->map(function (Course $course) {
                $description = Str::limit($course->description ?? 'Sin descripcion', 120, '...');
                $duration = $course->duration_hours ? "{$course->duration_hours}h" : 'Duracion no indicada';
                $modality = $course->modality ?? 'Modalidad no indicada';
                $instructor = $course->instructor ?? 'Instructor no indicado';
                $slots = $course->slots !== null ? "{$course->slots} cupos" : 'Cupos no indicados';

                return "- {$course->name} | Precio: S/ " .
                    number_format((float) $course->price, 2) .
                    " | {$modality} | {$duration} | Instructor: {$instructor} | Cupos: {$slots} | Desc: {$description}";
            })->all();

        return "PRODUCTOS:\n" . implode("\n", $productLines) . "\n\nCURSOS:\n" . implode("\n", $courseLines);
    }
}
