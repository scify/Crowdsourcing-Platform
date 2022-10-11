<?php

namespace App\BusinessLogicLayer\CommentAnalyzer;

class ToxicityAnalyzerResponse {
    public $toxicityScore;
    public $toxicityAnalyzerResponse;

    public function __construct(float $toxicityScore, string $toxicityAnalyzerResponse) {
        $this->toxicityScore = $toxicityScore;
        $this->toxicityAnalyzerResponse = $toxicityAnalyzerResponse;
    }
}
