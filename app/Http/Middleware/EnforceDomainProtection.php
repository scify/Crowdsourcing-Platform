<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceDomainProtection {
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        if (!app()->environment('local')) {
            $allowedDomains = [parse_url(config('app.url'), PHP_URL_HOST)]; // Replace with your domain
            $origin = $request->headers->get('Origin') ?: $request->headers->get('Referer');

            if ($origin && !in_array(parse_url($origin, PHP_URL_HOST), $allowedDomains)) {
                return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
            }
        }

        return $next($request);
    }
}
