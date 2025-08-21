<?php

declare(strict_types=1);

namespace App\Jobs;

use App\BusinessLogicLayer\Questionnaire\QuestionnaireResponseToxicityAnalyzer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyzeQuestionnaireResponseToxicity implements ShouldQueue {
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected static $QUEUE_NAME = 'questionnaire-response-analyze-toxicity';

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected int $questionnaire_response_id) {
        $this->onQueue(self::$QUEUE_NAME);
    }

    /**
     * Execute the job.
     */
    public function handle(QuestionnaireResponseToxicityAnalyzer $questionnaireResponseToxicityAnalyzer): void {
        $questionnaireResponseToxicityAnalyzer->analyzeQuestionnaireResponse($this->questionnaire_response_id);
    }
}
