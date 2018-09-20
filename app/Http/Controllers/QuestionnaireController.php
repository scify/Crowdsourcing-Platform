<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/6/18
 * Time: 5:04 PM
 */

namespace App\Http\Controllers;

use App\BusinessLogicLayer\gamification\GamificationManager;
use App\BusinessLogicLayer\QuestionnaireManager;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use App\Http\OperationResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Exception\UnsupportedOperationException;

class QuestionnaireController extends Controller
{
    private $questionnaireManager;
    private $questionnaireShareManager;
    private $gamificationManager;

    public function __construct(QuestionnaireManager $questionnaireManager,
                                UserQuestionnaireShareManager $questionnaireShareManager,
                                GamificationManager $gamificationManager)
    {
        $this->questionnaireManager = $questionnaireManager;
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->gamificationManager = $gamificationManager;
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

    public function storeQuestionnaireResponse(Request $request) {
        $this->questionnaireManager->storeQuestionnaireResponse($request->all());
        $badge = $this->gamificationManager->getBadgeViewModel($this->gamificationManager->getContributorBadge(\Auth::id()));
        return response()->json(['status' => '__SUCCESS', 'badgeHTML' => (String) view('gamification.badge-single', compact('badge'))]);
    }

    public function translateQuestionnaire($id)
    {
        $viewModel = $this->questionnaireManager->getTranslateQuestionnaireViewModel($id);
        return view('translate-questionnaire')->with(['viewModel' => $viewModel]);
    }

    public function getAutomaticTranslationForString(Request $request)
    {
        $translation = $this->questionnaireManager->getAutomaticTranslationForString(
                                    $request->languageCodeToTranslateTo,
                                    $request->text);
        return $translation;
    }

    public function getAutomaticTranslations(Request $request)
    {
        $translations = $this->questionnaireManager->getAutomaticTranslations(
            $request->languageCodeToTranslateTo, $request->ids, $request->texts);
        return response()->json(['status' => '__SUCCESS', 'translations' => $translations]);
    }

    public function markTranslation(Request $request) {
        try {
            $this->questionnaireManager->markQuestionnaireTranslation($request->questionnaire_id, $request->lang_id, $request->mark_human);
            return json_encode(new OperationResponse(config('app.OPERATION_SUCCESS'), ""));
        } catch (\Exception $e) {
            $errorMessage = 'Error: ' . $e->getCode() . "  " .  $e->getMessage();
            Log::error($e);
            return json_encode(new OperationResponse(config('app.OPERATION_FAIL'), (String) view('partials.ajax_error_message', compact('errorMessage'))));
        }
    }

    public function deleteTranslation(Request $request) {
        try {
            $this->questionnaireManager->deleteQuestionnaireTranslation($request->questionnaire_id, $request->lang_id);
            return json_encode(new OperationResponse(config('app.OPERATION_SUCCESS'), ""));
        } catch (\Exception $e) {
            $errorMessage = 'Error: ' . $e->getCode() . "  " .  $e->getMessage();
            Log::error($e);
            return json_encode(new OperationResponse(config('app.OPERATION_FAIL'), (String) view('partials.ajax_error_message', compact('errorMessage'))));
        }
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

    public function showReportForQuestionnaire(Request $request) {
        $input = $request->all();
        try {
            $reportViewModel = $this->questionnaireManager->getQuestionnaireReportViewModel($input);
            $view = view('questionnaire.reports.report-for-questionnaire', compact('reportViewModel'));
            $view=$view->render();
            return json_encode(new OperationResponse(config('app.OPERATION_SUCCESS'), (String) $view));
        }  catch (\Exception $e) {
            $errorMessage = 'Error: ' . $e->getCode() . "  " .  $e->getMessage();
            Log::error($e);
            return json_encode(new OperationResponse(config('app.OPERATION_FAIL'), (String) view('partials.ajax_error_message', compact('errorMessage'))));
        }
    }
}