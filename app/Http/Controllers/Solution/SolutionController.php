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
    public function create(Request $request): View {
        $validator = Validator::make([
            'problem_id' => $request->problem_id,
        ], [
            'problem_id' => 'required|different:execute_solution|exists:problems,id',
        ]);
        if ($validator->fails()) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
        try {
            $viewModel = $this->solutionManager->getCreateEditSolutionViewModel($request->problem_id);

            return view('backoffice.management.solution.create-edit.form-page', ['viewModel' => $viewModel]);
        } catch (\Throwable $th) { // bookmark3 - 'ModelNotFoundException $e' or '\Exception $e' or '\Throwable $th'???
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        $this->validate($request, [
            'solution-title' => ['required', 'string', 'max:100'],
            'solution-description' => ['required', 'string', 'max:400'],
            'solution-status' => ['required'],
            'solution-image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'solution-owner-problem' => ['required'],
        ]);

        $attributes = $request->all();

        try {
            $createdSolutionId = $this->solutionManager->storeSolution($attributes);
        } catch (\Exception $e) {
            session()->flash('flash_message_error', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());

            return back()->withInput();
        }

        session()->flash('flash_message_success', 'Solution Created Successfully.');

        $route = route('solutions.edit', ['solution' => $createdSolutionId]) . '?translations=1';

        return redirect($route);
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
        } catch (\Throwable $th) { // bookmark3 - 'ModelNotFoundException $e' or '\Exception $e' or '\Throwable $th'???
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $locale, int $id) {
        $this->validate($request, [
            'solution-title' => ['required', 'string', 'max:100'],
            'solution-description' => ['required', 'string', 'max:400'],
            'solution-status' => ['required'],
            'solution-slug' => 'required|string|alpha_dash|unique:solutions,slug,' . $id . '|max:111',
            'solution-image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'solution-owner-problem' => ['required'],
        ]);

        $attributes = $request->all();

        try {
            $this->solutionManager->updateSolution($id, $attributes);
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
        //
    }

    public function getSolutionsForCrowdSourcingProjectForManagement(): JsonResponse {
        $this->validate(request(), [
            'projectId' => 'nullable|numeric|exists:crowd_sourcing_projects,id',
        ]);

        return response()->json($this->solutionManager->getSolutionsForCrowdSourcingProjectForManagement(request('projectId')));
    }
}
