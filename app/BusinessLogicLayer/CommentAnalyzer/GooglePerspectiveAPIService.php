<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\CommentAnalyzer;

use App\BusinessLogicLayer\CommentAnalyzer\Exception\AnalyzerException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class GooglePerspectiveAPIService implements ToxicityAnalyzerService {
    private $api_key;

    private readonly \GuzzleHttp\Client $client;

    const API_URL = 'https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze';

    public function __construct() {
        $this->api_key = config('app.google_comment_analyzer_key');
        $this->client = new Client;
    }

    /**
     * @throws GuzzleException
     * @throws AnalyzerException
     */
    public function getToxicityScore(string $text): ToxicityAnalyzerResponse {
        try {
            $response = $this->client->post(static::API_URL . '?key=' . $this->api_key, [
                RequestOptions::JSON => [
                    'comment' => [
                        'text' => $text,
                    ],
                    'requestedAttributes' => [
                        'TOXICITY' => new \stdClass,
                    ],
                ],
            ]);
        } catch (Exception $exception) {
            throw new AnalyzerException(sprintf('Call to Perspective API Failed: %s', $exception->getMessage()));
        }

        if ($response->getStatusCode() != 200) {
            throw new AnalyzerException(sprintf('Call to Perspective API Failed: HTTP %s', $response->getStatusCode()));
        }

        $responseContent = json_decode($response->getBody());

        return new ToxicityAnalyzerResponse($responseContent->attributeScores->TOXICITY->summaryScore->value, $response->getBody());
    }
}
