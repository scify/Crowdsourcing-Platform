<?php

declare(strict_types=1);

namespace App\ViewModels\User;

use App\BusinessLogicLayer\enums\CountryEnum;
use App\BusinessLogicLayer\enums\GenderEnum;

class ManageUsers {
    /** @var list<GenderEnum>|null */
    public ?array $availableGenders = null;

    /** @var list<CountryEnum>|null */
    public ?array $availableCountries = null;

    /** @var list<int>|null */
    public ?array $availableYearsOfBirth = null;

    public function __construct(public $users, public $allRoles) {}
}
