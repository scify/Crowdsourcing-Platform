<?php

namespace App\BusinessLogicLayer\questionnaire;

use App\Repository\CrowdSourcingProject\CrowdSourcingProjectQuestionnaireRepository;
use App\Repository\Questionnaire\QuestionnaireLanguageRepository;
use App\Repository\Questionnaire\QuestionnaireRepository;

class QuestionnaireManager {
    protected $questionnaireRepository;
    protected $crowdSourcingProjectQuestionnaireRepository;
    protected $questionnaireLanguageRepository;
    protected $questionnaireFieldsTranslationManager;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                CrowdSourcingProjectQuestionnaireRepository $crowdSourcingProjectQuestionnaireRepository,
                                QuestionnaireLanguageRepository $questionnaireLanguageRepository,
                                QuestionnaireFieldsTranslationManager $questionnaireFieldsTranslationManager) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->crowdSourcingProjectQuestionnaireRepository = $crowdSourcingProjectQuestionnaireRepository;
        $this->questionnaireLanguageRepository = $questionnaireLanguageRepository;
        $this->questionnaireFieldsTranslationManager = $questionnaireFieldsTranslationManager;
    }

    public function updateQuestionnaireStatus($questionnaireId, $statusId, $comments) {
        $comments = is_null($comments) ? '' : $comments;
        $this->questionnaireRepository->updateQuestionnaireStatus($questionnaireId, $statusId, $comments);
    }

    public function storeOrUpdateQuestionnaire($data, $id = null) {
        if (! $id) {
            $questionnaire = $this->questionnaireRepository->saveNewQuestionnaire(
                $data['goal'], $data['language'], $data['content'],
                $data['statistics_page_visibility_lkp_id'],
                $data['max_votes_num'],
                $data['show_general_statistics'], $data['type_id']
            );
        } else {
            $questionnaire = $this->questionnaireRepository->updateQuestionnaire($id,
                $data['goal'], $data['language'], $data['content'],
                $data['statistics_page_visibility_lkp_id'],
                $data['max_votes_num'],
                $data['show_general_statistics'], $data['type_id']);
        }
        $questionnaireData = [
            'questionnaire_id' => $questionnaire->id,
            'language_id' => $questionnaire->defaultLanguage->id,
        ];
        $this->questionnaireLanguageRepository->updateOrCreate($questionnaireData, $questionnaireData);
        $this->crowdSourcingProjectQuestionnaireRepository->setQuestionnaireToProjects($questionnaire->id, $data['project_ids']);
        $this->questionnaireFieldsTranslationManager->storeOrUpdateDefaultFieldsTranslationForQuestionnaire([
            'title' => $data['title'],
            'description' => $data['description'],
            'language_id' => $data['language'],
            'questionnaire_id' => $questionnaire->id,
        ], $questionnaire->id);
        if (isset($data['extra_fields_translations'])) {
            $this->questionnaireFieldsTranslationManager->storeOrUpdateFieldsTranslationsForQuestionnaire(
                json_decode($data['extra_fields_translations']), $questionnaire->id, $data['language']);
        }

        return $questionnaire;
    }
}
