<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;
use App\Models\Product;
use App\Models\Course;
use App\Models\ChatLog;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string'],
        ]);

        $userMessage = $request->input('message');
        $lower = mb_strtolower($userMessage);

        // Logger helper
        $logReply = function (string $intent, string $reply, array $meta = []) use ($userMessage) {
            try {
                ChatLog::create([
                    'user_id' => auth()->id(),
                    'intent' => $intent,
                    'message' => $userMessage,
                    'reply' => $reply,
                    'meta' => $meta,
                ]);
            } catch (\Throwable $e) {
                // ignore log errors
            }
            return response()->json(['reply' => $reply]);
        };

        // Detect list vs detail
        $wantsList = (
            (str_contains($lower, 'lista') || str_contains($lower, 'listar') || str_contains($lower, 'ver') || str_contains($lower, 'mostrar'))
            && (str_contains($lower, 'curso') || str_contains($lower, 'cursos') || str_contains($lower, 'producto') || str_contains($lower, 'productos'))
        );

        $wantsDetail = (
            (str_contains($lower, 'detalle') || str_contains($lower, 'informacion') || str_contains($lower, 'información') ||
             str_contains($lower, 'incluye') || str_contains($lower, 'cuanto') || str_contains($lower, 'cuánto') ||
             str_contains($lower, 'instructor') || str_contains($lower, 'stock') || str_contains($lower, 'cupos') || preg_match('/\d/', $lower))
            && (str_contains($lower, 'curso') || str_contains($lower, 'producto'))
        );

        // Contacto directo
        if (
            str_contains($lower, 'telefono') ||
            str_contains($lower, 'teléfono') ||
            str_contains($lower, 'numero') ||
            str_contains($lower, 'número') ||
            str_contains($lower, 'contacto')
        ) {
            $reply = 'Puedes llamarnos o escribirnos al +51 999 888 777. Tambien por email: ventas@printex.com';
            return $logReply('contact', $reply);
        }

        // Listado de productos (solo nombres + precios)
        if ($wantsList && !$wantsDetail && (str_contains($lower, 'producto') || str_contains($lower, 'productos'))) {
            $items = Product::orderByDesc('created_at')
                ->take(8)
                ->get()
                ->values()
                ->map(function ($p, $idx) {
                    $price = $p->price ?? 0;
                    $bullet = '•'; // bullet para legibilidad
                    return $bullet . ' ' . ($idx + 1) . ') ' . $p->name . ' - S/ ' . number_format($price, 2);
                })
                ->implode("\n");

            $reply = $items !== ''
                ? "Aqui tienes productos disponibles:\n{$items}"
                : 'No tengo productos para mostrar ahora.';

            return $logReply('list_products', $reply);
        }

        // Listado de cursos (solo nombres + precios + horas)
        if ($wantsList && !$wantsDetail && (str_contains($lower, 'curso') || str_contains($lower, 'cursos'))) {
            $courses = Course::orderByDesc('created_at')
                ->take(8)
                ->get()
                ->values()
                ->map(function ($c, $idx) {
                    $price = $c->price ?? 0;
                    $durVal = $c->duration ?? $c->duration_hours ?? null;
                    $dur = $durVal ? " ({$durVal}h)" : '';
                    $bullet = '•';
                    return $bullet . ' ' . ($idx + 1) . ') ' . $c->name . ' - S/ ' . number_format($price, 2) . $dur;
                })
                ->implode("\n");

            $reply = $courses !== ''
                ? "Aqui tienes cursos disponibles:\n{$courses}"
                : 'No tengo cursos para mostrar ahora.';

            return $logReply('list_courses',        $reply);
        }

        // Detalles de cursos
        if ($wantsDetail && (str_contains($lower, 'curso'))) {
            $all = Course::orderByDesc('created_at')->take(10)->get()->values();

            $target = null;
            if (preg_match('/curso\s*(\d+)/', $lower, $m)) {
                $idx = (int) $m[1];
                $target = $all->get($idx - 1);
            } else {
                $target = $all->first(fn($c) => str_contains($lower, mb_strtolower($c->name)));
            }

            if (! $target) {
                $sugerencias = $all->take(3)->pluck('name')->implode(', ');
                $reply = $sugerencias !== ''
                    ? "No encontre ese curso. Algunos disponibles: {$sugerencias}"
                    : 'No encontre cursos para mostrar.';
                return $logReply('course_not_found', $reply, ['asked' => $userMessage]);
            }

            $durVal = $target->duration ?? $target->duration_hours ?? null;
            $dur = $durVal ? "{$durVal}h" : 'No especificado';
            $price = $target->price ?? 0;
            $modalidad = $target->modality ?? 'No especificada';
            $instructor = $target->instructor ?? 'No especificado';
            $cupos = $target->slots ?? $target->available_slots ?? 'No especificado';
            $desc = $target->description ?? 'Sin descripcion';

            $alternativas = $all->where('id', '!=', $target->id)->take(2)->pluck('name')->values();

            $reply = "Recomendacion principal\n"
                . "- Nombre: {$target->name}\n"
                . "- Precio: S/ " . number_format($price, 2) . "\n"
                . "- Modalidad: {$modalidad}\n"
                . "- Instructor: {$instructor}\n"
                . "- Cupos: {$cupos}\n"
                . "- Duracion: {$dur}\n"
                . "- Descripcion: {$desc}";

            if ($alternativas->isNotEmpty()) {
                $reply .= "\nAlternativas: " . $alternativas->implode(' | ');
            }

            $reply .= "\nTip final: Si quieres inscribirte, indicame el curso y te explico como hacerlo.";

            return $logReply('course_detail', $reply, ['course_id' => $target->id ?? null]);
        }

        // Detalles de productos
        if ($wantsDetail && (str_contains($lower, 'producto'))) {
            $all = Product::orderByDesc('created_at')->take(10)->get()->values();

            $target = null;
            if (preg_match('/producto\s*(\d+)/', $lower, $m)) {
                $idx = (int) $m[1];
                $target = $all->get($idx - 1);
            } else {
                $target = $all->first(fn($p) => str_contains($lower, mb_strtolower($p->name)));
            }

            if (! $target) {
                $sugerencias = $all->take(3)->pluck('name')->implode(', ');
                $reply = $sugerencias !== ''
                    ? "No encontre ese producto. Algunos disponibles: {$sugerencias}"
                    : 'No encontre productos para mostrar.';
                return $logReply('product_not_found', $reply, ['asked' => $userMessage]);
            }

            $price = $target->price ?? 0;
            $stock = $target->stock ?? 'No especificado';
            $desc = $target->description ?? 'Sin descripcion';
            $category = $target->category->name ?? 'Sin categoria';

            $alternativas = $all->where('id', '!=', $target->id)->take(2)->pluck('name')->values();

            $reply = "Recomendacion principal\n"
                . "- Nombre: {$target->name}\n"
                . "- Precio: S/ " . number_format($price, 2) . "\n"
                . "- Categoria: {$category}\n"
                . "- Stock: {$stock}\n"
                . "- Descripcion: {$desc}";

            if ($alternativas->isNotEmpty()) {
                $reply .= "\nAlternativas: " . $alternativas->implode(' | ');
            }

            $reply .= "\nTip final: Si quieres comprarlo, anade al carrito y finaliza el pago.";

            return $logReply('product_detail', $reply, ['product_id' => $target->id ?? null]);
        }

        // Inscripcion: no inscribir realmente
        if (str_contains($lower, 'inscrib') && str_contains($lower, 'curso')) {
            $reply = 'Dime el nombre del curso y te explico como inscribirte en la plataforma. No puedo inscribirte directamente desde aqui.';
            return $logReply('inscripcion', $reply);
        }

        // Si el tema no parece relacionado con productos/cursos/pagos/pedidos/contacto, responde que no hay info
        $temasClave = ['producto','productos','curso','cursos','pago','pagos','pedido','pedidos','contacto','inscrib'];
        $esTemaRelacionado = collect($temasClave)->contains(fn($k) => str_contains($lower, $k));
        if (! $esTemaRelacionado) {
            $reply = 'Solo puedo ayudarte con productos, cursos, pagos, pedidos o contacto de Printex.';
            return $logReply('fuera_de_tema', $reply);
        }

        // Intentos rapidos (fallback) sin BD
        $fallbacks = [
            'producto' => 'Puedes ver los productos en la seccion Productos. Si buscas algo especifico, dime cual.',
            'curso' => 'Consulta los cursos en la seccion Cursos. Si quieres recomendacion, dime que te interesa aprender.',
            'pago' => 'Aceptamos tarjeta, Yape/Plin y transferencia.',
            'pedido' => 'Para seguimiento de pedido, indicame el numero de pedido y te confirmo el estado.',
            'contacto' => 'Escribenos a soporte@printex.com o llama al +51 999 888 777.',
        ];

        try {
            $client = OpenAI::client(env('OPENAI_API_KEY'));

            $response = $client->chat()->create([
                'model' => env('OPENAI_MODEL'),
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres PrintBot, un asistente breve y util para clientes de Printex. Responde en espanol con un maximo de 2 oraciones.'],
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);

            $reply = data_get($response, 'choices.0.message.content');

            if (! $reply) {
                throw new \RuntimeException('Respuesta vacia del modelo');
            }

            return $logReply('openai', $reply);
        } catch (\Throwable $e) {
            $reply = collect($fallbacks)->first(function ($text, $key) use ($lower) {
                return str_contains($lower, $key);
            }) ?? 'Puedo ayudarte con productos, cursos, pagos o pedidos. Que necesitas?';

            return $logReply('fallback', $reply, ['error' => $e->getMessage()]);
        }
    }
}
