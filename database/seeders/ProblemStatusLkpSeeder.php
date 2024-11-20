<?php

namespace Database\Seeders;

use App\Models\Problem\ProblemStatusLkp;
use Illuminate\Database\Seeder;

class ProblemStatusLkpSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $crowdsourcing_project_problem_statuses_lkp = [
            ['id' => 1, 'title' => 'Draft', 'description' => 'The problem is still under development.'],
            ['id' => 2, 'title' => 'Published', 'description' => 'The problem is released and citizens can respond to it.'],
            ['id' => 3, 'title' => 'Finalized', 'description' => 'The problem does not have any new solutions.'],
            ['id' => 4, 'title' => 'Unpublished', 'description' => 'The problem is not available online anymore.'],
        ];

        foreach ($crowdsourcing_project_problem_statuses_lkp as $status) {
            ProblemStatusLkp::updateOrCreate(['id' => $status['id']], $status);
        }
    }
}
