<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class V5Seeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call([
            LanguagesRussianMontenegrinSeeder::class
        ]);

    }
}
