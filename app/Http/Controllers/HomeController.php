<?php

namespace App\Http\Controllers;


use App\BusinessLogicLayer\CrowdSourcingProjectManager;

class HomeController extends Controller
{
    private $crowdSourcingProjectManager;

    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager)
    {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
    }

    public function showHomePage()
    {
        $projects = $this->crowdSourcingProjectManager->getAllCrowdSourcingProjects();
        return view('home.layout')->with(['projects' => $projects]);
    }
}
