<?php

namespace App\Repository\Solution;

use App\Models\Solution\SolutionUpvote;
use App\Repository\Repository;

class SolutionUpvoteRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return SolutionUpvote::class;
    }
}
