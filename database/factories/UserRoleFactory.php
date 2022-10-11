<?php

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Models\User;
use App\Models\UserRole;
use Faker\Generator as Faker;

$factory->define(UserRole::class, function (Faker $faker) use ($factory) {
    return [
        'user_id' => $factory->create(User::class)->id,
        'role_id' => UserRolesLkp::REGISTERED_USER,
    ];
});
