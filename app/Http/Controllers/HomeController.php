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

    public function index()
    {
        $projects = $this->crowdSourcingProjectManager->getAllCrowdSourcingProjects();
        $defaultProject = $this->crowdSourcingProjectManager->getDefaultCrowdsourcingProject();
        return view('home.layout')->with(['projects' => $projects, 'defaultProject' => $defaultProject]);
    }

    public function termsAndPrivacyPage() {
        $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectViewModelForLandingPage(null,false, $this->crowdSourcingProjectManager->getDefaultCrowdsourcingProject()->slug);

        return view('landingpages.partials.' . config('app.project_resources_dir') . '.terms-of-use')->with(['viewModel' => $viewModel]);
    }
}
