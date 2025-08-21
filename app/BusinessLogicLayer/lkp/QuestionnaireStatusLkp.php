<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\lkp;

abstract class QuestionnaireStatusLkp {
    public const DRAFT = 1;

    public const PUBLISHED = 2;

    public const FINALIZED = 3;

    public const UNPUBLISHED = 4;

    public const DELETED = 5;

    public static function GetAllStatusIds(): array {
        return [
            self::DRAFT,
            self::PUBLISHED,
            self::FINALIZED,
            self::UNPUBLISHED,
            self::DELETED,
        ];
    }
}
