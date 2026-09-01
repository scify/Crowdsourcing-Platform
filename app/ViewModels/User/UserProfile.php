<?php

declare(strict_types=1);

namespace App\ViewModels\User;

use App\BusinessLogicLayer\enums\CountryEnum;
use App\BusinessLogicLayer\enums\GenderEnum;
use App\Models\User\User;

class UserProfile {
    /**
     * @var User
     */
    public $user;

    /** @var list<GenderEnum>|null */
    public ?array $availableGenders = null;

    /** @var list<CountryEnum>|null */
    public ?array $availableCountries = null;

    /** @var list<int>|null */
    public ?array $availableYearsOfBirth = null;

    public function __construct(User $user) {
        $this->user = $user;
    }
}
