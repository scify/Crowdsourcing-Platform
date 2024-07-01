<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot() {
        View::composer('loggedin-environment.partials.menu', 'App\ViewComposers\MenuComposer');

        View::composer('errors::layout', 'App\ViewComposers\ErrorPagesComposer');

        View::composer('partials.language-selector', 'App\ViewComposers\LanguageSelectorComposer');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {}
}
