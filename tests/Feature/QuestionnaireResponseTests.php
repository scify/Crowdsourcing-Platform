<?php

namespace Tests\Feature;

use App\BusinessLogicLayer\questionnaire\QuestionnaireResponseTranslator;
use Tests\TestCase;

class QuestionnaireResponseTests extends TestCase {
    public function test_translate_questionnaire_response() {
        $questionnaireResponseTranslator = $this->app->make(QuestionnaireResponseTranslator::class);

        self::assertTrue($questionnaireResponseTranslator->translateFreeTextAnswersForQuestionnaireResponse(922));
    }
}
