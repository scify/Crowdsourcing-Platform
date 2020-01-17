<?php

namespace App\BusinessLogicLayer;

use App\Models\Language;
use App\Models\Questionnaire;
use App\Models\ViewModels\CreateEditQuestionnaire;
use App\Models\ViewModels\ManageQuestionnaires;
use App\Models\ViewModels\QuestionnaireTranslation;
use App\Models\ViewModels\reports\QuestionnaireReportResults;
use App\Repository\CrowdSourcingProjectRepository;
use App\Repository\QuestionnaireReportRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionnaireResponseAnswerRepository;
use App\Repository\QuestionnaireTranslationRepository;
use App\Repository\UserRepository;
use App\Utils\Translator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use JsonSchema\Exception\ResourceNotFoundException;

class QuestionnaireManager {
    protected $questionnaireRepository;
    protected $languageManager;
    protected $translator;
    protected $webSessionManager;
    protected $questionnaireResponseReferralManager;
    protected $userRepository;
    protected $questionnaireReportRepository;
    protected $questionnaireResponseAnswerRepository;
    protected $questionnaireTranslationRepository;
    protected $crowdSourcingProjectAccessManager;
    protected $questionnaireActionHandler;
    protected $crowdSourcingProjectRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                LanguageManager $languageManager,
                                Translator $translator,
                                WebSessionManager $webSessionManager,
                                UserRepository $userRepository,
                                QuestionnaireResponseReferralManager $questionnaireResponseReferralManager,
                                QuestionnaireReportRepository $questionnaireReportRepository,
                                QuestionnaireResponseAnswerRepository $questionnaireResponseAnswerRepository,
                                QuestionnaireTranslationRepository $questionnaireTranslationRepository,
                                CrowdSourcingProjectAccessManager $crowdSourcingProjectAccessManager,
                                QuestionnaireActionHandler $questionnaireActionHandler,
                                CrowdSourcingProjectRepository $crowdSourcingProjectRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->languageManager = $languageManager;
        $this->translator = $translator;
        $this->webSessionManager = $webSessionManager;
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $this->userRepository = $userRepository;
        $this->questionnaireReportRepository = $questionnaireReportRepository;
        $this->questionnaireResponseAnswerRepository = $questionnaireResponseAnswerRepository;
        $this->questionnaireTranslationRepository = $questionnaireTranslationRepository;
        $this->crowdSourcingProjectAccessManager = $crowdSourcingProjectAccessManager;
        $this->questionnaireActionHandler = $questionnaireActionHandler;
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
    }

    public function getCreateEditQuestionnaireViewModel($id = null) {
        $maximumPrerequisiteOrder = null;
        if($id) {
            $questionnaire = $this->questionnaireRepository->find($id);
            $title = "Edit Questionnaire";
            $maximumPrerequisiteOrder = $questionnaire->project->questionnaires->count();
        }
        else {
            $questionnaire = $this->questionnaireRepository->getModelInstance();
            $title = "Create Questionnaire";
        }
        $projects = $this->crowdSourcingProjectAccessManager->getProjectsUserHasAccessToEdit(Auth::user());
        $languages = $this->languageManager->getAllLanguages();

        return new CreateEditQuestionnaire($questionnaire, $projects, $languages, $title, $maximumPrerequisiteOrder);
    }

    public function getAllQuestionnairesPageViewModel() {
        $projectTheUserHasAccessTo = $this->crowdSourcingProjectAccessManager->getProjectsUserHasAccessToEdit(Auth::user());
        $questionnaires = new Collection();
        foreach ($projectTheUserHasAccessTo as $project) {
            $questionnaires = $questionnaires->concat(
                $this->questionnaireTranslationRepository->getAllQuestionnairesForProjectWithAvailableTranslations($project->id));
        }
        $availableStatuses = $this->questionnaireRepository->getAllQuestionnaireStatuses();
        return new ManageQuestionnaires($questionnaires, $availableStatuses);
    }

    public function updateQuestionnaireStatus($questionnaireId, $statusId, $comments) {
        $comments = is_null($comments) ? "" : $comments;
        $this->questionnaireRepository->updateQuestionnaireStatus($questionnaireId, $statusId, $comments);
    }

    public function createNewQuestionnaire($data) {
        $projectTheQuestionnaireBelongsTo = $this->crowdSourcingProjectRepository->find($data['project']);
        // here we need to set the prerequisite order of the questionnaire equal to the number of questionnaires + 1.
        $numOfQuestionnaires = $projectTheQuestionnaireBelongsTo->questionnaires->count();
        $questionnaire = $this->questionnaireRepository->saveNewQuestionnaire(
            $data['title'], $data['description'],
            $data['goal'], $data['language'],
            $data['project'], $data['content'],
            $numOfQuestionnaires + 1
        );
        $this->storeToAllQuestionnaireRelatedTables($questionnaire->id, $data);
    }

    public function updateQuestionnaire($id, $data) {
        $this->questionnaireRepository->updateQuestionnaire($id, $data['title'], $data['description'],
            $data['goal'], $data['language'], $data['project'], $data['content'], $data['prerequisite_order']);
        $this->updateAllQuestionnaireRelatedTables($id, $data);
    }

    public function storeQuestionnaireResponse($data) {
        $response = json_decode($data['response']);
        $user = Auth::user();
        $questionnaire = $this->questionnaireRepository->find($data['questionnaire_id']);
        $this->questionnaireRepository->saveNewQuestionnaireResponse($data['questionnaire_id'], $response, $user->id, $data['response']);
        $this->questionnaireActionHandler->handleQuestionnaireContributor($questionnaire, $user);
        // if the user got invited by another user to answer the questionnaire, also award the referrer user.
        $this->questionnaireActionHandler->handleQuestionnaireReferrer($questionnaire, $user);
    }

    public function getAutomaticTranslationForString($languageCodeToTranslateTo, $text) {
        return $this->translator->translateTexts([$text], $languageCodeToTranslateTo);
    }

    public function getAutomaticTranslations($languageCodeToTranslateTo, $ids, $texts) {
        $translations = [];
        $translatedTexts = $this->translator->translateTexts($texts, $languageCodeToTranslateTo);
        foreach ($ids as $key => $id)
            $translations[$id] = str_replace('&quot;', '"', $translatedTexts[$key]);
        return $translations;
    }

    public function getTranslateQuestionnaireViewModel($questionnaireId) {
        $questionnaire = $this->questionnaireRepository->find($questionnaireId);
        $allLanguages = $this->languageManager->getAllLanguages()->groupBy('id');
        $defaultLanguage = $allLanguages->pull($questionnaire->default_language_id);
        $allLanguages = $this->transformAllLanguagesToArray($allLanguages);
        $questionnaireTranslations = $this->questionnaireTranslationRepository->getQuestionnaireTranslationsGroupedByLanguageAndQuestion($questionnaireId);
        $questionnaireLanguages = $this->questionnaireTranslationRepository->getQuestionnaireAvailableLanguages($questionnaireId);
        // if default value translation is set and there are some translations but not for all questions/answers/html,
        // we need to pass all the not translated strings to the other languages, so that they will be available for translation
        if ($questionnaireTranslations->has("") && $questionnaireTranslations->count() > 1) {
            $defaultLanguageTranslation = $questionnaireTranslations->pull("");
            foreach ($questionnaireTranslations->keys() as $language) {
                foreach ($defaultLanguageTranslation as $translations) {
                    $questionnaireTranslations->get($language)->push($translations);
                }
            }
        }
        return new QuestionnaireTranslation($questionnaireTranslations, $questionnaireLanguages, $questionnaire, $allLanguages, $defaultLanguage[0]);
    }

    public function storeQuestionnaireTranslations($questionnaireId, $translations) {
        $this->questionnaireTranslationRepository->storeQuestionnaireTranslations($questionnaireId, json_decode($translations));
    }

    private function storeToAllQuestionnaireRelatedTables($questionnaireId, $data) {
        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
        $index = 1;
        foreach ($questions as $question) {
            $questionTitle = isset($question->title) ? $question->title : $question->name;
            $questionType = $question->type;
            $storedQuestion = $this->questionnaireRepository->saveNewQuestion($questionnaireId, $questionTitle, $questionType, $question->name, $question->guid, $index);
            if ($questionType === 'html')
                $this->questionnaireRepository->saveNewHtmlElement($storedQuestion->id, $question->html);
            $this->storeAllAnswers($question, $storedQuestion->id);
            $index++;
        }
    }

    private function updateAllQuestionnaireRelatedTables($questionnaireId, $data) {
        $questions = $this->extractDataFromQuestionnaireJson($data['content']);
        $this->questionnaireRepository->updateAllQuestionnaireRelatedTables($questionnaireId, $questions);
    }

    private function extractDataFromQuestionnaireJson($content) {
        $questionnaire = json_decode($content);
        $allQuestions = [];
        foreach ($questionnaire->pages as $page) {
            if (isset($page->elements))
                $allQuestions = array_merge($allQuestions, $page->elements);
        }
        return $allQuestions;
    }

    private function storeAllAnswers($question, $questionId) {
        if (isset($question->choices)) {
            foreach ($question->choices as $choice) {

                if (isset($choice->name))
                    $answer = $choice->name;
                else if (isset($choice->text))
                    $answer = $choice->text;
                else
                    $answer = $choice;

                $value = isset($choice->value) ? $choice->value : $choice;
                $this->questionnaireRepository->saveNewAnswer($questionId, $answer, $value, $choice->guid);
            }
        }

        if (isset($question->hasOther) && $question->hasOther)
            $this->questionnaireRepository->saveNewOtherAnswer($questionId, $question);
    }

    private function transformAllLanguagesToArray($allLanguages) {
        $result = [];
        foreach ($allLanguages as $language) {
            array_push($result, $language[0]);
        }
        return $result;
    }

    public function getQuestionnaireReportViewModel(array $input) {
        $questionnaireId = $input['questionnaireId'];
        $respondentsRows = $this->questionnaireReportRepository->getRespondentsData($questionnaireId);
        $usersRows = $this->questionnaireReportRepository->getReportDataForUsers($questionnaireId);
        $answersRows = collect($this->questionnaireReportRepository->getReportDataForAnswers($questionnaireId));
        $answerTextRows = $this->questionnaireResponseAnswerRepository->getResponseTextDataForQuestionnaire($questionnaireId);
        foreach ($answersRows as $answersRow)
            $answersRow->answer_texts = $answerTextRows->where('question_id', $answersRow->question_id)->where('answer_id', $answersRow->answer_id)->values();
        return new QuestionnaireReportResults($usersRows, $answersRows, $respondentsRows);
    }

    public function markQuestionnaireTranslation(int $questionnaireId, int $langId, bool $markHuman) {
        $questionnaireLanguage = $this->questionnaireTranslationRepository->getQuestionnaireLanguage($questionnaireId, $langId);
        if (!$questionnaireLanguage)
            throw new ResourceNotFoundException("Questionnaire Language not found. Questionnaire Id: " . $questionnaireId . " Lang id: " . $langId);
        $questionnaireLanguage->machine_generated_translation = !$markHuman;
        $questionnaireLanguage->save();
    }

    public function deleteQuestionnaireTranslation($questionnaireId, $langId) {
        $questionnaireLanguage = $this->questionnaireTranslationRepository->getQuestionnaireLanguage($questionnaireId, $langId);
        if (!$questionnaireLanguage)
            throw new ResourceNotFoundException("Questionnaire Language not found. Questionnaire Id: " . $questionnaireId . " Lang id: " . $langId);
        $this->deleteTranslatedQuestionTitles($this->questionnaireRepository->find($questionnaireId), $this->languageManager->getLanguage($langId));
        $this->questionnaireTranslationRepository->deleteQuestionnaireTranslation($questionnaireLanguage);
    }

    private function deleteTranslatedQuestionTitles(Questionnaire $questionnaire, Language $language) {
        $questionnaireJSONObj = json_decode($questionnaire->questionnaire_json);
        foreach ($questionnaireJSONObj->pages as $page) {
            if (isset($page->elements))
                foreach ($page->elements as $question) {
                    if (isset($question->title->{$language->language_code}))
                        unset($question->title->{$language->language_code});
                    if (isset($question->choices))
                        foreach ($question->choices as $choice)
                            if (isset($choice->text->{$language->language_code}))
                                unset($choice->text->{$language->language_code});
                    if (isset($question->otherText))
                        if (isset($question->otherText->{$language->language_code}))
                            unset($question->otherText->{$language->language_code});
                    if (isset($question->html))
                        if (isset($question->html->{$language->language_code}))
                            unset($question->html->{$language->language_code});
                }
        }
        $questionnaire->questionnaire_json = json_encode($questionnaireJSONObj);
        $questionnaire->save();
    }
}
