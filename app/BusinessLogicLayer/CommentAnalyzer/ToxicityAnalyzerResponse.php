<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\CommentAnalyzer;

class ToxicityAnalyzerResponse {
    /**
     * @var float
     */
    public $toxicityScore;

    /**
     * @var string
     */
    public $toxicityAnalyzerResponse;

    public function __construct(float $toxicityScore, string $toxicityAnalyzerResponse) {
        $this->toxicityScore = $toxicityScore;
        $this->toxicityAnalyzerResponse = $toxicityAnalyzerResponse;
    }
}
