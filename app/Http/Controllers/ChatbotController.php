<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function __construct(private ChatbotService $chatbot)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $text = trim($validated['message']);
        if ($text === '') {
            return response()->json([
                'error' => 'El mensaje no puede estar vacío.',
            ], 422);
        }

        if ($this->isGreeting($text)) {
            return response()->json([
                'reply' => "👋 ¡Hola! Soy tu asistente Printex. ¿En qué puedo ayudarte hoy? Puedo recomendarte productos y cursos disponibles.",
                'products' => [],
                'courses' => [],
            ]);
        }

        try {
            $result = $this->chatbot->answer($text);
        } catch (\Throwable $e) {
            $isConnError = str_contains($e->getMessage(), 'Ollama');
            return response()->json([
                'reply' => $isConnError
                    ? 'No pude conectar con el modelo IA. Verifica que Ollama en la nube este en linea y accesible.'
                    : 'No pude responder ahora. Por favor, intenta de nuevo en un momento.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 502);
        }

        $products = $result['products'];
        $courses = $result['courses'];

        return response()->json([
            'reply' => $result['answer'],
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category->name ?? null,
                    'supplier' => $product->supplier->name ?? null,
                    'price' => $product->price,
                    'stock' => $product->stock,
                ];
            })->values(),
            'courses' => $courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'price' => $course->price,
                    'duration_hours' => $course->duration_hours,
                    'modality' => $course->modality,
                    'slots' => $course->slots,
                    'instructor' => $course->instructor,
                ];
            })->values(),
        ]);
    }

    private function isGreeting(string $text): bool
    {
        $normalized = mb_strtolower($text, 'UTF-8');
        $greetings = ['hola', 'buenas', 'buenos días', 'buenas tardes', 'buenas noches', 'hey', 'holi', 'que tal', 'qué tal'];

        foreach ($greetings as $greeting) {
            if (str_contains($normalized, $greeting)) {
                return true;
            }
        }

        return false;
    }
}
