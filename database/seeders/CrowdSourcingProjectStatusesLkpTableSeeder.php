<?php

namespace Database\Seeders;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectStatusLkp;
use Illuminate\Database\Seeder;

class CrowdSourcingProjectStatusesLkpTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $crowdsourcing_project_statuses_lkp = [
            ['id' => 1, 'title' => 'Draft', 'description' => 'The project is still under development.'],
            ['id' => 2, 'title' => 'Published', 'description' => 'The project is released and citizens can respond to it.'],
            ['id' => 3, 'title' => 'Finalized', 'description' => 'The project does not have any new questionnaires.'],
            ['id' => 4, 'title' => 'Unpublished', 'description' => 'The project is not available online anymore.'],
            ['id' => 5, 'title' => 'Deleted', 'description' => 'The project has been archived.'],
        ];

        foreach ($crowdsourcing_project_statuses_lkp as $status) {
            CrowdSourcingProjectStatusLkp::updateOrCreate(['id' => $status['id']], $status);
        }
    }
}
