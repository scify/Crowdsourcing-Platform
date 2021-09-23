<?php

namespace Tests\Unit;

use App\BusinessLogicLayer\CommentAnalyzer\GooglePerspectiveAPIService;
use App\BusinessLogicLayer\CommentAnalyzer\ToxicityAnalyzerService;
use Tests\TestCase;

class CommentAnalyzerTest extends TestCase {

    protected $analyzer;


    protected function setUp(): void {
        parent::setUp();
        $this->analyzer = $this->app->make(ToxicityAnalyzerService::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCommentAnalyzer() {
        $result = $this->analyzer->getToxicityScore('what kind of idiot name is foo?');
        self::assertIsFloat($result->toxicityScore);
    }
}
