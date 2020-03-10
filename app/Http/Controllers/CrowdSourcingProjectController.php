<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use JsonSchema\Exception\ResourceNotFoundException;

class CrowdSourcingProjectController extends Controller {

    private $crowdSourcingProjectManager;
    private $questionnaireShareManager;

    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager,
                                UserQuestionnaireShareManager $questionnaireShareManager) {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
        $this->questionnaireShareManager = $questionnaireShareManager;
    }

    public function index() {
        $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectsListPageViewModel();
        return view('admin.projects.index', ['viewModel' => $viewModel]);
    }

    public function create() {
        return view('admin.projects.create-edit.form-page')->with(['viewModel' => $this->crowdSourcingProjectManager->getCreateEditProjectViewModel()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit($id) {
        return view('admin.projects.create-edit.form-page')->with(['viewModel' => $this->crowdSourcingProjectManager->getCreateEditProjectViewModel($id)]);
    }

    /**
     * Create and store the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|unique:crowd_sourcing_projects,name|max:100',
            'description' => 'required|string',
            'status_id' => 'required|numeric|exists:crowd_sourcing_project_statuses_lkp,id',
            'slug' => 'nullable|string|alpha_dash|unique:crowd_sourcing_projects,slug|max:100',
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
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|string|unique:crowd_sourcing_projects,name,' . $id . '|max:100',
            'status_id' => 'required|numeric|exists:crowd_sourcing_project_statuses_lkp,id',
            'description' => 'required|string',
            'slug' => 'nullable|string|alpha_dash|unique:crowd_sourcing_projects,slug,' . $id . '|max:100',
            'language_id' => 'required|numeric|exists:languages_lkp,id'
        ]);
        $this->crowdSourcingProjectManager->updateCrowdSourcingProject($id, $request->all());
        return redirect()->to(route('projects.index'))->with('flash_message_success', 'The project\'s info have been successfully updated');
    }

    public function showLandingPage(Request $request, $project_slug) {
        try {
            if (Gate::allows('view-landing-page', $project_slug))
                return $this->showCrowdSourcingProjectLandingPage($request, $project_slug);
            abort(404);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    protected function showCrowdSourcingProjectLandingPage(Request $request, $project_slug) {
        try {
            $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectViewModelForLandingPage(
                isset($request->questionnaireId) ? $request->questionnaireId : null, $request->open, $project_slug);

            if ($this->shouldHandleQuestionnaireShare($request))
                $this->questionnaireShareManager->handleQuestionnaireShare($request->all(), $request->referrerId);

            return view('landingpages.landing-page')->with(['viewModel' => $viewModel]);
        } catch (ModelNotFoundException $e) {
            abort(404);
            return '';
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', 'Error: ' . $e->getCode() . "  " . $e->getMessage());
            return redirect()->to(route('home'));
        }
    }

    private function shouldHandleQuestionnaireShare($request) {
        return (
            isset($request->questionnaireId) &&
            isset($request->referrerId) &&
            Auth::check());
    }
}
