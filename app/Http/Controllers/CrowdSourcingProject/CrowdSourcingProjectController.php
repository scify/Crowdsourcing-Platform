<?php

namespace App\Http\Controllers\CrowdSourcingProject;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\User\UserQuestionnaireShareManager;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CrowdSourcingProjectController extends Controller {
    public function __construct(private readonly CrowdSourcingProjectManager $crowdSourcingProjectManager, private readonly UserQuestionnaireShareManager $questionnaireShareManager) {}

    public function index() {
        $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectsListPageViewModel();

        return view('backoffice.management.crowdsourcing-project.index', ['viewModel' => $viewModel]);
    }

    public function create() {
        return view('backoffice.management.crowdsourcing-project.create-edit.form-page')->with(['viewModel' => $this->crowdSourcingProjectManager->getCreateEditProjectViewModel()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $locale, int $id): View {
        return view('backoffice.management.crowdsourcing-project.create-edit.form-page')->with(['viewModel' => $this->crowdSourcingProjectManager->getCreateEditProjectViewModel($id)]);
    }

    /**
     * Create and store the specified resource in storage.
     *
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'status_id' => 'required|numeric|exists:crowd_sourcing_project_statuses_lkp,id',
            'slug' => 'nullable|string|alpha_dash|unique:crowd_sourcing_projects,slug|max:100',
            'language_id' => 'required|numeric|exists:languages_lkp,id',
            'motto_title' => 'required|string',
            'motto_subtitle' => 'required|string',
            'about' => 'nullable|string',
        ]);
        $project = $this->crowdSourcingProjectManager->storeProject($request->all());

        return redirect()->route('projects.edit', $project->id)->with('flash_message_success', 'The project has been successfully created');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id the project id
     *
     * @throws ValidationException
     */
    public function update(Request $request, string $locale, int $id): RedirectResponse {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'status_id' => 'required|numeric|exists:crowd_sourcing_project_statuses_lkp,id',
            'description' => 'required|string',
            'slug' => 'nullable|string|alpha_dash|unique:crowd_sourcing_projects,slug,' . $id . '|max:100',
            'language_id' => 'required|numeric|exists:languages_lkp,id',
            'motto_title' => 'required|string',
            'motto_subtitle' => 'required|string',
            'about' => 'nullable|string',
        ]);
        $attributes = $request->all();
        try {
            $this->crowdSourcingProjectManager->updateProject($id, $attributes);
        } catch (\Exception $e) {
            return back()->with('flash_message_error', $e->getMessage());
        }

        return back()->with('flash_message_success', 'The project has been successfully updated');
    }

    public function showLandingPage(Request $request) {
        $data = [
            'project_slug' => $request->slug,
        ];
        $validator = Validator::make($data, [
            'project_slug' => 'required|different:execute_solution|exists:crowd_sourcing_projects,slug',
        ]);
        if ($validator->fails()) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
        try {
            $project_slug = $request->slug;
            if (Gate::allows('view-landing-page', $project_slug)) {
                return $this->showCrowdSourcingProjectLandingPage($request, $project_slug);
            }

            return view('crowdsourcing-project.project-unavailable')
                ->with(['viewModel' => $this->crowdSourcingProjectManager->
                getUnavailableCrowdSourcingProjectViewModelForLandingPage($project_slug), ]);
        } catch (ModelNotFoundException) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }

        return null;
    }

    protected function showCrowdSourcingProjectLandingPage(Request $request, string $project_slug) {
        try {
            $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectViewModelForLandingPage(
                $request->questionnaireId ?? null,
                $project_slug);
            // if the project's default language is other than English, we need to set the locale to the project's language
            $project_default_lang_code = $viewModel->project?->defaultTranslation?->language?->language_code;
            if ($project_default_lang_code !== 'en') {
                app()->setLocale($project_default_lang_code);
            }

            if ($this->shouldHandleQuestionnaireShare($request)) {
                $this->questionnaireShareManager->handleQuestionnaireShare($request->all(), $request->referrerId);
            }

            return view('crowdsourcing-project.landing-page')->with(['viewModel' => $viewModel]);
        } catch (\Exception $e) {
            session()->flash('flash_message_error', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());

            return redirect()->to(route('home', ['locale' => app()->getLocale()]));
        }
    }

    private function shouldHandleQuestionnaireShare(\Illuminate\Http\Request $request): bool {
        return
            property_exists($request, 'questionnaireId') && $request->questionnaireId !== null &&
            (property_exists($request, 'referrerId') && $request->referrerId !== null);
    }

    public function clone(Request $request): RedirectResponse {
        $newProject = $this->crowdSourcingProjectManager->cloneProject($request->id);

        return redirect()->action(
            [self::class, 'edit'], ['project' => $newProject->id]
        );
    }

    public function getCrowdSourcingProjectsForManagement(): JsonResponse {
        return response()->json($this->crowdSourcingProjectManager->getCrowdSourcingProjectsForManagement());
    }
}
