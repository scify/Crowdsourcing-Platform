<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;

class AuthMiddleware extends Authenticate {
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     *
     * @return string|null
     */
    protected function redirectTo($request) {
        $params = ['locale' => app()->getLocale()];

        if (! $request->query('redirectTo')) {
            $params['redirectTo'] = $request->fullUrl();
        }

        return route('login', $params);
    }
}
