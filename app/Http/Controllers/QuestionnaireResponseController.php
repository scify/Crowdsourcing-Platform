<?php


namespace App\Http\Controllers;


use App\BusinessLogicLayer\gamification\PlatformWideGamificationBadgesProvider;
use App\BusinessLogicLayer\questionnaire\QuestionnaireResponseManager;
use App\Models\ViewModels\GamificationBadgeVM;
use Illuminate\Http\Request;

class QuestionnaireResponseController extends Controller {

    protected $questionnaireResponseManager;
    protected $platformWideGamificationBadgesProvider;

    public function __construct(QuestionnaireResponseManager $questionnaireResponseManager,
                                PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider,) {
        $this->questionnaireResponseManager = $questionnaireResponseManager;
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
    }

    public function storeQuestionnaireResponse(Request $request) {
        $this->questionnaireResponseManager->storeQuestionnaireResponse($request->all());
        $badge = new GamificationBadgeVM($this->platformWideGamificationBadgesProvider->getContributorBadge(\Auth::id()));
        return response()->json(['status' => '__SUCCESS', 'badgeHTML' => (string)view('gamification.badge-single', compact('badge'))]);
    }
}
