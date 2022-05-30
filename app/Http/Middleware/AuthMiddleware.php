<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;

class AuthMiddleware extends Authenticate {

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo($request) {
        return route('login', ['locale' => app()->getLocale()]);
    }

}
