<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('crowd_sourcing_projects')->insert(array(
            array('id' => 1,
                'name' => 'FAIR EU',
                'slug' => 'fair-eu',
                'logo_path' => '/images/default-project/fair-eu.png',
                'img_path' => '/images/default-project/fair-eu-bg.png',
                'motto' => 'Tackle the obstacles of low political participation levels',
                'label1' => '',
                'label2' => '',
                'description' => '',
                'user_creator_id' => 1
            ),
        ));
    }
}
