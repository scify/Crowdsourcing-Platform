<?php

namespace App\BusinessLogicLayer\questionnaire;

use App\Models\Questionnaire\Questionnaire;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectQuestionnaireRepository;
use App\Repository\Questionnaire\QuestionnaireLanguageRepository;
use App\Repository\Questionnaire\Statistics\QuestionnaireBasicStatisticsColorsRepository;
use App\Repository\Questionnaire\Statistics\QuestionnaireStatisticsRepository;
use App\ViewModels\Questionnaire\QuestionnaireStatistics;
use App\ViewModels\Questionnaire\QuestionnaireStatisticsColors;
use Illuminate\Support\Facades\Gate;

class QuestionnaireStatisticsManager {
    protected $questionnaireStatisticsRepository;
    protected $questionnaireBasicStatisticsColorsRepository;
    protected $questionnaireLanguageRepository;
    protected $crowdSourcingProjectQuestionnaireRepository;

    public function __construct(QuestionnaireStatisticsRepository $questionnaireStatisticsRepository,
        QuestionnaireBasicStatisticsColorsRepository $questionnaireBasicStatisticsColorsRepository,
        QuestionnaireLanguageRepository $questionnaireLanguageRepository,
        CrowdSourcingProjectQuestionnaireRepository $crowdSourcingProjectQuestionnaireRepository) {
        $this->questionnaireStatisticsRepository = $questionnaireStatisticsRepository;
        $this->questionnaireBasicStatisticsColorsRepository = $questionnaireBasicStatisticsColorsRepository;
        $this->questionnaireLanguageRepository = $questionnaireLanguageRepository;
        $this->crowdSourcingProjectQuestionnaireRepository = $crowdSourcingProjectQuestionnaireRepository;
    }

    public function getQuestionnaireVisualizationsViewModel(Questionnaire $questionnaire, $projectFilter): QuestionnaireStatistics {
        $questionnaireTotalResponseStatistics = $this->questionnaireStatisticsRepository
            ->getQuestionnaireResponseStatistics($questionnaire->id);
        $numberOfResponsesPerLanguage = $this->questionnaireStatisticsRepository
            ->getNumberOfResponsesPerLanguage($questionnaire->id);
        $questionnaire->project_id = $this->crowdSourcingProjectQuestionnaireRepository->where(['questionnaire_id' => $questionnaire->id])->project_id;

        return new QuestionnaireStatistics(
            $questionnaire,
            $questionnaireTotalResponseStatistics,
            $numberOfResponsesPerLanguage,
            Gate::allows('moderate-content-by-users'),
            Gate::allows('moderate-content-by-users'),
            $projectFilter
        );
    }

    public function getEditQuestionnaireStatisticsColorViewModel(Questionnaire $questionnaire): QuestionnaireStatisticsColors {
        // load color relationships for questionnaire
        $questionnaire->load(
            'basicStatisticsColors',
            'questionnaireLanguages.language'
        );

        return new QuestionnaireStatisticsColors($questionnaire);
    }

    public function saveStatisticsColors(Questionnaire $questionnaire, array $requestData) {
        $this->saveBasicStatisticsColorsForQuestionnaire($questionnaire, $requestData['goal_responses_color'], $requestData['actual_responses_color']);
        if (isset($requestData['lang_colors'])) {
            $this->saveQuestionnaireLanguagesColors($requestData['lang_colors']);
        }
    }

    protected function saveBasicStatisticsColorsForQuestionnaire(Questionnaire $questionnaire, string $goalResponsesColor, string $actualResponsesColor) {
        return $this->questionnaireBasicStatisticsColorsRepository->updateOrCreate(
            ['questionnaire_id' => $questionnaire->id],
            [
                'questionnaire_id' => $questionnaire->id,
                'total_responses_color' => $actualResponsesColor,
                'goal_responses_color' => $goalResponsesColor,
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
}
