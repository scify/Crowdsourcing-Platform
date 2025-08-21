<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Questionnaire;

use App\Repository\CrowdSourcingProject\CrowdSourcingProjectQuestionnaireRepository;
use App\Repository\Questionnaire\QuestionnaireLanguageRepository;
use App\Repository\Questionnaire\QuestionnaireRepository;

class QuestionnaireManager {
    public function __construct(protected QuestionnaireRepository $questionnaireRepository, protected CrowdSourcingProjectQuestionnaireRepository $crowdSourcingProjectQuestionnaireRepository, protected QuestionnaireLanguageRepository $questionnaireLanguageRepository, protected QuestionnaireFieldsTranslationManager $questionnaireFieldsTranslationManager) {}

    public function updateQuestionnaireStatus($questionnaireId, $statusId, $comments): void {
        $comments = is_null($comments) ? '' : $comments;
        $this->questionnaireRepository->updateQuestionnaireStatus($questionnaireId, $statusId, $comments);
    }

    public function storeOrUpdateQuestionnaire($data, $id = null) {
        if (! $id) {
            $questionnaire = $this->questionnaireRepository->saveNewQuestionnaire(
                $data['goal'], $data['language'], $data['content'],
                $data['statistics_page_visibility_lkp_id'],
                $data['max_votes_num'],
                $data['show_general_statistics'],
                $data['type_id'],
                $data['respondent_auth_required'],
                $data['show_file_type_questions_to_statistics_page_audience']
            );
        } else {
            $questionnaire_json_old = $this->questionnaireRepository->find($id)->questionnaire_json;
            $questionnaire = $this->questionnaireRepository->updateQuestionnaire($id,
                $data['goal'], $data['language'], $data['content'],
                $data['statistics_page_visibility_lkp_id'],
                $data['max_votes_num'],
                $data['show_general_statistics'],
                $data['type_id'],
                $data['respondent_auth_required'],
                $data['show_file_type_questions_to_statistics_page_audience']);
            $this->questionnaireRepository->saveNewQuestionnaireStatusHistory($questionnaire->id, null, 'Updated by user ' . auth()->user()->id, $questionnaire_json_old);
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
