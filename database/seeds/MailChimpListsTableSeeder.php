<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MailChimpListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mailchimp_lists')->delete();
        DB::table('mailchimp_lists')->insert(array(
            array(
                'id' => 1,
                'list_name' => 'Newsletter',
                'list_id' => 'efa7d0ae7e'
            ),
            array(
                'id' => 2,
                'list_name' => 'Registered Users',
                'list_id' => '4d3220b2cb'
            ),
        ));
    }
}
