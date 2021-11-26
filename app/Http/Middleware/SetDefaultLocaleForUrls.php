<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\URL;

use Closure;
use Illuminate\Http\Request;

class SetDefaultLocaleForUrls
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if request doesnt not contain localle get the default app locale and set it here
        // https://laravel.com/docs/8.x/urls#default-values
        $localeFromRequest = count($request->segments("locale"))>0 ? $request->segments("locale")[0] :null;
        $availableLocals = config('app.available_locales');

        $locale = app()->getLocale();
        if ($localeFromRequest)
        {
            $availableLocals = config('app.available_locales');
            if (isset($availableLocals[$localeFromRequest]))
                $locale  = $localeFromRequest;
        }

        URL::defaults(['locale' => $locale]);
        return $next($request);
    }
}
