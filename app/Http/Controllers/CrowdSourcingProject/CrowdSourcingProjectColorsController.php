<?php

namespace App\Http\Controllers\CrowdSourcingProject;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CrowdSourcingProjectColorsController extends Controller {
    public function __construct(protected \App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectColorsManager $crowdSourcingProjectColorsManager) {}

    public function getColorsForCrowdSourcingProjectOrDefault(int $project_id): JsonResponse {
        return response()->json($this->crowdSourcingProjectColorsManager->getColorsForCrowdSourcingProjectOrDefault($project_id));
    }

    public function saveColorsForCrowdSourcingProject(Request $request): JsonResponse {
        $this->crowdSourcingProjectColorsManager->saveColorsForCrowdSourcingProject($request->colors, $request->project_id);

        return $this->getColorsForCrowdSourcingProjectOrDefault($request->project_id);
    }
}
