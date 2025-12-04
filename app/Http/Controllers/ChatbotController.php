<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;
use App\Models\Product;
use App\Models\Course;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string'],
        ]);

        $userMessage = $request->input('message');
        $lower = mb_strtolower($userMessage);

        // Detectar intención de lista vs. detalle
        $wantsList = (
            (str_contains($lower, 'lista') || str_contains($lower, 'listar') || str_contains($lower, 'ver') || str_contains($lower, 'mostrar'))
            && (str_contains($lower, 'curso') || str_contains($lower, 'cursos') || str_contains($lower, 'producto') || str_contains($lower, 'productos'))
        );

        $wantsDetail = (
            (str_contains($lower, 'detalle') || str_contains($lower, 'información') || str_contains($lower, 'informacion') ||
             str_contains($lower, 'incluye') || str_contains($lower, 'cuánto') || str_contains($lower, 'cuanto') ||
             str_contains($lower, 'instructor') || str_contains($lower, 'stock') || str_contains($lower, 'cupos') || preg_match('/\d/', $lower))
            && (str_contains($lower, 'curso') || str_contains($lower, 'producto'))
        );

        // Respuesta directa de contacto
        if (
            str_contains($lower, 'teléfono') ||
            str_contains($lower, 'telefono') ||
            str_contains($lower, 'numero') ||
            str_contains($lower, 'número') ||
            str_contains($lower, 'contacto')
        ) {
            return response()->json([
                'reply' => 'Puedes llamarnos o escribirnos al +51 999 888 777. También por email: ventas@printex.com'
            ]);
        }

        // Respuesta directa de productos: listado simple (solo si no es detalle)
        if ($wantsList && !$wantsDetail && (str_contains($lower, 'producto') || str_contains($lower, 'productos'))) {
            $items = Product::orderByDesc('created_at')
                ->take(8)
                ->get()
                ->values()
                ->map(function ($p) {
                    $price = $p->price ?? 0;
                    return '- ' . $p->name . ' — S/ ' . number_format($price, 2);
                })
                ->implode("\n");

            return response()->json([
                'reply' => $items !== ''
                    ? "Aquí tienes productos disponibles:\n{$items}"
                    : 'No tengo productos para mostrar ahora.'
            ]);
        }

        // Respuesta directa de cursos: listado simple (solo si no es detalle)
        if ($wantsList && !$wantsDetail && (str_contains($lower, 'curso') || str_contains($lower, 'cursos'))) {
            $courses = Course::orderByDesc('created_at')
                ->take(8)
                ->get()
                ->values()
                ->map(function ($c) {
                    $price = $c->price ?? 0;
                    $durVal = $c->duration ?? $c->duration_hours ?? null;
                    $dur = $durVal ? " ({$durVal}h)" : '';
                    return '- ' . $c->name . ' — S/ ' . number_format($price, 2) . $dur;
                })
                ->implode("\n");

            return response()->json([
                'reply' => $courses !== ''
                    ? "Aquí tienes cursos disponibles:\n{$courses}"
                    : 'No tengo cursos para mostrar ahora.'
            ]);
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
                return response()->json([
                    'reply' => $sugerencias !== ''
                        ? "No encontré ese curso. Algunos disponibles: {$sugerencias}"
                        : 'No encontré cursos para mostrar.'
                ]);
            }

            $durVal = $target->duration ?? $target->duration_hours ?? null;
            $dur = $durVal ? "{$durVal}h" : 'No especificado';
            $price = $target->price ?? 0;
            $modalidad = $target->modality ?? 'No especificada';
            $instructor = $target->instructor ?? 'No especificado';
            $cupos = $target->slots ?? $target->available_slots ?? 'No especificado';
            $desc = $target->description ?? 'Sin descripción';

            $alternativas = $all->where('id', '!=', $target->id)->take(2)->pluck('name')->values();

            $reply = "⭐ Recomendación principal\n"
                . "- Nombre: {$target->name}\n"
                . "- Precio: S/ " . number_format($price, 2) . "\n"
                . "- Modalidad: {$modalidad}\n"
                . "- Instructor: {$instructor}\n"
                . "- Cupos: {$cupos}\n"
                . "- Duración: {$dur}\n"
                . "- Descripción: {$desc}";

            if ($alternativas->isNotEmpty()) {
                $reply .= "\n🔁 Alternativas: " . $alternativas->implode(' | ');
            }

            $reply .= "\n💡 Tip final: Si quieres inscribirte, indícame el curso y te explico cómo hacerlo.";

            return response()->json([
                'reply' => $reply,
            ]);
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
                return response()->json([
                    'reply' => $sugerencias !== ''
                        ? "No encontré ese producto. Algunos disponibles: {$sugerencias}"
                        : 'No encontré productos para mostrar.'
                ]);
            }

            $price = $target->price ?? 0;
            $stock = $target->stock ?? 'No especificado';
            $desc = $target->description ?? 'Sin descripción';
            $category = $target->category->name ?? 'Sin categoría';

            $alternativas = $all->where('id', '!=', $target->id)->take(2)->pluck('name')->values();

            $reply = "⭐ Recomendación principal\n"
                . "- Nombre: {$target->name}\n"
                . "- Precio: S/ " . number_format($price, 2) . "\n"
                . "- Categoría: {$category}\n"
                . "- Stock: {$stock}\n"
                . "- Descripción: {$desc}";

            if ($alternativas->isNotEmpty()) {
                $reply .= "\n🔁 Alternativas: " . $alternativas->implode(' | ');
            }

            $reply .= "\n💡 Tip final: Si quieres comprarlo, añade al carrito y finaliza el pago.";

            return response()->json([
                'reply' => $reply,
            ]);
        }

        // Inscripción: no inscribir realmente
        if (str_contains($lower, 'inscrib') && str_contains($lower, 'curso')) {
            return response()->json([
                'reply' => 'Dime el nombre del curso y te explico cómo inscribirte en la plataforma. No puedo inscribirte directamente desde aquí.'
            ]);
        }

        // Intentos rápidos (fallback) sin BD
        $fallbacks = [
            'producto' => 'Puedes ver los productos en la sección Productos. Si buscas algo específico, dime cuál.',
            'curso' => 'Consulta los cursos en la sección Cursos. Si quieres recomendación, dime qué te interesa aprender.',
            'pago' => 'Aceptamos tarjeta, Yape/Plin y transferencia.',
            'pedido' => 'Para seguimiento de pedido, indícame el número de pedido y te confirmo el estado.',
            'contacto' => 'Escríbenos a soporte@printex.com o llama al +51 999 888 777.',
        ];

        try {
            $client = OpenAI::client(env('OPENAI_API_KEY'));

            $response = $client->chat()->create([
                'model' => env('OPENAI_MODEL'),
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres PrintBot, un asistente breve y útil para clientes de Printex. Responde en español con un máximo de 2 oraciones.'],
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);

            $reply = data_get($response, 'choices.0.message.content');

            if (! $reply) {
                throw new \RuntimeException('Respuesta vacía del modelo');
            }

            return response()->json(['reply' => $reply]);
        } catch (\Throwable $e) {
            $reply = collect($fallbacks)->first(function ($text, $key) use ($lower) {
                return str_contains($lower, $key);
            }) ?? 'Puedo ayudarte con productos, cursos, pagos o pedidos. ¿Qué necesitas?';

            return response()->json(['reply' => $reply]);
        }
    }
}
