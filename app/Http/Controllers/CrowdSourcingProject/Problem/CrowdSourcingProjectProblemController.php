<?php

namespace App\Http\Controllers\CrowdSourcingProject\Problem;

use App\BusinessLogicLayer\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemManager;
use App\Http\Controllers\Controller;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslation;
use App\ViewModels\CrowdSourcingProject\Problem\CreateEditProblem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CrowdSourcingProjectProblemController extends Controller {
    private CrowdSourcingProjectProblemManager $crowdSourcingProjectProblemManager;

    public function __construct(CrowdSourcingProjectProblemManager $crowdSourcingProjectProblemManager) {
        $this->crowdSourcingProjectProblemManager = $crowdSourcingProjectProblemManager;
    }

    public function showProblemsPage(Request $request) {
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
    public function index() {
        $viewModel = [];
        $viewModel['problems'] = CrowdSourcingProjectProblem::with('translations')->latest()->get();

        return view('loggedin-environment.management.problem.index', ['viewModel' => $viewModel]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $newProblem = new CrowdSourcingProjectProblem;
        $newProblem->default_language_id = 6; // @todo change with lookuptable value - bookmark2
        $newProblem->setRelation('defaultTranslation', new CrowdSourcingProjectProblemTranslation); // bookmark2 - is this an "empty" relationship?
        $viewModel = new CreateEditProblem($newProblem);

        return view('loggedin-environment.management.problem.create-edit.form-page');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([ // bookmark2
            'problem-title' => ['required'],
            'problem-description' => ['required'],
            'problem-status' => ['required'], // bookmark2
            'problem-default-language' => ['required'], // bookmark2
            'problem-slug' => ['required', 'unique:crowd_sourcing_project_problems,slug'],
        ]);

        $crowdSourcingProjectProblem = CrowdSourcingProjectProblem::create([
            'project_id' => '3', // bookmark2
            'user_creator_id' => '2', // bookmark2
            'slug' => $request->input('problem-slug'),
            'status_id' => $request->input('problem-status'),
            'img_url' => 'zxcv', // bookmark2
            'default_language_id' => $request->input('problem-default-language'), // bookmark2 - default or generally another translation language?
        ]);

        $crowdSourcingProjectProblemTranslation = $crowdSourcingProjectProblem->defaultTranslation()->create([ // bookmark2 - default or regular translation?
            'title' => $request->input('problem-title'),
            'description' => $request->input('problem-description'),
        ]);

        return redirect()->route('problems.index');
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
