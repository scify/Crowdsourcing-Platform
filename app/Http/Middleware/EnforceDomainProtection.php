<?php

declare(strict_types=1);

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
        if (! app()->environment('local')) {
            $allowedDomains = [parse_url((string) config('app.url'), PHP_URL_HOST)]; // Replace with your domain
            $origin = in_array($request->headers->get('Origin'), [null, '', '0'], true) ? $request->headers->get('Referer') : $request->headers->get('Origin');

            if ($origin && ! in_array(parse_url($origin, PHP_URL_HOST), $allowedDomains)) {
                return response()->json(['error' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
            }
        }

        return $next($request);
    }
}
