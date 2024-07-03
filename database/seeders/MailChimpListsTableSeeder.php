<?php

namespace Database\Seeders;

use App\Models\MailChimpList;
use Illuminate\Database\Seeder;

class MailChimpListsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $mailchimp_lists = [
            [
                'id' => 1,
                'list_name' => 'Newsletter',
                'list_id' => 'efa7d0ae7e',
            ],
            [
                'id' => 2,
                'list_name' => 'Registered Users',
                'list_id' => '4d3220b2cb',
            ],
        ];

        foreach ($mailchimp_lists as $list) {
            MailChimpList::updateOrCreate(['id' => $list['id']], $list);
        }
    }
}
