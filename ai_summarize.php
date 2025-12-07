<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

function ai_summarize($text) {
    $client = new Client();

    $response = $client->post('https://api.openai.com/v1/chat/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . getenv("OPENAI_API_KEY"),
            'Content-Type' => 'application/json'
        ],
        'json' => [
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'Summarize text into exactly 3 sentences.'],
                ['role' => 'user',  'content' => $text]
            ]
        ]
    ]);

    $body = json_decode($response->getBody(), true);
    return $body['choices'][0]['message']['content'];
}

// 测试
echo ai_summarize("Artificial Intelligence is changing the world...");
