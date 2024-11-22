<?php

namespace App\Http\Controllers\Questionnaire;

use App\BusinessLogicLayer\Questionnaire\QuestionnaireAnswerAnnotator;
use App\Http\Controllers\Controller;
use App\Repository\Questionnaire\Responses\QuestionnaireAnswerAdminReviewLkpRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionnaireAnswerAnnotationController extends Controller {
    protected $questionnaireAnswerAnnotator;
    protected $questionnaireAnswerAdminReviewStatusesRepository;

    public function __construct(QuestionnaireAnswerAnnotator $questionnaireAnswerAnnotator,
        QuestionnaireAnswerAdminReviewLkpRepository $adminAnalysisLkpRepository) {
        $this->questionnaireAnswerAnnotator = $questionnaireAnswerAnnotator;
        $this->questionnaireAnswerAdminReviewStatusesRepository = $adminAnalysisLkpRepository;
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
                $request->annotation_text,
                $request->admin_review_status_id,
                $request->admin_review_comment)
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

    public function getQuestionnaireAnswerAdminReviewStatuses(): JsonResponse {
        return response()->json($this->questionnaireAnswerAdminReviewStatusesRepository->all());
    }
}
