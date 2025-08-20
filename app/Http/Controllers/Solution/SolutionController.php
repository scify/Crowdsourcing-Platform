<?php

declare(strict_types=1);

namespace App\Http\Controllers\Solution;

use App\BusinessLogicLayer\Solution\SolutionManager;
use App\Http\Controllers\Controller;
use App\Rules\ReCaptchaV3;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SolutionController extends Controller {
    public function __construct(protected SolutionManager $solutionManager) {}

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
        } catch (\Exception $exception) {
            session()->flash('flash_message_error', 'Error: ' . $exception->getCode() . '  ' . $exception->getMessage());

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
        } catch (\Exception $exception) {
            session()->flash('flash_message_error', 'Error: ' . $exception->getCode() . '  ' . $exception->getMessage());

            return back()->withInput();
        }

        session()->flash('flash_message_success', 'Solution Created Successfully.');

        $route = route('solutions.edit', ['solution' => $createdSolutionId]) . '?translations=1';

        return redirect($route);
    }

    public function userProposalStore(Request $request): RedirectResponse {
        $validated = $this->validate($request, [
            'solution-title' => ['required', 'string', 'max:110'],
            'solution-description' => ['required', 'string', 'max:410'],
            'solution-owner-problem' => ['required'],
            'g-recaptcha-response' => ['required', new ReCaptchaV3('submitSolution', 0.5)],
            'consent-notice' => ['required', 'accepted'],
            'translation-notice' => ['required', 'accepted'],
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
        } catch (\Exception $exception) {
            session()->flash('flash_message_error', 'Error: ' . $exception->getCode() . '  ' . $exception->getMessage());

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
        } catch (\Exception $exception) {
            session()->flash('flash_message_error', 'Error: ' . $exception->getCode() . '  ' . $exception->getMessage());

            return back()->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $locale, int $id) {
        $validated = $this->validate($request, [
            'solution-title' => ['required', 'string', 'max:110'],
            'solution-description' => ['required', 'string', 'max:410'],
            'solution-status' => ['required'],
            'solution-slug' => 'required|string|alpha_dash|unique:solutions,slug,' . $id . '|max:111',
            'solution-image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'solution-owner-problem' => ['required'],
            'extra_translations' => 'nullable|json',
        ]);

        try {
            $this->solutionManager->updateSolution($id, $validated);
        } catch (\Exception $exception) {
            session()->flash('flash_message_error', 'Error: ' . $exception->getCode() . '  ' . $exception->getMessage());

            return back()->withInput();
        }

        session()->flash('flash_message_success', 'Solution updated successfully.');

        return back();
    }

    public function updateStatus(Request $request, int $id): JsonResponse {
        $this->validate($request, [
            'status_id' => 'required|exists:problem_statuses_lkp,id',
        ]);

        return response()->json($this->solutionManager->updateSolutionStatus($id, $request->status_id));
    }

    /**
     * Administrator method to add a vote to a solution (bypasses normal vote limits)
     */
    public function adminAddVote(Request $request, int $id): JsonResponse {
        try {
            $result = $this->solutionManager->adminAddVoteToSolution($id);

            return response()->json($result);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $locale, int $id): bool {
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
            'lang' => 'required|string',
        ]);

        return response()->json([
            'user_votes' => $this->solutionManager->getUserVotesNum(intval($request->problem_id)),
            'solutions' => $this->solutionManager->getSolutions(intval($request->problem_id), $request->lang),
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
        } catch (\Exception $exception) {
            session()->flash('flash_message_error', 'Error: ' . $exception->getCode() . '  ' . $exception->getMessage());

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

        $solutionSubmitted = $this->solutionManager->getSolutionSubmittedViewModel($project_slug, $problem_slug, $solution_slug);

        return view('solution.submitted', ['viewModel' => $solutionSubmitted]);
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

    public function exportSolutions(int $project_id) {
        $validator = Validator::make([
            'project_id' => $project_id,
        ], [
            'project_id' => 'required|exists:crowd_sourcing_projects,id',
        ]);

        if ($validator->fails()) {
            abort(ResponseAlias::HTTP_BAD_REQUEST);
        }

        $solutions = $this->solutionManager->getSolutionsByProjectId($project_id);

        $callback = function () use ($solutions): void {
            $columns = ['Solution ID', 'Title', 'Description', 'Status', 'Created At'];
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($solutions as $solution) {
                fputcsv($file, [
                    $solution->id,
                    $solution->defaultTranslation?->title,
                    $solution->defaultTranslation?->description,
                    $solution->status->title,
                    $solution->created_at,
                ]);
            }

            fclose($file);
        };

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="solutions.csv"',
        ];

        return response()->stream($callback, 200, $headers);
    }
}
