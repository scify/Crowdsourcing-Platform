<?php

namespace App\BusinessLogicLayer\CommentAnalyzer;

use App\BusinessLogicLayer\CommentAnalyzer\Exception\AnalyzerException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Analyzer {
    private $api_key;
    private $client;
    const API_URL = 'https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze';

    public function __construct() {
        $this->api_key = config('app.google_comment_analyzer_key');
        $this->client = new Client();
    }

    /**
     * @throws GuzzleException
     * @throws AnalyzerException
     */
    public function getToxicityResponse(string $text): string {
        try {
            $response = $this->client->post(static::API_URL . '?key=' . $this->api_key, [
                RequestOptions::JSON => [
                    'comment' => [
                        'text' => $text
                    ],
                    'requestedAttributes' => [
                        'TOXICITY' => new \stdClass()
                    ]
                ]
            ]);
        } catch (Exception $e) {
            throw new AnalyzerException(sprintf('Call to Perspective API Failed: %s', $e->getMessage()));
        }

        if ($response->getStatusCode() != 200) {
            throw new AnalyzerException(sprintf('Call to Perspective API Failed: HTTP %s', $response->getStatusCode()));
        }

        return $response->getBody();
    }
}
