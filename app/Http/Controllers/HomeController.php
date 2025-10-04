<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class HomeController extends Controller {
    public function __construct(private readonly CrowdSourcingProjectManager $crowdSourcingProjectManager) {}

    public function showHomePage() {
        $projects = $this->crowdSourcingProjectManager->getCrowdSourcingProjectsForHomePage();

        return view('home.home')->with(['projects' => $projects]);
    }

    public function showTermsAndPrivacyPage(): View|Factory {
        $locale = app()->getLocale();
        if (view()->exists('privacy-policy.' . $locale)) {
            return view('privacy-policy.' . $locale);
        }

        return view('privacy-policy.en');
    }

    public function showCodeOfConductPage() {
        $goBackUrl = $this->getRedirectBackUrl();

        $locale = app()->getLocale();
        if (view()->exists('code-of-conduct.' . $locale)) {
            return view('code-of-conduct.' . $locale)
                ->with(['goBackUrl' => $goBackUrl]);
        }

        return view('code-of-conduct.en')
            ->with(['goBackUrl' => $goBackUrl]);
    }

    /*
     * If referrer URL belongs to the application and is the questionnaire page,
     * provide the option to redirect back to the questionnaire.
     */
    public function getRedirectBackUrl(): string {
        $referrer = request()->headers->get('referer');
        if (! $referrer) {
            return route('home', ['locale' => app()->getLocale()]);
        }

        $host = parse_url($referrer, PHP_URL_HOST);
        $currentHost = parse_url((string) config('app.url'), PHP_URL_HOST);

        if ($host !== $currentHost) {
            return route('home', ['locale' => app()->getLocale()]);
        }

        $route = collect(Route::getRoutes())->first(fn ($route) => $route->matches(request()->create($referrer)));
        if ($route && $route->getName() === 'project.landing-page') {
            return Str::contains($referrer, '?open') ? $referrer : $referrer . '?open=1';
        }

        return $referrer;
    }
}
