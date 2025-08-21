<?php

declare(strict_types=1);

namespace App\Jobs;

use App\BusinessLogicLayer\Questionnaire\QuestionnaireResponseTranslator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranslateQuestionnaireResponse implements ShouldQueue {
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected static string $QUEUE_NAME = 'questionnaire-response-translate';

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

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
    public function handle(QuestionnaireResponseTranslator $questionnaireResponseTranslator): void {
        $questionnaireResponseTranslator->translateFreeTextAnswersForQuestionnaireResponse($this->questionnaire_response_id);
    }
}
