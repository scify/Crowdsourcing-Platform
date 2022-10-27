<?php

namespace App\Jobs;

use App\BusinessLogicLayer\questionnaire\QuestionnaireResponseTranslator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranslateQuestionnaireResponse implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected static string $QUEUE_NAME = 'questionnaire-response-translate';
    protected int $questionnaire_response_id;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $questionnaire_response_id) {
        $this->questionnaire_response_id = $questionnaire_response_id;
        $this->onQueue(self::$QUEUE_NAME);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(QuestionnaireResponseTranslator $questionnaireResponseTranslator) {
        $questionnaireResponseTranslator->translateFreeTextAnswersForQuestionnaireResponse($this->questionnaire_response_id);
    }
}
