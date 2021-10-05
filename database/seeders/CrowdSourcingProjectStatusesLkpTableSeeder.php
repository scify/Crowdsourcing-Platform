<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrowdSourcingProjectStatusesLkpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('crowd_sourcing_project_statuses_lkp')->delete();
        DB::table('crowd_sourcing_project_statuses_lkp')->insert(array(
            array('id' => 1, 'title' => 'Draft', 'description' => 'The project is still under development.'),
            array('id' => 2, 'title' => 'Published', 'description' => 'The project is released and citizens can respond to it.'),
            array('id' => 3, 'title' => 'Finalized', 'description' => 'The project does not have any new questionnaires.'),
            array('id' => 4, 'title' => 'Unpublished', 'description' => 'The project is not available online anymore.'),
            array('id' => 5, 'title' => 'Deleted', 'description' => 'The project has been archived.')
        ));
    }
}
