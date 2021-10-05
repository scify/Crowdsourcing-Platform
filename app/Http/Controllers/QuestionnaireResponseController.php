<?php


namespace App\Http\Controllers;


use App\BusinessLogicLayer\gamification\PlatformWideGamificationBadgesProvider;
use App\BusinessLogicLayer\questionnaire\QuestionnaireResponseManager;
use App\Models\ViewModels\GamificationBadgeVM;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireResponseController extends Controller {

    protected $questionnaireResponseManager;
    protected $platformWideGamificationBadgesProvider;

    public function __construct(QuestionnaireResponseManager           $questionnaireResponseManager,
                                PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider) {
        $this->questionnaireResponseManager = $questionnaireResponseManager;
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
    }

    public function store(Request $request): JsonResponse {
        $questionnaireResponse = $this->questionnaireResponseManager->storeQuestionnaireResponse($request->all());
        $badge = new GamificationBadgeVM($this->platformWideGamificationBadgesProvider->getContributorBadge($questionnaireResponse->user_id));
        return response()->json([
            'badgeHTML' => (string)view('gamification.badge-single', compact('badge')),
            'anonymousUserId' => Auth::check() ? null : $questionnaireResponse->user_id
        ]);
    }

    public function getResponsesForQuestionnaire(int $questionnaire_id): JsonResponse {
        return response()->json($this->questionnaireResponseManager->getQuestionnaireResponsesForQuestionnaire($questionnaire_id));
    }

    public function getAnswerVotesForQuestionnaireAnswers(int $questionnaire_id): JsonResponse {
        return response()->json($this->questionnaireResponseManager
            ->getAnswerVotesForQuestionnaireAnswers($questionnaire_id, Auth::id()));
    }

    public function voteAnswer(Request $request): JsonResponse {
        return response()->json($this->questionnaireResponseManager
            ->voteAnswer($request->questionnaire_id, $request->question_name, $request->respondent_user_id, $request->upvote));
    }

    public function destroy(Request $request) {
        $this->validate($request, [
            'questionnaire_response_id' => 'required|integer|exists:questionnaire_responses,id'
        ]);
        return $this->questionnaireResponseManager->deleteResponse($request->questionnaire_response_id);
    }
}
