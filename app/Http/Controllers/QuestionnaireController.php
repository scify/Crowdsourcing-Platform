<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/6/18
 * Time: 5:04 PM
 */

namespace App\Http\Controllers;


use App\BusinessLogicLayer\LanguageManager;
use App\BusinessLogicLayer\QuestionnaireManager;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    private $questionnaireManager;
    private $languageManager;

    public function __construct(QuestionnaireManager $questionnaireManager, LanguageManager $languageManager)
    {
        $this->questionnaireManager = $questionnaireManager;
        $this->languageManager = $languageManager;
    }

    public function manageQuestionnaires($id)
    {
        $questionnairesViewModel = $this->questionnaireManager->getAllQuestionnairesForProjectViewModel($id);
        return view("manage-questionnaires")->with(['viewModel' => $questionnairesViewModel]);
    }

    public function saveQuestionnaireStatus(Request $request)
    {
        $this->questionnaireManager->updateQuestionnaireStatus($request->questionnaire_id, $request->status_id, $request->comments);
        return redirect()->back()->with(['flash_message_success' => 'The questionnaire status has been updated.']);
    }

    public function createQuestionnaire()
    {
        $languages = $this->languageManager->getAllLanguages();
        return view('create-questionnaire')->with(['languages' => $languages]);
    }

    public function storeQuestionnaire(Request $request)
    {
        $this->questionnaireManager->createNewQuestionnaire($request->all());
        return response()->json(['status' => '__SUCCESS', 'redirect_url' => url('/project/1/questionnaire')]);
    }
}