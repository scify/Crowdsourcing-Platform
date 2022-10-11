<?php

namespace App\BusinessLogicLayer\questionnaire;

use App\Repository\Questionnaire\Responses\QuestionnaireAnswerAnnotationRepository;
use Illuminate\Support\Collection;

class QuestionnaireAnswerAnnotator {
    protected $questionnaireAnswerAnnotationRepository;

    public function __construct(QuestionnaireAnswerAnnotationRepository $questionnaireAnswerAnnotationRepository) {
        $this->questionnaireAnswerAnnotationRepository = $questionnaireAnswerAnnotationRepository;
    }

    public function getAnswerAnnotationsForQuestionnaireAnswers(int $questionnaire_id): Collection {
        return $this->questionnaireAnswerAnnotationRepository->getAnswerAnnotationsForQuestionnaireAnswers($questionnaire_id);
    }

    public function annotateQuestionnaireAnswer(int $questionnaire_id,
                                                string $question_name,
                                                int $respondent_user_id,
                                                int $annotator_user_id,
                                                       $annotation_text,
                                                int $admin_review_status_id,
                                                       $admin_review_comment) {
        $data = [
            'questionnaire_id' => $questionnaire_id,
            'question_name' => $question_name,
            'respondent_user_id' => $respondent_user_id,
            'annotator_user_id' => $annotator_user_id,
        ];

        return $this->questionnaireAnswerAnnotationRepository->updateOrCreate(
            $data,
            array_merge($data, [
                'annotation_text' => $annotation_text,
                'admin_review_status_id' => $admin_review_status_id,
                'admin_review_comment' => $admin_review_comment,
            ]));
    }

    public function deleteAnswerAnnotation(int $questionnaire_id, string $question_name,
                                           int $respondent_user_id) {
        return $this->questionnaireAnswerAnnotationRepository->deleteAnswerAnnotation($questionnaire_id, $question_name, $respondent_user_id);
    }
}
