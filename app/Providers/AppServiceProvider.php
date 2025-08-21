<?php

declare(strict_types=1);

namespace App\Providers;

use App\BusinessLogicLayer\CommentAnalyzer\GooglePerspectiveAPIService;
use App\BusinessLogicLayer\CommentAnalyzer\ToxicityAnalyzerService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
    }

    /**
     * Register any application services.
     */
    public function register(): void {
        $this->app->singleton(ToxicityAnalyzerService::class, fn ($app): \App\BusinessLogicLayer\CommentAnalyzer\GooglePerspectiveAPIService => new GooglePerspectiveAPIService);
    }
}
