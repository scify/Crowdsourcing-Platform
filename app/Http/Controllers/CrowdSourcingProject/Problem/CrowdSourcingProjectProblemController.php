<?php

namespace App\Http\Controllers\CrowdSourcingProject\Problem;

use App\BusinessLogicLayer\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemManager;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CrowdSourcingProjectProblemController extends Controller {
    private CrowdSourcingProjectProblemManager $crowdSourcingProjectProblemManager;

    public function __construct(CrowdSourcingProjectProblemManager $crowdSourcingProjectProblemManager) {
        $this->crowdSourcingProjectProblemManager = $crowdSourcingProjectProblemManager;
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
            $viewModel = $this->crowdSourcingProjectProblemManager->getCrowdSourcingProjectProblemsLandingPageViewModel($request->project_slug);

            return view('crowdsourcing-project.problems.landing-page', ['viewModel' => $viewModel]);
        } catch (ModelNotFoundException $e) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View {
        return view('loggedin-environment.management.problem.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
        $viewModel = $this->crowdSourcingProjectProblemManager->getCreateEditProblemViewModel();

        return view('loggedin-environment.management.problem.create-edit.form-page', ['viewModel' => $viewModel]);
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

        try {
            $createdProblemId = $this->crowdSourcingProjectProblemManager->storeProblem($request->all());
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
    public function edit(int $id): View {
        $viewModel = $this->crowdSourcingProjectProblemManager->getCreateEditProblemViewModel($id);

        return view('loggedin-environment.management.problem.create-edit.form-page', ['viewModel' => $viewModel]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        return $this->crowdSourcingProjectProblemManager->deleteProblem($id);
    }

    public function getProblemStatusesForManagementPage(): JsonResponse {
        return response()->json($this->crowdSourcingProjectProblemManager->getProblemStatusesForManagementPage());
    }
}
