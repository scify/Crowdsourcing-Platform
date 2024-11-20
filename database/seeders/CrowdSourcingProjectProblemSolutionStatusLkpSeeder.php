<?php

namespace Database\Seeders;

use App\Models\Problem\Solution\CrowdSourcingProjectProblemSolutionStatusLkp;
use Illuminate\Database\Seeder;

class CrowdSourcingProjectProblemSolutionStatusLkpSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $crowdsourcing_project_problem_solution_statuses_lkp = [
            ['id' => 1, 'title' => 'Published', 'description' => 'The solution is released and citizens can view it.'],
            ['id' => 2, 'title' => 'Unpublished', 'description' => 'The solution is not available online anymore.'],
        ];

        foreach ($crowdsourcing_project_problem_solution_statuses_lkp as $status) {
            CrowdSourcingProjectProblemSolutionStatusLkp::updateOrCreate(['id' => $status['id']], $status);
        }
    }
}
