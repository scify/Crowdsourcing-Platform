<?php

namespace App\Repository\Solution;

use App\Models\Solution\SolutionShare;
use App\Repository\Repository;

class SolutionShareRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return SolutionShare::class;
    }

    public function getNumOfSharesForSolutionsProposedByUser($userId) {
        return SolutionShare::whereHas('solution', function ($query) use ($userId) {
            $query->where('user_creator_id', $userId);
        })->count();
    }
}
