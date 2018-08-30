<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/6/18
 * Time: 5:04 PM
 */

namespace App\Http\Controllers;

use App\BusinessLogicLayer\QuestionnaireManager;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    private $questionnaireManager;
    private $questionnaireShareManager;

    public function __construct(QuestionnaireManager $questionnaireManager, UserQuestionnaireShareManager $questionnaireShareManager)
    {
        $this->questionnaireManager = $questionnaireManager;
        $this->questionnaireShareManager = $questionnaireShareManager;
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
        $badge = $this->questionnaireManager->storeQuestionnaireResponseAndGetBadge($request->all());
        return response()->json(['status' => '__SUCCESS', 'badgeHTML' => (String) view('gamification.badge-single', compact('badge'))]);
    }

    public function translateQuestionnaire($id)
    {
        $viewModel = $this->questionnaireManager->getTranslateQuestionnaireViewModel($id);
        return view('translate-questionnaire')->with(['viewModel' => $viewModel]);
    }

    public function getAutomaticTranslations(Request $request)
    {
        $translations = $this->questionnaireManager->getAutomaticTranslations(
            $request->languageCodeToTranslateTo, $request->ids, $request->texts);
        return response()->json(['status' => '__SUCCESS', 'translations' => $translations]);
    }

    public function storeQuestionnaireTranslations(Request $request, $id)
    {
        $this->questionnaireManager->storeQuestionnaireTranslations($id, $request->translations);
        return response()->json(['status' => '__SUCCESS', 'redirect_url' => url('/project/1/questionnaires')]);
    }

    public function storeQuestionnaireShare(Request $request) {
        $userId = \Auth::id();
        $values = $request->all();
        $questionnaireId = $values['questionnaire-id'];
        $this->questionnaireShareManager->createQuestionnaireShare($userId, $questionnaireId);
        return response()->json(['status' => '__SUCCESS']);
    }
}