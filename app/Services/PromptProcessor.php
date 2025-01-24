<?php

namespace App\Services;

use GuzzleHttp\Client;

class PromptProcessor
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_CLOUD_API_KEY');
    }

    public function refinePrompt(string $prompt): string
    {
        $syntaxAnalysis = $this->analyzeSyntax($prompt);
        $refinedPrompt = $this->extractKeyPhrases($syntaxAnalysis);

        return $refinedPrompt ?: $prompt;
    }

    private function analyzeSyntax(string $text): array
    {
        $client = new Client();
        $response = $client->post('https://language.googleapis.com/v1/documents:analyzeSyntax', [
            'query' => ['key' => $this->apiKey],
            'json' => [
                'document' => [
                    'type' => 'PLAIN_TEXT',
                    'content' => $text,
                ],
                'encodingType' => 'UTF8',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    private function extractKeyPhrases(array $syntaxAnalysis): string
    {
        $keyPhrases = [];
        if (isset($syntaxAnalysis['tokens'])) {
            foreach ($syntaxAnalysis['tokens'] as $token) {
                // Extract nouns and adjectives for image context
                $partOfSpeech = $token['partOfSpeech']['tag'];
                if (in_array($partOfSpeech, ['NOUN', 'ADJ'])) {
                    $keyPhrases[] = $token['text']['content'];
                }
            }
        }

        return implode(' ', $keyPhrases);
    }
}