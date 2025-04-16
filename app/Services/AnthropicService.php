<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AnthropicService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.anthropic.com/v1';

    public function __construct()
    {
        $this->apiKey = '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';
    }

    public function chat($message)
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json',
        ])->post($this->baseUrl . '/messages', [
            'model' => 'claude-3-sonnet-20240229',
            'max_tokens' => 1024,
            'messages' => [
                ['role' => 'user', 'content' => $message]
            ]
        ]);

        return $response->json();
    }
}
