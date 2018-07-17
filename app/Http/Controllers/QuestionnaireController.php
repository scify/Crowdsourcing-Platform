<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/6/18
 * Time: 5:04 PM
 */

namespace App\Http\Controllers;

use App\BusinessLogicLayer\QuestionnaireManager;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    private $questionnaireManager;

    public function __construct(QuestionnaireManager $questionnaireManager)
    {
        $this->questionnaireManager = $questionnaireManager;
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
        $viewModel = $this->questionnaireManager->getCreateEditQuestionnaireViewModel(null);
        return view('create-edit-questionnaire')->with(['viewModel' => $viewModel]);
    }

    public function storeQuestionnaire(Request $request)
    {
        $this->questionnaireManager->createNewQuestionnaire($request->all());
        return response()->json(['status' => '__SUCCESS', 'redirect_url' => url('/project/1/questionnaires')]);
    }

    public function editQuestionnaire($id)
    {
        $viewModel = $this->questionnaireManager->getCreateEditQuestionnaireViewModel($id);
        return view('create-edit-questionnaire')->with(['viewModel' => $viewModel]);
    }

    public function updateQuestionnaire(Request $request, $id)
    {
        $this->questionnaireManager->updateQuestionnaire($id, $request->all());
        return response()->json(['status' => '__SUCCESS', 'redirect_url' => url('/project/1/questionnaires')]);
    }

    public function storeQuestionnaireResponse(Request $request)
    {
        $this->questionnaireManager->storeQuestionnaireResponse($request->all());
        return response()->json(['status' => '__SUCCESS']);
    }

    public function translateQuestionnaire($id)
    {
        $viewModel = $this->questionnaireManager->getTranslateQuestionnaireViewModel($id);
        return view('translate-questionnaire')->with(['viewModel' => $viewModel]);
    }
}