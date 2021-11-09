<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\questionnaire\QuestionnaireAnswerAnnotator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionnaireAnswerAnnotationController extends Controller {
    protected $questionnaireAnswerAnnotator;

    public function __construct(QuestionnaireAnswerAnnotator $questionnaireAnswerAnnotator) {
        $this->questionnaireAnswerAnnotator = $questionnaireAnswerAnnotator;
    }

    public function getAnswerAnnotationsForQuestionnaireAnswers(int $questionnaire_id): JsonResponse {
        return response()->json($this->questionnaireAnswerAnnotator
            ->getAnswerAnnotationsForQuestionnaireAnswers($questionnaire_id));
    }

    public function annotateAnswer(Request $request): JsonResponse {
        return response()->json($this->questionnaireAnswerAnnotator
            ->annotateQuestionnaireAnswer(
                $request->questionnaire_id,
                $request->question_name,
                $request->respondent_user_id,
                $request->annotator_user_id,
                $request->annotation_text)
        );
    }

    public function deleteAnswerAnnotation(Request $request): JsonResponse {
        return response()->json($this->questionnaireAnswerAnnotator
            ->deleteAnswerAnnotation(
                $request->questionnaire_id,
                $request->question_name,
                $request->respondent_user_id)
        );
    }
}
