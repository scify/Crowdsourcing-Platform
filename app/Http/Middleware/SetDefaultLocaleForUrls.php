<?php

namespace App\Http\Middleware;

use App\BusinessLogicLayer\LanguageManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetDefaultLocaleForUrls {
    protected $languageManager;

    public function __construct(LanguageManager $languageManager) {
        $this->languageManager = $languageManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        // if request doesnt not contain locale get the default app locale and set it here
        // https://laravel.com/docs/8.x/urls#default-values
        $localeFromRequest = count($request->segments('locale')) > 0 ? $request->segments('locale')[0] : null;

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
