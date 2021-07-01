<?php


namespace App\BusinessLogicLayer\questionnaire;


use App\Models\Questionnaire;
use App\Models\ViewModels\Questionnaire\QuestionnaireStatistics;
use App\Models\ViewModels\Questionnaire\QuestionnaireStatisticsColors;
use App\Repository\Questionnaire\QuestionnaireLanguageRepository;
use App\Repository\Questionnaire\QuestionnairePossibleAnswerRepository;
use App\Repository\Questionnaire\Statistics\QuestionnaireBasicStatisticsColorsRepository;
use App\Repository\Questionnaire\Statistics\QuestionnaireStatisticsRepository;
use Illuminate\Support\Facades\Gate;

class QuestionnaireStatisticsManager {

    protected $questionnaireStatisticsRepository;
    protected $questionnaireBasicStatisticsColorsRepository;
    protected $questionnaireLanguageRepository;
    protected $questionnairePossibleAnswerRepository;

    public function __construct(QuestionnaireStatisticsRepository $questionnaireStatisticsRepository,
                                QuestionnaireBasicStatisticsColorsRepository $questionnaireBasicStatisticsColorsRepository,
                                QuestionnaireLanguageRepository $questionnaireLanguageRepository,
                                QuestionnairePossibleAnswerRepository $questionnairePossibleAnswerRepository) {
        $this->questionnaireStatisticsRepository = $questionnaireStatisticsRepository;
        $this->questionnaireBasicStatisticsColorsRepository = $questionnaireBasicStatisticsColorsRepository;
        $this->questionnaireLanguageRepository = $questionnaireLanguageRepository;
        $this->questionnairePossibleAnswerRepository = $questionnairePossibleAnswerRepository;
    }


    public function getQuestionnaireVisualizationsViewModel(Questionnaire $questionnaire) {
        $project = $questionnaire->project;
        $questionnaireTotalResponseStatistics = $this->questionnaireStatisticsRepository
            ->getQuestionnaireResponseStatistics($questionnaire->id);
        $numberOfResponsesPerLanguage = $this->questionnaireStatisticsRepository
            ->getNumberOfResponsesPerLanguage($questionnaire->id);
        $statisticsPerQuestion = $this->questionnaireStatisticsRepository
            ->getStatisticsPerQuestion($questionnaire);
        return new QuestionnaireStatistics (
            $questionnaire,
            $project,
            $questionnaireTotalResponseStatistics,
            $numberOfResponsesPerLanguage,
            $statisticsPerQuestion,
            Gate::allows('manage-crowd-sourcing-projects')
        );
    }

    public function getEditQuestionnaireStatisticsColorViewModel(Questionnaire $questionnaire) {
        // load color relationships for questionnaire
        $questionnaire->load(
            'basicStatisticsColors',
            'questionnaireLanguages.language'
        );
        $questionnaire->load(['questions' => function ($query) {
            $query->whereIn('type', ['radiogroup', 'checkbox', 'rating']);
        }]);
        $questionnaire->questions->load('possibleAnswers');
        //dd($questionnaire);
        return new QuestionnaireStatisticsColors($questionnaire);
    }

    public function saveStatisticsColors(Questionnaire $questionnaire, array $requestData) {
        $this->saveBasicStatisticsColorsForQuestionnaire($questionnaire, $requestData['goal_responses_color'], $requestData['actual_responses_color']);
        if(isset($requestData['lang_colors']))
            $this->saveQuestionnaireLanguagesColors($requestData['lang_colors']);
        if(isset($requestData['answer_colors']))
            $this->saveQuestionnairePossibleAnswersColors($requestData['answer_colors']);
    }

    protected function saveBasicStatisticsColorsForQuestionnaire(Questionnaire $questionnaire, string $goalResponsesColor, string $actualResponsesColor) {
        return $this->questionnaireBasicStatisticsColorsRepository->updateOrCreate(
            ['questionnaire_id' => $questionnaire->id],
            [
                'questionnaire_id' => $questionnaire->id,
                'total_responses_color' => $actualResponsesColor,
                'goal_responses_color' => $goalResponsesColor
            ]
        );
    }

    protected function saveQuestionnaireLanguagesColors(array $languagesIdsToColors) {
        foreach ($languagesIdsToColors as $questionnaireLanguageId => $color) {
            $this->questionnaireLanguageRepository->updateOrCreate(
                ['id' => $questionnaireLanguageId],
                ['color' => $color]
            );
        }
    }

    protected function saveQuestionnairePossibleAnswersColors(array $questionnairePossibleAnswerIdsToColors) {
        foreach ($questionnairePossibleAnswerIdsToColors as $questionnairePossibleAnswerId => $color) {
            $this->questionnairePossibleAnswerRepository->updateOrCreate(
                ['id' => $questionnairePossibleAnswerId],
                ['color' => $color]
            );
        }
    }

}
