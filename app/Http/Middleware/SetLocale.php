<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale {
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        // get the locale from the first parameter
        $localeToTry = $request->segment(1);
        $locale = null;
        // if locale is not in the accepted ones, set the default locale (English)
        $acceptedLocales = explode('|', config('app.regex_for_validating_locale_at_routes'));
        foreach ($acceptedLocales as $acceptedLocale) {
            if ($localeToTry === $acceptedLocale) {
                $locale = $localeToTry;
                break;
            }
        }
        if (!$locale) {
            $locale = 'en';
        }
        app()->setLocale($locale);

        return $next($request);
    }
}
