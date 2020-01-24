<?php

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\Models\CrowdSourcingProject;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(CrowdSourcingProject::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->slug,
        'motto' => now(),
        'description' => $faker->text,
        'about' => $faker->text,
        'status_id' => CrowdSourcingProjectStatusLkp::DRAFT
    ];
});
