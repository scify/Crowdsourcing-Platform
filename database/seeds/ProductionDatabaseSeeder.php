<?php

use Illuminate\Database\Seeder;

class ProductionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserRoleLkpTableSeeder::class,
            UsersTableSeeder::class,
            UserRolesTableSeeder::class,
            DefaultProjectSeeder::class
        ]);
    }
}
