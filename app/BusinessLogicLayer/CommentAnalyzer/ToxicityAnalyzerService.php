<?php

namespace App\BusinessLogicLayer\CommentAnalyzer;

interface ToxicityAnalyzerService {
    public function getToxicityScore(string $text): ToxicityAnalyzerResponse;
}
