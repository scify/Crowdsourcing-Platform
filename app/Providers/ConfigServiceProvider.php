<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     */
    public function boot(): void {
        //
    }

    /**
     * Register the application services.
     */
    public function register(): void {
        $this->makeAbsoluteUrls();
    }

    /**
     * Make relative urls into absolute urls
     */
    private function makeAbsoluteUrls(): void {
        // dd(app('url')->to(\Config::get('services')['facebook']['redirect']));
        foreach (Config::get('services') as $key => $config) {
            if (! isset($config['redirect'])) {
                continue;
            }

            Config::set(sprintf('services.%s.redirect', $key), url($config['redirect']));
        }
    }
}
