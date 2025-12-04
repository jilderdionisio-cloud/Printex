<?php

return [
    'host' => env('OLLAMA_HOST', 'http://127.0.0.1:11434'),
    'model' => env('OLLAMA_MODEL', 'llama3.2'),
    'request_timeout' => env('OLLAMA_TIMEOUT', 30),
    'temperature' => env('OLLAMA_TEMPERATURE', 0.2),
    'num_predict' => env('OLLAMA_NUM_PREDICT', 60),
    'max_results' => env('CHATBOT_PRODUCT_LIMIT', 10),
    'api_key' => env('OLLAMA_API_KEY'),
    'verify_ssl' => env('OLLAMA_VERIFY_SSL', true),
];
