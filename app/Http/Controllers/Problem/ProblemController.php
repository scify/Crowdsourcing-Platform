<?php

namespace App\Http\Controllers\Problem;

use App\BusinessLogicLayer\Problem\ProblemManager;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProblemController extends Controller {
    private ProblemManager $problemManager;

    public function __construct(ProblemManager $problemManager) {
        $this->problemManager = $problemManager;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): View {
        // $viewModel = $this->crowdSourcingProjectProblemManager->getCrowdSourcingProjectProblemViewModel($slug);

        // return view('crowdsourcing-project.problems.show', ['viewModel' => $viewModel]);
        return 'test';
    }

    public function showProblemsPage(Request $request): View {
        $validator = Validator::make([
            'project_slug' => $request->project_slug,
        ], [
            'project_slug' => 'required|different:execute_solution|exists:crowd_sourcing_projects,slug',
        ]);
        if ($validator->fails()) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
        try {
            $viewModel = $this->problemManager->getProblemsLandingPageViewModel($request->project_slug);

            return view('problem.landing-page', ['viewModel' => $viewModel]);
        } catch (ModelNotFoundException $e) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View {
        return view('backoffice.management.problem.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
        $viewModel = $this->problemManager->getCreateEditProblemViewModel();

        return view('backoffice.management.problem.create-edit.form-page', ['viewModel' => $viewModel]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        $this->validate($request, [ // bookmark2
            'problem-title' => ['required', 'string', 'max:100'],
            'problem-description' => ['required', 'string', 'max:400'],
            'problem-status' => ['required'], // bookmark2
            'problem-default-language' => ['required'], // bookmark2
            'problem-image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'problem-owner-project' => ['required'],
        ]);

        $attributes = $request->all();

        try {
            $createdProblemId = $this->problemManager->storeProblem($attributes);
        } catch (\Exception $e) {
            session()->flash('flash_message_error', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());

            return back()->withInput();
        }

        session()->flash('flash_message_success', 'Problem Created Successfully.');

        $route = route('problems.edit', ['problem' => $createdProblemId]) . '?translations=1';

        return redirect($route);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $locale, int $id): View {
        $viewModel = $this->problemManager->getCreateEditProblemViewModel($id);

        return view('backoffice.management.problem.create-edit.form-page', ['viewModel' => $viewModel]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $locale, int $id) {
        $this->validate($request, [ // bookmark2
            'problem-title' => ['required', 'string', 'max:100'],
            'problem-description' => ['required', 'string', 'max:400'],
            'problem-status' => ['required'], // bookmark2
            'problem-default-language' => ['required'], // bookmark2
            'problem-slug' => 'required|string|alpha_dash|unique:problems,slug,' . $id . '|max:111',
            'problem-image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'problem-owner-project' => ['required'],
        ]);

        $attributes = $request->all();

        try {
            $this->problemManager->updateProblem($id, $attributes);
        } catch (\Exception $e) {
            session()->flash('flash_message_error', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());

            return back()->withInput();
        }

        session()->flash('flash_message_success', 'The problem has been successfully updated.');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $locale, int $id) {
        return $this->problemManager->deleteProblem($id);
    }

    public function getProblemStatusesForManagementPage(): JsonResponse {
        return response()->json($this->problemManager->getProblemStatusesForManagementPage());
    }

    public function updateStatus(Request $request, string $locale, int $id): JsonResponse {
        $this->validate($request, [
            'status_id' => 'required|exists:problem_statuses_lkp,id',
        ]);

        return response()->json($this->problemManager->updateProblemStatus($id, $request->status_id));
    }

    public function getProblemsForCrowdSourcingProjectForManagement(): JsonResponse {
        $this->validate(request(), [
            'projectId' => 'required|numeric|exists:crowd_sourcing_projects,id',
        ]);

        return response()->json($this->problemManager->getProblemsForCrowdSourcingProjectForManagement(request('projectId')));
    }

    public function getProblemsForCrowdSourcingProject(Request $request): JsonResponse {
        $this->validate($request, [
            'projectId' => 'required|numeric|exists:crowd_sourcing_projects,id',
        ]);

        return response()->json($this->problemManager->getProblemsForCrowdSourcingProjectForLandingPage($request->projectId, app()->getLocale()));
    }
}
