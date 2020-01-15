<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\UserManager;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use JsonSchema\Exception\ResourceNotFoundException;

class CrowdSourcingProjectController extends Controller
{

    private $crowdSourcingProjectManager;
    private $questionnaireShareManager;
    private $userManager;

    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager,
                                UserQuestionnaireShareManager $questionnaireShareManager,
                                UserManager $userManager) {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->userManager = $userManager;
    }

    public function index() {
        $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectsListPageViewModel();
        return view('admin.projects.index', ['viewModel' => $viewModel]);
    }

    public function viewReports($projectId, Request $request) {
        $selectedProjectId = $projectId;
        $selectedQuestionnaireId = $request->questionnaireId;
        $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectReportsViewModel($selectedProjectId, $selectedQuestionnaireId);
        return view("questionnaire.reports.reports-with-filters", ['viewModel' => $viewModel]);
    }

    public function create() {
        return view('admin.projects.create-edit')->with(['viewModel' => $this->crowdSourcingProjectManager->getCreateEditProjectViewModel()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return View
     */
    public function edit($id)
    {
        return view('admin.projects.create-edit')->with(['viewModel' => $this->crowdSourcingProjectManager->getCreateEditProjectViewModel($id)]);
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
            'status_id' => 'required|numeric|exists:crowd_sourcing_project_statuses_lkp,id',
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
            'status_id' => 'required|numeric|exists:crowd_sourcing_project_statuses_lkp,id',
            'slug' => 'nullable|string|alpha_dash|unique:crowd_sourcing_projects,slug,' . $id . '|max:100',
            'about' => 'required|string',
            'footer' => 'required|string',
            'language_id' => 'required|numeric|exists:languages_lkp,id'
        ]);
        $this->crowdSourcingProjectManager->updateCrowdSourcingProject($id, $request->all());
        return redirect()->to(route('projects.index'))->with('flash_message_success', 'The project\'s info have been successfully updated');
    }

    public function showLandingPage(Request $request, $project_slug) {
        if($this->crowdSourcingProjectManager->shouldShowLandingPage($project_slug))
            return $this->showCrowdSourcingProjectLandingPage($request, $project_slug);
        return $this->showProjectUnavailablePage($project_slug);
    }

    protected function showCrowdSourcingProjectLandingPage(Request $request, $project_slug) {
        try {
            $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectViewModelForLandingPage(
                isset($request->questionnaireId) ? $request->questionnaireId : null, $request->open, $project_slug);
            if (isset($request->questionnaireId) && isset($request->referrerId))
                $this->questionnaireShareManager->handleQuestionnaireShare($request->all(), $this->userManager->getUser($request->referrerId));
            if (isset($request->referrerId))
                $this->userManager->setReferrerIdToWebSession($request->referrerId);
            return view('landingpages.landing-page')->with(['viewModel' => $viewModel]);
        } catch (ResourceNotFoundException $e) {
            abort(404);
            return '';
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', 'Error: ' . $e->getCode() . "  " . $e->getMessage());
            return redirect()->to(route('home'));
        }
    }

    protected function showProjectUnavailablePage($project_slug) {
        try {
            return view('landingpages.project-unavailable')
                ->with(['viewModel' => $this->crowdSourcingProjectManager->getCrowdSourcingProjectUnavailableViewModel($project_slug)]);
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', 'Error: ' . $e->getCode() . "  " . $e->getMessage());
            return redirect()->to(route('home'));
        }
    }
}
