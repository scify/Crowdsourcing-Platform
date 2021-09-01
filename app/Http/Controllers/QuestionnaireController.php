<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\questionnaire\QuestionnaireManager;
use App\BusinessLogicLayer\questionnaire\QuestionnaireVMProvider;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use App\Http\OperationResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionnaireController extends Controller {
    protected $questionnaireManager;
    protected $questionnaireShareManager;
    protected $questionnaireVMProvider;

    public function __construct(QuestionnaireManager          $questionnaireManager,
                                UserQuestionnaireShareManager $questionnaireShareManager,
                                QuestionnaireVMProvider       $questionnaireVMProvider) {
        $this->questionnaireManager = $questionnaireManager;
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->questionnaireVMProvider = $questionnaireVMProvider;
    }

    public function manageQuestionnaires() {
        $questionnairesViewModel = $this->questionnaireVMProvider->getAllQuestionnairesPageViewModel();
        return view("questionnaire.all")->with(['viewModel' => $questionnairesViewModel]);
    }

    public function saveQuestionnaireStatus(Request $request): RedirectResponse {
        $this->questionnaireManager->updateQuestionnaireStatus($request->questionnaire_id, $request->status_id, $request->comments);
        return redirect()->back()->with(['flash_message_success' => 'The questionnaire status has been updated.']);
    }

    public function createQuestionnaire() {
        $viewModel = $this->questionnaireVMProvider->getCreateEditQuestionnaireViewModel();
        return view('questionnaire.create-edit')->with(['viewModel' => $viewModel]);
    }

    public function store(Request $request) {
        return $this->questionnaireManager->storeQuestionnaire($request->all());
    }

    public function editQuestionnaire($id) {
        $viewModel = $this->questionnaireVMProvider->getCreateEditQuestionnaireViewModel($id);
        return view('questionnaire.create-edit')->with(['viewModel' => $viewModel]);
    }

    public function update(Request $request, $id) {
        return $this->questionnaireManager->updateQuestionnaire($id, $request->all());
    }

    public function translateQuestionnaire(Request $request): JsonResponse {
        $this->validate($request, [
            'questionnaire_json' => 'required|string|json',
            'locales' => 'required|array'
        ]);
        return response()->json([
            'translation' => $this->questionnaireManager->translateQuestionnaireToLocales($request->questionnaire_json, $request->locales)
        ]);
    }


    public function markTranslation(Request $request) {
        try {
            $this->questionnaireManager->markQuestionnaireTranslation($request->questionnaire_id, $request->lang_id, $request->mark_human);
            return json_encode(new OperationResponse(config('app.OPERATION_SUCCESS'), ""));
        } catch (\Exception $e) {
            $errorMessage = 'Error: ' . $e->getCode() . "  " . $e->getMessage();
            Log::error($e);
            return json_encode(new OperationResponse(config('app.OPERATION_FAIL'), (string)view('partials.ajax_error_message', compact('errorMessage'))));
        }
    }


    public function storeQuestionnaireShare(Request $request) {
        $userId = \Auth::id();
        $values = $request->all();
        $questionnaireId = $values['questionnaire-id'];
        $this->questionnaireShareManager->createQuestionnaireShare($userId, $questionnaireId);
        return response()->json(['status' => '__SUCCESS']);
    }
}
