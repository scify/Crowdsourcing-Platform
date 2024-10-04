<?php

namespace App\Http\Controllers\Questionnaire;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\BusinessLogicLayer\questionnaire\QuestionnaireLanguageManager;
use App\BusinessLogicLayer\questionnaire\QuestionnaireManager;
use App\BusinessLogicLayer\questionnaire\QuestionnaireTranslator;
use App\BusinessLogicLayer\questionnaire\QuestionnaireVMProvider;
use App\BusinessLogicLayer\UserQuestionnaireShareManager;
use App\Http\Controllers\Controller;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use Exception;
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
        $this->validate($request, [
            'status_id' => 'required|integer|in:' . implode(',', QuestionnaireStatusLkp::GetAllStatusIds()),
        ]);
        $this->questionnaireManager->updateQuestionnaireStatus($request->questionnaire_id, $request->status_id, $request->comments);

        return redirect()->back()->with(['flash_message_success' => 'The questionnaire status has been updated.']);
    }

    public function createQuestionnaire() {
        $viewModel = $this->questionnaireVMProvider->getCreateEditQuestionnaireViewModel();

        return view('questionnaire.create-edit')->with(['viewModel' => $viewModel]);
    }

    public function store(Request $request) {
        $data = $request->all();
        if (!isset($data['status_id'])) {
            $data['status_id'] = QuestionnaireStatusLkp::DRAFT;
        }

        $this->validate($request, [
            'type_id' => 'required|integer',
            'language' => 'required',
            'statistics_page_visibility_lkp_id' => 'required',
            'goal' => 'required|integer',
            'lang_codes' => 'array',
            'content' => 'required',
            'status_id' => 'integer|in:' . implode(',', QuestionnaireStatusLkp::GetAllStatusIds()),
            'project_ids' => 'required|array',
        ]);
        $questionnaire = $this->questionnaireManager->storeOrUpdateQuestionnaire($data);
        if (isset($data['lang_codes']) && count($data['lang_codes']) > 0) {
            $this->questionnaireLanguageManager->saveLanguagesForQuestionnaire($data['lang_codes'], $questionnaire->id);
        }

        return $questionnaire;
    }

    public function editQuestionnaire($id) {
        $viewModel = $this->questionnaireVMProvider->getCreateEditQuestionnaireViewModel($id);

        return view('questionnaire.create-edit')->with(['viewModel' => $viewModel]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'type_id' => 'required|integer',
            'language' => 'required',
            'statistics_page_visibility_lkp_id' => 'required',
            'goal' => 'required|integer',
            'lang_codes' => 'required|array',
            'content' => 'required',
            'status_id' => 'required|integer|in:' . implode(',', QuestionnaireStatusLkp::GetAllStatusIds()),
            'project_ids' => 'required|array',
        ]);
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

    /**
     * @throws Exception if the user is not allowed to access the questionnaire
     */
    public function showAddResponseAsModeratorToQuestionnaire(CrowdSourcingProject $project, Questionnaire $questionnaire) {
        $viewModel = $this->questionnaireVMProvider->getViewModelForQuestionnaireResponseModeratorPage($project, $questionnaire);

        return view('questionnaire.questionnaire-page')->with(['viewModel' => $viewModel]);
    }

    public function showQuestionnairePage(CrowdSourcingProject $project, Questionnaire $questionnaire) {
        // 1. if the questionnaire is not active, we should not allow the user to see it
        if ($questionnaire->status_id !== QuestionnaireStatusLkp::PUBLISHED) {
            return redirect()->back()->with(['flash_message_error' => 'The questionnaire is not active.']);
        }
        // 2. if the questionnaire does not belong to the project, we should not allow the user to see it
        if (!$questionnaire->projects->contains($project)) {
            return redirect()->back()->with(['flash_message_error' => 'The questionnaire does not belong to the project.']);
        }
        // 3. if the project is not active, we should not allow the user to see it
        if ($project->status_id !== CrowdSourcingProjectStatusLkp::PUBLISHED) {
            return redirect()->back()->with(['flash_message_error' => 'The project is not active.']);
        }
        $viewModel = $this->questionnaireVMProvider->getViewModelForQuestionnairePage($project, $questionnaire);

        return view('questionnaire.questionnaire-page')->with(['viewModel' => $viewModel]);
    }
}
