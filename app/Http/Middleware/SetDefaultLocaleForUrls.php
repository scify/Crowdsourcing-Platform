<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\BusinessLogicLayer\LanguageManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetDefaultLocaleForUrls {
    public function __construct(protected LanguageManager $languageManager) {}

    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        // if request doesnt not contain locale get the default app locale and set it here
        // https://laravel.com/docs/8.x/urls#default-values
        $localeFromRequest = count($request->segments()) > 0 ? $request->segments()[0] : null;

        $locale = app()->getLocale();
        if ($localeFromRequest) {
            $language = $this->languageManager->getLanguageByCode($localeFromRequest);
            if ($language) {
                $locale = $localeFromRequest;
            }
        }

        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
