<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\LanguageManager;
use Illuminate\Http\Request;

class CrowdSourcingProjectController extends Controller
{

    private $crowdSourcingProjectManager;

    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager)
    {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
    }

    public function viewReports($id)
    {
        return view("reports");
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


    public function showLandingPage($project_slug)
    {
        $viewModel = $this->crowdSourcingProjectManager->getCrowdSourcingProjectViewModelForLandingPage($project_slug);
        if ($viewModel->project)
            return view('landingpages.layout')->with(['viewModel' => $viewModel]);
        abort(404);
    }
}
