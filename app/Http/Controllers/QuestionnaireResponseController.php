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

    public function __construct(QuestionnaireResponseManager $questionnaireResponseManager,
                                PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider) {
        $this->questionnaireResponseManager = $questionnaireResponseManager;
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
    }

    public function store(Request $request): JsonResponse {
        $this->questionnaireResponseManager->storeQuestionnaireResponse($request->all());
        $badge = new GamificationBadgeVM($this->platformWideGamificationBadgesProvider->getContributorBadge(Auth::id()));
        return response()->json(['badgeHTML' => (string)view('gamification.badge-single', compact('badge'))]);
    }

    public function getResponsesForQuestionnaire(int $questionnaire_id): JsonResponse {
        return response()->json($this->questionnaireResponseManager->getQuestionnaireResponsesForQuestionnaire($questionnaire_id));
    }
}
