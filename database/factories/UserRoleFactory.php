<?php

namespace Database\Factories;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserRoleFactory extends Factory {
    protected $model = UserRole::class;

    public function definition() {
        return [
            'user_id' => User::factory()->create()->id,
            'role_id' => UserRolesLkp::REGISTERED_USER,
        ];
    }
}
