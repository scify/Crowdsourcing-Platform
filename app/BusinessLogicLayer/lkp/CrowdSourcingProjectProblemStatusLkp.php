<?php

namespace App\BusinessLogicLayer\lkp;

abstract class CrowdSourcingProjectProblemStatusLkp {
    public const DRAFT = 1;
    public const PUBLISHED = 2;
    public const FINALIZED = 3;
    public const UNPUBLISHED = 4;
}
