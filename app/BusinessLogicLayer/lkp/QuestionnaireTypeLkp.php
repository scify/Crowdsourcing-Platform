<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\lkp;

class QuestionnaireTypeLkp {
    public const MAIN_QUESTIONNAIRE = 1;

    public const FEEDBACK_QUESTIONNAIRE = 2;

    public static function GetAllTypeIds(): array {
        return [
            self::MAIN_QUESTIONNAIRE,
            self::FEEDBACK_QUESTIONNAIRE,
        ];
    }
}
