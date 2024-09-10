<?php

namespace App\Http\Controllers\CrowdSourcingProject\Problem;

use App\BusinessLogicLayer\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemManager;
use App\Http\Controllers\Controller;
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

            // dd($crowdSourcingProject->creator);
            return $viewModel->crowdSourcingProject->creator->nickname;
        } catch (ModelNotFoundException $e) {
            abort(ResponseAlias::HTTP_NOT_FOUND);
        }
    }
}
