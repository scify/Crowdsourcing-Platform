<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 8/1/18
 * Time: 5:05 PM
 */

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

    public function termsAndPrivacyPage() {
        $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectViewModelForLandingPage(null,false, $this->crowdSourcingProjectManager->getDefaultCrowdsourcingProject()->slug);

        return view('terms-of-use')->with(['viewModel' => $viewModel]);
    }
}
