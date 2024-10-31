<?php

namespace App\Http\Controllers\CrowdSourcingProject\Problem;

use App\BusinessLogicLayer\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemManager;
use App\Http\Controllers\Controller;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Utils\FileUploader;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $viewModel = [];
        $viewModel['problems'] = CrowdSourcingProjectProblem::with('translations')->latest()->get();

        return view('loggedin-environment.management.problem.index', ['viewModel' => $viewModel]);
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
    public function store(Request $request) {
        $validated = $request->validate([ // bookmark2
            'problem-title' => ['required', 'string', 'max:100'],
            'problem-description' => ['required', 'string', 'max:400'],
            'problem-status' => ['required'], // bookmark2
            'problem-default-language' => ['required'], // bookmark2
            'problem-slug' => ['required', 'unique:crowd_sourcing_project_problems,slug'],
            'problem-image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'problem-owner-project' => ['required'],
            'problem-creator-user-id' => ['required'],
        ]);

        try {
            if (isset($request['problem-image']) && $request['problem-image']->isValid()) {
                $imgPath = FileUploader::uploadAndGetPath($request['problem-image'], 'problem_image');
            }

            $crowdSourcingProjectProblem = CrowdSourcingProjectProblem::create([
                'project_id' => $request->input('problem-owner-project'),
                'user_creator_id' => $request->input('problem-creator-user-id'),
                'slug' => $request->input('problem-slug'),
                'status_id' => $request->input('problem-status'),
                'img_url' => $imgPath,
                'default_language_id' => $request->input('problem-default-language'), // bookmark2 - default or generally another translation language?
            ]);

            $crowdSourcingProjectProblemTranslation = $crowdSourcingProjectProblem->defaultTranslation()->create([ // bookmark2 - default or regular translation?
                'title' => $request->input('problem-title'),
                'description' => $request->input('problem-description'),
            ]);

            session()->flash('flash_message_success', 'Problem Created Successfully.');

            return redirect()->route('problems.index');
        } catch (\Exception $e) {
            session()->flash('flash_message_error', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());

            return back()->withInput();
        }
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
        //
    }
}
