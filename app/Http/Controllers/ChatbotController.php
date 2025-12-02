<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string'],
        ]);

        $client = OpenAI::client(env('OPENAI_API_KEY'));

        $response = $client->chat()->create([
            'model' => env('OPENAI_MODEL'),
            'messages' => [
                ['role' => 'user', 'content' => $request->input('message')],
            ],
        ]);

        return response()->json([
            'reply' => $response['choices'][0]['message']['content'] ?? '',
        ]);
    }
}
