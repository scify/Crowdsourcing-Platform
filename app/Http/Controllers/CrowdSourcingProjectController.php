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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'questionnaire' => 'required|string',
            'footer' => 'required|string',
            'language_id' => 'required|numeric|exists:languages_lkp,id'
        ]);
        $this->crowdSourcingProjectManager->updateCrowdSourcingProject($id, $request->all());
        return redirect()->back()->with('flash_message_success', 'The project\'s info have been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showLandingPage()
    {
        $project = $this->crowdSourcingProjectManager->getCrowdSourcingProject(1);
        return view('landingpages.layout')->with(['project' => $project]);
    }
}
