<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\questionnaire\QuestionnaireLanguageManager;
use App\BusinessLogicLayer\questionnaire\QuestionnaireManager;
use App\BusinessLogicLayer\questionnaire\QuestionnaireTranslator;
use App\BusinessLogicLayer\questionnaire\QuestionnaireVMProvider;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use App\Models\Questionnaire\Questionnaire;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller {
    protected QuestionnaireManager $questionnaireManager;
    protected UserQuestionnaireShareManager $questionnaireShareManager;
    protected QuestionnaireVMProvider $questionnaireVMProvider;
    protected QuestionnaireTranslator $questionnaireTranslator;
    protected QuestionnaireLanguageManager $questionnaireLanguageManager;

    public function __construct(QuestionnaireManager $questionnaireManager,
        UserQuestionnaireShareManager $questionnaireShareManager,
        QuestionnaireVMProvider $questionnaireVMProvider,
        QuestionnaireTranslator $questionnaireTranslator,
        QuestionnaireLanguageManager $questionnaireLanguageManager) {
        $this->questionnaireManager = $questionnaireManager;
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->questionnaireVMProvider = $questionnaireVMProvider;
        $this->questionnaireTranslator = $questionnaireTranslator;
        $this->questionnaireLanguageManager = $questionnaireLanguageManager;
    }

    public function manageQuestionnaires() {
        $questionnairesViewModel = $this->questionnaireVMProvider->getAllQuestionnairesPageViewModel();

        return view('questionnaire.all')->with(['viewModel' => $questionnairesViewModel]);
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
        $data = $request->all();
        $questionnaire = $this->questionnaireManager->storeOrUpdateQuestionnaire($data);
        $this->questionnaireLanguageManager->saveLanguagesForQuestionnaire($data['lang_codes'], $questionnaire->id);

        return $questionnaire;
    }

    public function editQuestionnaire($id) {
        $viewModel = $this->questionnaireVMProvider->getCreateEditQuestionnaireViewModel($id);

        return view('questionnaire.create-edit')->with(['viewModel' => $viewModel]);
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        $questionnaire = $this->questionnaireManager->storeOrUpdateQuestionnaire($data, $id);
        $this->questionnaireLanguageManager->saveLanguagesForQuestionnaire($data['lang_codes'], $questionnaire->id);

        return $questionnaire;
    }

    public function translateQuestionnaire(Request $request): JsonResponse {
        $this->validate($request, [
            'questionnaire_json' => 'required|string|json',
            'locales' => 'required|array',
        ]);

        return response()->json([
            'translation' => $this->questionnaireTranslator->translateQuestionnaireJSONToLocales($request->questionnaire_json, $request->locales),
        ]);
    }

    public function getLanguagesForQuestionnaire(Request $request): JsonResponse {
        $this->validate($request, [
            'questionnaire_id' => 'required|integer',
        ]);

        return response()->json([
            'questionnaire_languages' => $this->questionnaireLanguageManager->getLanguagesForQuestionnaire(($request->questionnaire_id)),
        ]);
    }

    public function markQuestionnaireTranslations(Request $request): JsonResponse {
        $this->validate($request, [
            'questionnaire_id' => 'required|integer',
            'lang_ids_to_status' => 'required|array',
        ]);

        return response()->json([
            'success' => $this->questionnaireTranslator->markQuestionnaireTranslations($request->questionnaire_id, $request->lang_ids_to_status),
        ]);
    }

    public function storeQuestionnaireShare(Request $request): JsonResponse {
        $userId = Auth::id();
        $values = $request->all();
        $questionnaireId = $values['questionnaire-id'];
        $this->questionnaireShareManager->createQuestionnaireShare($userId, $questionnaireId);

        return response()->json(['status' => '__SUCCESS']);
    }

    public function showAddResponseAsModeratorToQuestionnaire(Questionnaire $questionnaire, string $project_slug) {
        $viewModel = $this->questionnaireVMProvider->getViewModelForQuestionnaireResponseModeratorPage($questionnaire, $project_slug);

        return view('questionnaire.moderator-add-response')->with(['viewModel' => $viewModel]);
    }
}
