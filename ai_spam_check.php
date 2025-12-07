<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

function ai_spam_check($text) {
    $client = new Client();

    $response = $client->post('https://api.openai.com/v1/chat/completions', [
        'headers' => [
            'Authorization' => 'Bearer ' . getenv("OPENAI_API_KEY"),
            'Content-Type' => 'application/json'
        ],
        'json' => [
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are a classifier. Respond with only one word: 'Spam' or 'Not Spam'."
                ],
                [
                    'role' => 'user',
                    'content' => $text
                ]
            ]
        ]
    ]);

    $body = json_decode($response->getBody(), true);
    return trim($body['choices'][0]['message']['content']);
}

// 测试
echo ai_spam_check("Congratulations! You won a free iPhone!");
echo "\n";
echo ai_spam_check("Hey, are we meeting tomorrow?");
