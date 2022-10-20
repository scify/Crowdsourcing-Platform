<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->makeAbsoluteUrls();
    }

    /**
     * Make relative urls into absolute urls
     *
     * @return void
     */
    private function makeAbsoluteUrls() {
        //dd(app('url')->to(\Config::get('services')['facebook']['redirect']));
        foreach (Config::get('services') as $key => $config) {
            if (!isset($config['redirect'])) {
                continue;
            }
            Config::set("services.$key.redirect", url($config['redirect']));
        }
    }
}
