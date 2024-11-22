<?php

namespace App\Http\Controllers\Solution;

use App\BusinessLogicLayer\Solution\SolutionManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SolutionController extends Controller {
    protected SolutionManager $solutionManager;

    public function __construct(SolutionManager $solutionManager) {
        $this->solutionManager = $solutionManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View {
        $this->validate($request, [
            'problem_id' => ['required'],
        ]);
        $viewModel = $this->solutionManager->getCreateEditSolutionViewModel($request->problem_id);

        return view('backoffice.management.solution.create-edit.form-page', ['viewModel' => $viewModel]);
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
    public function edit(string $id) {
        //
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
        //
    }
}
