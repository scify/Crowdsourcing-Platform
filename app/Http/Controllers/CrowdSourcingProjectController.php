<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\gamification\GamificationManager;
use App\BusinessLogicLayer\UserManager;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use JsonSchema\Exception\ResourceNotFoundException;

class CrowdSourcingProjectController extends Controller
{

    private $crowdSourcingProjectManager;
    private $questionnaireShareManager;
    private $userManager;
    private $gamificationManager;

    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager,
                                UserQuestionnaireShareManager $questionnaireShareManager,
                                UserManager $userManager, GamificationManager $gamificationManager) {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->userManager = $userManager;
        $this->gamificationManager = $gamificationManager;
    }

    public function viewReports($projectId, Request $request) {
        $selectedProjectId = $projectId;
        $selectedQuestionnaireId = $request->questionnaireId;
        $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectReportsViewModel($selectedProjectId, $selectedQuestionnaireId);
        return view("questionnaire.reports.reports-with-filters", ['viewModel' => $viewModel]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = $this->crowdSourcingProjectManager->getCrowdSourcingProject($id);
        return view('edit-project')->with(['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'motto' => 'required|string',
            'about' => 'required|string',
            'footer' => 'required|string',
            'language_id' => 'required|numeric|exists:languages_lkp,id'
        ]);
        $this->crowdSourcingProjectManager->updateCrowdSourcingProject($id, $request->all());
        return redirect()->back()->with('flash_message_success', 'The project\'s info have been successfully updated');
    }


    public function showLandingPage(Request $request, $project_slug) {
        try {
            $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectViewModelForLandingPage($request->open == 1, $project_slug);
            if (isset($request->questionnaireId) && isset($request->referrerId))
                $this->questionnaireShareManager->handleQuestionnaireShare($request->all(), $this->gamificationManager, $this->userManager->getUser($request->referrerId));
            if (isset($request->referrerId))
                $this->userManager->setReferrerIdToWebSession($request->referrerId);
            return view('landingpages.home')->with(['viewModel' => $viewModel]);
        } catch (ResourceNotFoundException $e) {
            Log::error($e);
            abort(404);
        }
    }
}
