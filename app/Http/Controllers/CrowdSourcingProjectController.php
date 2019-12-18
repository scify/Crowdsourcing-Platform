<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\gamification\GamificationManager;
use App\BusinessLogicLayer\UserManager;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use App\Models\ViewModels\AllCrowdSourcingProjects;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use JsonSchema\Exception\ResourceNotFoundException;

class CrowdSourcingProjectController extends Controller
{

    private $crowdSourcingProjectManager;
    private $questionnaireShareManager;
    private $userManager;
    private $gamificationManager;

    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager,
                                UserQuestionnaireShareManager $questionnaireShareManager,
                                UserManager $userManager, GamificationManager $gamificationManager) {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->userManager = $userManager;
        $this->gamificationManager = $gamificationManager;
    }

    public function index() {
        $projects = $this->crowdSourcingProjectManager->getAllCrowdSourcingProjects();
        $viewModel = new AllCrowdSourcingProjects($projects);
        return view('admin.projects.index', ['viewModel' => $viewModel]);
    }

    public function viewReports($projectId, Request $request) {
        $selectedProjectId = $projectId;
        $selectedQuestionnaireId = $request->questionnaireId;
        $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectReportsViewModel($selectedProjectId, $selectedQuestionnaireId);
        return view("questionnaire.reports.reports-with-filters", ['viewModel' => $viewModel]);
    }

    public function create() {
        return view('admin.projects.create-edit-project')->with(['viewModel' => $this->crowdSourcingProjectManager->getCreateProjectViewModel()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return View
     */
    public function edit($id)
    {
        return view('admin.projects.create-edit-project')->with(['viewModel' => $this->crowdSourcingProjectManager->getEditProjectViewModel($id)]);
    }

    /**
     * Create and store the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:crowd_sourcing_projects,name|max:100',
            'motto' => 'required|string',
            'slug' => 'nullable|string|alpha_dash|unique:crowd_sourcing_projects,slug|max:100',
            'about' => 'required|string',
            'footer' => 'required|string',
            'language_id' => 'required|numeric|exists:languages_lkp,id'
        ]);
        $this->crowdSourcingProjectManager->createProject($request->all());
        return redirect()->to(route('projects.index'))->with('flash_message_success', 'The project has been successfully created');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id the project id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:crowd_sourcing_projects,name,' . $id . '|max:100',
            'motto' => 'required|string',
            'slug' => 'nullable|string|alpha_dash|unique:crowd_sourcing_projects,slug,' . $id . '|max:100',
            'about' => 'required|string',
            'footer' => 'required|string',
            'language_id' => 'required|numeric|exists:languages_lkp,id'
        ]);
        $this->crowdSourcingProjectManager->updateCrowdSourcingProject($id, $request->all());
        return redirect()->back()->with('flash_message_success', 'The project\'s info have been successfully updated');
    }


    public function showLandingPage(Request $request, $project_slug) {
        try {
            $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectViewModelForLandingPage(
                isset($request->questionnaireId) ? $request->questionnaireId : null, $request->open == 1, $project_slug);
            if (isset($request->questionnaireId) && isset($request->referrerId))
                $this->questionnaireShareManager->handleQuestionnaireShare($request->all(), $this->gamificationManager, $this->userManager->getUser($request->referrerId));
            if (isset($request->referrerId))
                $this->userManager->setReferrerIdToWebSession($request->referrerId);
            return view('landingpages.landing-page')->with(['viewModel' => $viewModel]);
        } catch (ResourceNotFoundException $e) {
            abort(404);
        }
    }
}
