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
        $projectZero = $projects->get(0);
        $projects = $projects->push($projectZero);
        $projects = $projects->push($projectZero);
        $projects = $projects->push($projectZero);
        return view('crowdsourcing-landingpage.layout')->with(['projects' => $projects]);
    }
}