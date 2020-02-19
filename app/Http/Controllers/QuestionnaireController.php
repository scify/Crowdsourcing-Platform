<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\gamification\PlatformWideGamificationBadgesProvider;
use App\BusinessLogicLayer\QuestionnaireManager;
use App\BusinessLogicLayer\QuestionnaireReportManager;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use App\Http\OperationResponse;
use App\Models\ViewModels\GamificationBadgeVM;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class QuestionnaireController extends Controller
{
    protected $questionnaireManager;
    protected $questionnaireShareManager;
    protected $platformWideGamificationBadgesProvider;
    protected $questionnaireReportManager;

    public function __construct(QuestionnaireManager $questionnaireManager,
                                UserQuestionnaireShareManager $questionnaireShareManager,
                                PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider,
                                QuestionnaireReportManager $questionnaireReportManager)
    {
        $this->questionnaireManager = $questionnaireManager;
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
        $this->questionnaireReportManager = $questionnaireReportManager;
    }

    public function manageQuestionnaires()
    {
        $questionnairesViewModel = $this->questionnaireManager->getAllQuestionnairesPageViewModel();
        return view("questionnaire.all")->with(['viewModel' => $questionnairesViewModel]);
    }

    public function saveQuestionnaireStatus(Request $request)
    {
        $this->questionnaireManager->updateQuestionnaireStatus($request->questionnaire_id, $request->status_id, $request->comments);
        return redirect()->back()->with(['flash_message_success' => 'The questionnaire status has been updated.']);
    }

    public function createQuestionnaire()
    {
        $viewModel = $this->questionnaireManager->getCreateEditQuestionnaireViewModel();
        return view('questionnaire.create-edit')->with(['viewModel' => $viewModel]);
    }

    public function storeQuestionnaire(Request $request)
    {
        // TODO add validation
        $this->questionnaireManager->createNewQuestionnaire($request->all());
        return response()->json(['status' => '__SUCCESS', 'redirect_url' => route('questionnaires.all')]);
    }

    public function editQuestionnaire($id)
    {
        $viewModel = $this->questionnaireManager->getCreateEditQuestionnaireViewModel($id);
        return view('questionnaire.create-edit')->with(['viewModel' => $viewModel]);
    }

    public function updateQuestionnaire(Request $request, $id)
    {
        $this->questionnaireManager->updateQuestionnaire($id, $request->all());
        return response()->json(['status' => '__SUCCESS', 'redirect_url' => route('questionnaires.all')]);
    }

    public function storeQuestionnaireResponse(Request $request) {
        $this->questionnaireManager->storeQuestionnaireResponse($request->all());
        $badge = new GamificationBadgeVM($this->platformWideGamificationBadgesProvider->getContributorBadge(\Auth::id()));
        return response()->json(['status' => '__SUCCESS', 'badgeHTML' => (String) view('gamification.badge-single', compact('badge'))]);
    }

    public function translateQuestionnaire($id)
    {
        $viewModel = $this->questionnaireManager->getTranslateQuestionnaireViewModel($id);
        return view('questionnaire.translate')->with(['viewModel' => $viewModel]);
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
        return response()->json(['status' => '__SUCCESS', 'redirect_url' => url()->previous(route('home'))]);
    }

    public function storeQuestionnaireShare(Request $request) {
        $userId = \Auth::id();
        $values = $request->all();
        $questionnaireId = $values['questionnaire-id'];
        $this->questionnaireShareManager->createQuestionnaireShare($userId, $questionnaireId);
        return response()->json(['status' => '__SUCCESS']);
    }

    public function viewReportsPage(Request $request) {
        $selectedQuestionnaireId = $request->questionnaireId;
        $viewModel = $this->questionnaireReportManager->getCrowdSourcingProjectReportsViewModel(null, $selectedQuestionnaireId);
        return view("questionnaire.reports.reports-with-filters", ['viewModel' => $viewModel]);
    }

    public function showReportForQuestionnaire(Request $request) {
        $input = $request->all();
        try {
            $reportViewModel = $this->questionnaireReportManager->getQuestionnaireReportViewModel($input);
            $view = view('questionnaire.reports.report-for-questionnaire', compact('reportViewModel'));
            $responseCode = Response::HTTP_OK;
            $responseContent = (String) $view->render();
        } catch (QueryException $e) {
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $responseContent = 'Error: ' . $e->getCode() . '. A Database error occurred.';
        } catch (\Exception $e) {
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $responseContent = 'Error: ' . $e->getCode() . "  " .  $e->getMessage();
        } finally {
            return response()->json(['data' => $responseContent], $responseCode);
        }
    }
}
