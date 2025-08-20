<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RouteServiceProvider extends ServiceProvider {
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void {
        // Define rate limiters BEFORE parent::boot() and before routes are loaded
        $api_throttles = [
            [
                'name' => 'api-internal',
                'limit_per_minute' => 1000,
            ],
            [
                'name' => 'api-public',
                'limit_per_minute' => 30,
            ],
        ];

        foreach ($api_throttles as $throttle) {
            $name = $throttle['name'];
            $limit = $throttle['limit_per_minute'];
            RateLimiter::for($name, fn (Request $request) => Limit::perMinute($limit)
                ->by(optional($request->user())->id ?: $request->ip())
                ->response(fn () => response()->json(['status' => 'Too many requests!'], ResponseAlias::HTTP_TOO_MANY_REQUESTS))
            );
        }

        // /validate the locale parameter
        $regexForLocalParameter = config('app.regex_for_validating_locale_at_routes');
        Route::pattern('locale', $regexForLocalParameter);

        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes() {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes() {
        Route::middleware('api')
            ->prefix('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
