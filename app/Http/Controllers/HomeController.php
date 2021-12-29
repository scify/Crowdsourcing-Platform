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
        $locale = app()->getLocale();
        return view("code-of-conduct.".$locale);
    }
}
