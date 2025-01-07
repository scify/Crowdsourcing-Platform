<?php

namespace App\Providers;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectAccessManager;
use App\BusinessLogicLayer\User\UserRoleManager;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy', // example
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void {
        $this->registerPolicies();

        $permissionsManager = App::make(UserRoleManager::class);
        $permissionsManager->registerUserPolicies();

        $crowdSourcingProjectAccessManager = App::make(CrowdSourcingProjectAccessManager::class);
        $crowdSourcingProjectAccessManager->registerCrowdSourcingProjectPolicies();
    }
}
