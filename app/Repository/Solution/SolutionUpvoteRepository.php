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

    public function getNumberOfVotesForUser(int $user_id, array $solution_ids): int {
        return SolutionUpvote::whereIn('solution_id', $solution_ids)
            ->where('user_voter_id', $user_id)
            ->get()
            ->count();
    }

    public function getUpvotesForUser(int $user_id) {
        return SolutionUpvote::where('user_voter_id', $user_id)->get();
    }

    public function getNumOfUpvotesForSolutionsProposedByUser(int $user_id): int {
        return SolutionUpvote::whereHas('solution', function ($query) use ($user_id) {
            $query->where('user_voter_id', $user_id);
        })->count();
    }
}
