<?php


namespace App\BusinessLogicLayer\questionnaire;


use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use App\Models\ViewModels\reports\QuestionnaireReportFilters;
use App\Models\ViewModels\reports\QuestionnaireReportResults;
use App\Repository\Questionnaire\Reports\QuestionnaireReportRepository;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseAnswerRepository;

class QuestionnaireReportManager {

    protected $crowdsourcingProjectManager;
    protected $questionnaireRepository;
    protected $questionnaireReportRepository;
    protected $questionnaireResponseAnswerRepository;

    public function __construct(CrowdSourcingProjectManager $crowdsourcingProjectManager,
                                QuestionnaireRepository $questionnaireRepository,
                                QuestionnaireReportRepository $questionnaireReportRepository,
                                QuestionnaireResponseAnswerRepository $questionnaireResponseAnswerRepository) {
        $this->crowdsourcingProjectManager = $crowdsourcingProjectManager;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireReportRepository = $questionnaireReportRepository;
        $this->questionnaireResponseAnswerRepository = $questionnaireResponseAnswerRepository;
    }


    public function getCrowdSourcingProjectReportsViewModel($selectedProjectId = null, $selectedQuestionnaireId = null) {
        $allQuestionnaires = $this->questionnaireRepository->all();
        return new QuestionnaireReportFilters($allQuestionnaires, $selectedProjectId, $selectedQuestionnaireId);
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

}
