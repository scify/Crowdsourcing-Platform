<?php

namespace App\Http\Controllers;


use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;

class HomeController extends Controller {
    private $crowdSourcingProjectManager;

    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager) {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
    }

    public function showHomePage() {
        $projects = $this->crowdSourcingProjectManager->getCrowdSourcingProjectsForHomePage();
        $pastProjects = $this->crowdSourcingProjectManager->getPastCrowdSourcingProjectsForHomePage();
        return view('home.home')->with(['projects' => $projects, 'pastProjects' => $pastProjects]);
    }

    public function showTermsAndPrivacyPage() {
        $locale = app()->getLocale();
        return view("privacy-policy.".$locale);
    }
    public function showCodeOfConductPage(){

        $referrer =  request()->headers->get('referer');
        //if refferer is the questionnaire page, we will allow to redirect back.
        if ($referrer)
            $goBackUrl = $referrer . "?open=1";

        $locale = app()->getLocale();
        return view("code-of-conduct.".$locale)
                ->with(['goBackUrl' => $goBackUrl]);
    }
}
