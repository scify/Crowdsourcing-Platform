<?php

namespace App\Http\Controllers\Solution;

use App\BusinessLogicLayer\Solution\SolutionManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SolutionController extends Controller {
    protected SolutionManager $solutionManager;

    public function __construct(SolutionManager $solutionManager) {
        $this->solutionManager = $solutionManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View {
        return view('backoffice.management.solution.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View|RedirectResponse {
        $this->validate($request, [
            'problem_id' => 'required|different:execute_solution|exists:problems,id',
        ]);
        try {
            $viewModel = $this->solutionManager->getCreateEditSolutionViewModel($request->problem_id);

            return view('backoffice.management.solution.create-edit.form-page', ['viewModel' => $viewModel]);
        } catch (\Exception $e) {
            session()->flash('flash_message_error', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());

            return back()->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        $validated = $this->validate($request, [
            'solution-title' => ['required', 'string', 'max:100'],
            'solution-description' => ['required', 'string', 'max:400'],
            'solution-status' => ['required'],
            'solution-image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'solution-owner-problem' => ['required'],
        ]);

        try {
            $createdSolutionId = $this->solutionManager->storeSolution($validated)->id;
        } catch (\Exception $e) {
            session()->flash('flash_message_error', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());

            return back()->withInput();
        }

        session()->flash('flash_message_success', 'Solution Created Successfully.');

        $route = route('solutions.edit', ['solution' => $createdSolutionId]) . '?translations=1';

        return redirect($route);
    }

    public function userProposalStore(Request $request): RedirectResponse {
        $validated = $this->validate($request, [
            'solution-title' => ['required', 'string', 'max:100'],
            'solution-description' => ['required', 'string', 'max:400'],
            'solution-image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'solution-owner-problem' => ['required'],
        ]);

        try {
            $solution = $this->solutionManager->storeSolutionFromPublicForm($validated);
            $problem = $solution->problem;
            $project = $problem->project;

            $route = route('solutions.user-proposal-submitted', [
                'project_slug' => $project->slug,
                'problem_slug' => $problem->slug,
                'solution_slug' => $solution->slug,
            ]);

            return redirect($route);
        } catch (\Exception $e) {
            session()->flash('flash_message_error', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());

            return back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $locale, int $id) {
        $validator = Validator::make([
            'solution_id' => $id,
        ], [
            'solution_id' => 'required|different:execute_solution|exists:solutions,id',
        ]);
        if ($validator->fails()) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
        try {
            $viewModel = $this->solutionManager->getCreateEditSolutionViewModel(null, $id);

            return view('backoffice.management.solution.create-edit.form-page', ['viewModel' => $viewModel]);
        } catch (\Exception $e) {
            session()->flash('flash_message_error', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());

            return back()->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $locale, int $id) {
        $validated = $this->validate($request, [
            'solution-title' => ['required', 'string', 'max:100'],
            'solution-description' => ['required', 'string', 'max:400'],
            'solution-status' => ['required'],
            'solution-slug' => 'required|string|alpha_dash|unique:solutions,slug,' . $id . '|max:111',
            'solution-image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'solution-owner-problem' => ['required'],
        ]);

        try {
            $this->solutionManager->updateSolution($id, $validated);
        } catch (\Exception $e) {
            session()->flash('flash_message_error', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());

            return back()->withInput();
        }

        session()->flash('flash_message_success', 'The problem has been successfully updated.');

        return back();
    }

    public function updateStatus(Request $request, int $id): JsonResponse {
        $this->validate($request, [
            'status_id' => 'required|exists:problem_statuses_lkp,id',
        ]);

        return response()->json($this->solutionManager->updateSolutionStatus($id, $request->status_id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $locale, int $id) {
        return $this->solutionManager->deleteSolution($id);
    }

    public function getSolutionStatusesForManagementPage(): JsonResponse {
        return response()->json($this->solutionManager->getSolutionStatusesForManagementPage());
    }

    public function getFilteredSolutionsForManagement(): JsonResponse {
        $this->validate(request(), [
            'filters' => 'required',
        ]);

        return response()->json($this->solutionManager->getFilteredSolutionsForManagement(request('filters')));
    }

    public function getSolutions(Request $request): JsonResponse {
        $this->validate(request(), [
            'problem_id' => 'required|exists:problems,id',
        ]);

        return response()->json([
            'user_votes' => $this->solutionManager->getUserVotesNum($request->problem_id),
            'solutions' => $this->solutionManager->getSolutions($request->problem_id),
        ]);
    }

    public function userProposalCreate(string $locale, string $project_slug, string $problem_slug): View|RedirectResponse {
        $validator = Validator::make([
            'project_slug' => $project_slug,
            'problem_slug' => $problem_slug,
        ], [
            'project_slug' => 'required|different:execute_solution|exists:crowd_sourcing_projects,slug',
            'problem_slug' => 'required|different:execute_solution|exists:problems,slug',
        ]);
        if ($validator->fails()) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
        try {
            $viewModel = $this->solutionManager->getProposeSolutionPageViewModel($locale, $project_slug, $problem_slug);

            return view('solution.propose', ['viewModel' => $viewModel]);
        } catch (\Exception $e) {
            session()->flash('flash_message_error', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());

            return back()->withInput();
        }
    }

    public function userProposalSubmitted(string $locale, string $project_slug, string $problem_slug, string $solution_slug): View {
        $validator = Validator::make([
            'project_slug' => $project_slug,
            'problem_slug' => $problem_slug,
            'solution_slug' => $solution_slug,
        ], [
            'solution_slug' => 'required|exists:solutions,slug',
            'problem_slug' => 'required|exists:problems,slug',
            'project_slug' => 'required|exists:crowd_sourcing_projects,slug',
        ]);

        if ($validator->fails()) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
        $viewModel = $this->solutionManager->getSolutionSubmittedViewModel($project_slug, $problem_slug, $solution_slug);

        return view('solution.submitted', ['viewModel' => $viewModel]);
    }

    public function voteOrDownVoteSolution(Request $request): JsonResponse {
        $this->validate($request, [
            'solution_id' => 'required|exists:solutions,id',
        ]);

        return response()->json($this->solutionManager->voteOrDownVoteSolution($request->solution_id));
    }

    public function handleShareSolution(Request $request): JsonResponse {
        $this->validate($request, [
            'solution_id' => 'required|exists:solutions,id',
        ]);

        return response()->json($this->solutionManager->handleShareSolution($request->solution_id));
    }
}
