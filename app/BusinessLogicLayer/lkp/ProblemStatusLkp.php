<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\lkp;

abstract class ProblemStatusLkp {
    public const DRAFT = 1;

    public const PUBLISHED = 2;

    public const FINALIZED = 3;

    public const UNPUBLISHED = 4;
}
