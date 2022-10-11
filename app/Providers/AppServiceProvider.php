<?php

namespace App\Providers;

use App\BusinessLogicLayer\CommentAnalyzer\GooglePerspectiveAPIService;
use App\BusinessLogicLayer\CommentAnalyzer\ToxicityAnalyzerService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton(ToxicityAnalyzerService::class, function ($app) {
            return new GooglePerspectiveAPIService();
        });
    }
}
