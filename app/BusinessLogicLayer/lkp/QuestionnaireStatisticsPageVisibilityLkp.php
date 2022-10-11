<?php

namespace App\BusinessLogicLayer\lkp;

// these values must be the same as @class database/seeds/QuestionnaireStatisticsPageVisibilityLkpSeeder
abstract class QuestionnaireStatisticsPageVisibilityLkp {
    public const PUBLIC = 1;
    public const RESPONDENTS_ONLY = 2;
    public const ADMIN_AND_CONTENT_MANAGERS_ONLY = 3;
}
