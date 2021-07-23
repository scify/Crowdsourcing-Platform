<?php


namespace App\BusinessLogicLayer\questionnaire;


use App\BusinessLogicLayer\CrowdSourcingProjectAccessManager;
use App\BusinessLogicLayer\LanguageManager;
use App\Models\ViewModels\CreateEditQuestionnaire;
use App\Models\ViewModels\ManageQuestionnaires;
use App\Models\ViewModels\QuestionnaireTranslation;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\QuestionnaireTranslationRepository;
use App\Repository\Questionnaire\Statistics\QuestionnaireStatisticsPageVisibilityLkpRepository;
use Illuminate\Support\Facades\Auth;

class QuestionnaireVMProvider {

    protected $questionnaireRepository;
    protected $crowdSourcingProjectAccessManager;
    protected $languageManager;
    protected $questionnaireStatisticsPageVisibilityLkpRepository;
    protected $questionnaireTranslationRepository;
    protected $questionnaireManager;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireManager $questionnaireManager,
                                CrowdSourcingProjectAccessManager $crowdSourcingProjectAccessManager,
                                LanguageManager $languageManager,
                                QuestionnaireStatisticsPageVisibilityLkpRepository $questionnaireStatisticsPageVisibilityLkpRepository,
                                QuestionnaireTranslationRepository $questionnaireTranslationRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->crowdSourcingProjectAccessManager = $crowdSourcingProjectAccessManager;
        $this->languageManager = $languageManager;
        $this->questionnaireStatisticsPageVisibilityLkpRepository = $questionnaireStatisticsPageVisibilityLkpRepository;
        $this->questionnaireTranslationRepository = $questionnaireTranslationRepository;
        $this->questionnaireManager = $questionnaireManager;
    }

    public function getCreateEditQuestionnaireViewModel($id = null) {
        $maximumPrerequisiteOrder = null;
        if ($id) {
            $questionnaire = $this->questionnaireRepository->find($id);
            $title = "Edit Questionnaire";
            $maximumPrerequisiteOrder = $questionnaire->project->questionnaires->count();
        } else {
            $questionnaire = $this->questionnaireRepository->getModelInstance();
            $questionnaire->default_language_id = 6;
            $questionnaire->prerequisite_order = 1;
            $title = "Create Questionnaire";
        }
        $projects = $this->crowdSourcingProjectAccessManager->getProjectsUserHasAccessToEdit(Auth::user());
        $languages = $this->languageManager->getAllLanguages();
        $questionnaireStatisticsPageVisibilityLkp = $this->questionnaireStatisticsPageVisibilityLkpRepository->all();
        return new CreateEditQuestionnaire($questionnaire, $projects, $languages, $title, $maximumPrerequisiteOrder, $questionnaireStatisticsPageVisibilityLkp);
    }

    public function getAllQuestionnairesPageViewModel() {
        $projectTheUserHasAccessTo = $this->crowdSourcingProjectAccessManager->getProjectsUserHasAccessToEdit(Auth::user());
        $questionnaires = $this->questionnaireRepository->getAllQuestionnairesWithRelatedInfo($projectTheUserHasAccessTo->pluck('id')->toArray());
        foreach ($questionnaires as $questionnaire) {
            if($this->questionnaireManager->shouldShowLinkForQuestionnaire($questionnaire))
                $questionnaire->url = $this->questionnaireManager->getQuestionnaireURL($questionnaire->project_slug, $questionnaire->id);
        }
        $availableStatuses = $this->questionnaireRepository->getAllQuestionnaireStatuses();
        return new ManageQuestionnaires($questionnaires, $availableStatuses);
    }

//    public function getTranslateQuestionnaireViewModel($questionnaireId) {
//        $questionnaire = $this->questionnaireRepository->find($questionnaireId);
//        $allLanguages = $this->languageManager->getAllLanguages()->groupBy('id');
//        $defaultLanguage = $allLanguages->pull($questionnaire->default_language_id);
//        $allLanguages = $this->transformAllLanguagesToArray($allLanguages);
//        $questionnaireTranslations = $this->questionnaireTranslationRepository->getQuestionnaireTranslationsGroupedByLanguageAndQuestion($questionnaireId);
//        $questionnaireLanguages = $this->questionnaireTranslationRepository->getQuestionnaireAvailableLanguages($questionnaireId);
//        // if default value translation is set and there are some translations but not for all questions/answers/html,
//        // we need to pass all the not translated strings to the other languages, so that they will be available for translation
//        if ($questionnaireTranslations->has("") && $questionnaireTranslations->count() > 1) {
//            $defaultLanguageTranslation = $questionnaireTranslations->pull("");
//            foreach ($questionnaireTranslations->keys() as $language) {
//                foreach ($defaultLanguageTranslation as $translations) {
//                    $questionnaireTranslations->get($language)->push($translations);
//                }
//            }
//        }
//        return new QuestionnaireTranslation($questionnaireTranslations, $questionnaireLanguages, $questionnaire, $allLanguages, $defaultLanguage[0]);
//    }

//    private function transformAllLanguagesToArray($allLanguages) {
//        $result = [];
//        foreach ($allLanguages as $language) {
//            array_push($result, $language[0]);
//        }
//        return $result;
//    }

}
