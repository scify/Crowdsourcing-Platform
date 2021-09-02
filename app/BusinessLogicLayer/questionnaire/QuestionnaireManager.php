<?php

namespace App\BusinessLogicLayer\questionnaire;

use App\Repository\CrowdSourcingProject\CrowdSourcingProjectQuestionnaireRepository;
use App\Repository\Questionnaire\QuestionnaireRepository;

class QuestionnaireManager {
    protected $questionnaireRepository;
    protected $crowdSourcingProjectQuestionnaireRepository;

    public function __construct(QuestionnaireRepository                     $questionnaireRepository,
                                CrowdSourcingProjectQuestionnaireRepository $crowdSourcingProjectQuestionnaireRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->crowdSourcingProjectQuestionnaireRepository = $crowdSourcingProjectQuestionnaireRepository;
    }

    public function updateQuestionnaireStatus($questionnaireId, $statusId, $comments) {
        $comments = is_null($comments) ? "" : $comments;
        $this->questionnaireRepository->updateQuestionnaireStatus($questionnaireId, $statusId, $comments);
    }

    public function storeQuestionnaire($data) {
        $questionnaire = $this->questionnaireRepository->saveNewQuestionnaire(
            $data['title'], $data['description'],
            $data['goal'], $data['language'], $data['content'],
            $data['statistics_page_visibility_lkp_id']
        );
        $this->crowdSourcingProjectQuestionnaireRepository->setQuestionnaireToProjects($questionnaire->id, $data['project_ids']);
        return $questionnaire;
    }

    public function updateQuestionnaire($id, $data) {
        $questionnaire = $this->questionnaireRepository->updateQuestionnaire($id,
            $data['title'], $data['description'],
            $data['goal'], $data['language'], $data['content'],
            $data['statistics_page_visibility_lkp_id']);
        $this->crowdSourcingProjectQuestionnaireRepository->setQuestionnaireToProjects($questionnaire->id, $data['project_ids']);
        return $questionnaire;
    }

}
