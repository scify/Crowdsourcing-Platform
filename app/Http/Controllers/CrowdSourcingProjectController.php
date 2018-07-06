<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\LanguageManager;
use Illuminate\Http\Request;

class CrowdSourcingProjectController extends Controller
{

    private $crowdSourcingProjectManager;
    private $languageManager;

    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager, LanguageManager $languageManager)
    {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
        $this->languageManager = $languageManager;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manageQuestionnaire($id)
    {
        return view("manage-questionnaire");
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
        $languages = $this->languageManager->getAllLanguages();
        return view('edit-project')->with(['project' => $project, 'languages' => $languages]);
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
        $project = $this->crowdSourcingProjectManager->getCrowdSourcingProjectBySlug($project_slug);
        if ($project)
            return view('landingpages.layout')->with(['project' => $project]);
        abort(404);
    }
}
