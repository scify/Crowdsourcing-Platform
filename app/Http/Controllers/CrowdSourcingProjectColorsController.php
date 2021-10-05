<?php


namespace App\Http\Controllers;


use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectColorsManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CrowdSourcingProjectColorsController extends Controller {

    protected $crowdSourcingProjectColorsManager;

    public function __construct(CrowdSourcingProjectColorsManager $crowdSourcingProjectColorsManager) {
        $this->crowdSourcingProjectColorsManager = $crowdSourcingProjectColorsManager;
    }

    public function getColorsForCrowdSourcingProjectOrDefault(int $project_id): JsonResponse {
        return response()->json($this->crowdSourcingProjectColorsManager->getColorsForCrowdSourcingProjectOrDefault($project_id));
    }

    public function saveColorsForCrowdSourcingProject(Request $request): JsonResponse {
        $this->crowdSourcingProjectColorsManager->saveColorsForCrowdSourcingProject($request->colors, $request->project_id);
        return $this->getColorsForCrowdSourcingProjectOrDefault($request->project_id);
    }
}
