<?php

namespace App\Http\Controllers;


use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


class HomeController extends Controller
{
    private $crowdSourcingProjectManager;

    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager)
    {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
    }

    public function showHomePage()
    {
        $projects = $this->crowdSourcingProjectManager->getCrowdSourcingProjectsForHomePage();
        $pastProjects = $this->crowdSourcingProjectManager->getPastCrowdSourcingProjectsForHomePage();
        return view('home.home')->with(['projects' => $projects, 'pastProjects' => $pastProjects]);
    }

    public function showTermsAndPrivacyPage()
    {
        $locale = app()->getLocale();
        return view("privacy-policy." . $locale);
    }

    public function showCodeOfConductPage()
    {
        $goBackUrl = $this->getRedirectBackUrl();

        $locale = app()->getLocale();
        return view("code-of-conduct." . $locale)
            ->with(['goBackUrl' => $goBackUrl]);
    }

    /*
     * If referrer URL belongs to the application and is the questionnaire page,
     * provide the option to redirect back to the questionnaire.
     */
    private function getRedirectBackUrl()
    {
        $referrer = request()->headers->get('referer');
        //if referer is the questionnaire page, we will allow to redirect back.
        $goBackUrl = null;
        if ($referrer) {
            $host = parse_url($referrer, PHP_URL_HOST);
            $current_host = parse_url(env('APP_URL'), PHP_URL_HOST);
            if ($host == $current_host) {
                $route = collect(Route::getRoutes())->first(function ($route) use ($referrer) {
                    return $route->matches(request()->create($referrer));
                });
                if ($route != null && $route->getName() == "project.landing-page") {
                    $goBackUrl = $referrer;
                    if (!Str::contains($referrer, '?open'))
                        $goBackUrl .= "?open=1"; //so user can go back and open the questionnaire
                }
            }
        }
        return $goBackUrl;
    }
}
