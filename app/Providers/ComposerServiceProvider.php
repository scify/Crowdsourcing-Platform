<?php

declare(strict_types=1);

namespace App\Providers;

use App\ViewComposers\ErrorPagesComposer;
use App\ViewComposers\LanguageSelectorComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {
    /**
     * Register bindings in the container.
     */
    public function boot(): void {
        View::composer('errors::layout', ErrorPagesComposer::class);

        View::composer('partials.language-selector', LanguageSelectorComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {}
}
