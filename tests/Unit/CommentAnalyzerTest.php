<?php

namespace Tests\Unit;

use App\BusinessLogicLayer\CommentAnalyzer\Analyzer;
use Tests\TestCase;

class CommentAnalyzerTest extends TestCase {

    protected $analyzer;


    protected function setUp(): void {
        parent::setUp();
        $this->analyzer = $this->app->make(Analyzer::class);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCommentAnalyzer() {
        $result = $this->analyzer->getToxicityResponse('what kind of idiot name is foo?');
        dd($result);
    }
}
