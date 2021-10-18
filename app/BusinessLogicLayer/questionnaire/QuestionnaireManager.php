<?php

namespace App\BusinessLogicLayer\questionnaire;

use App\Repository\CrowdSourcingProject\CrowdSourcingProjectQuestionnaireRepository;
use App\Repository\Questionnaire\QuestionnaireLanguageRepository;
use App\Repository\Questionnaire\QuestionnaireRepository;

class QuestionnaireManager {
    protected $questionnaireRepository;
    protected $crowdSourcingProjectQuestionnaireRepository;
    protected $questionnaireLanguageRepository;

    public function __construct(QuestionnaireRepository                     $questionnaireRepository,
                                CrowdSourcingProjectQuestionnaireRepository $crowdSourcingProjectQuestionnaireRepository,
                                QuestionnaireLanguageRepository             $questionnaireLanguageRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->crowdSourcingProjectQuestionnaireRepository = $crowdSourcingProjectQuestionnaireRepository;
        $this->questionnaireLanguageRepository = $questionnaireLanguageRepository;
    }

    public function updateQuestionnaireStatus($questionnaireId, $statusId, $comments) {
        $comments = is_null($comments) ? "" : $comments;
        $this->questionnaireRepository->updateQuestionnaireStatus($questionnaireId, $statusId, $comments);
    }

    public function storeOrUpdateQuestionnaire($data, $id = null) {
        if (!$id)
            $questionnaire = $this->questionnaireRepository->saveNewQuestionnaire(
                $data['title'], $data['description'],
                $data['goal'], $data['language'], $data['content'],
                $data['statistics_page_visibility_lkp_id']
            );
        else
            $questionnaire = $this->questionnaireRepository->updateQuestionnaire($id,
                $data['title'], $data['description'],
                $data['goal'], $data['language'], $data['content'],
                $data['statistics_page_visibility_lkp_id']);
        $questionnaireData = [
            'questionnaire_id' => $questionnaire->id,
            'language_id' => $questionnaire->defaultLanguage->id
        ];
        $this->questionnaireLanguageRepository->updateOrCreate($questionnaireData, $questionnaireData);
        $this->crowdSourcingProjectQuestionnaireRepository->setQuestionnaireToProjects($questionnaire->id, $data['project_ids']);
        return $questionnaire;
    }

}
