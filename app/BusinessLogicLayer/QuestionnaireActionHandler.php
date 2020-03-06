<?php


namespace App\BusinessLogicLayer;


use App\BusinessLogicLayer\gamification\PlatformWideGamificationBadgesProvider;
use App\Models\Questionnaire;
use App\Models\User;
use App\Models\ViewModels\GamificationBadgeVM;
use App\Notifications\QuestionnaireResponded;
use App\Notifications\QuestionnaireShared;
use App\Notifications\ReferredQuestionnaireAnswered;
use App\Repository\UserQuestionnaireShareRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Log;

class QuestionnaireActionHandler {

    protected $webSessionManager;
    protected $userRepository;
    protected $questionnaireResponseReferralManager;
    protected $platformWideGamificationBadgesProvider;
    protected $questionnaireShareRepository;

    public function __construct(WebSessionManager $webSessionManager,
                                UserRepository $userRepository,
                                QuestionnaireResponseReferralManager $questionnaireResponseReferralManager,
                                PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider,
                                UserQuestionnaireShareRepository $questionnaireShareRepository) {
        $this->webSessionManager = $webSessionManager;
        $this->userRepository = $userRepository;
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
        $this->questionnaireShareRepository = $questionnaireShareRepository;
    }

    public function handleQuestionnaireContributor(Questionnaire $questionnaire, User $user) {
        $contributorBadge = $this->platformWideGamificationBadgesProvider->getContributorBadge($user->id);
        try {
            $user->notify(new QuestionnaireResponded(
                $questionnaire,
                $contributorBadge,
                new GamificationBadgeVM($contributorBadge),
                $questionnaire->project->communicationResources)
            );
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function handleQuestionnaireReferrer(Questionnaire $questionnaire, User $user) {
        $referrerId = $this->webSessionManager->getReferredId();
        if ($referrerId) {
            $referrer = $this->userRepository->getUser($referrerId);
            if ($referrer && $referrerId !== $user->id) {
                $this->questionnaireResponseReferralManager->createQuestionnaireResponseReferral($questionnaire->id, $user->id, $referrer->id);
                $influencerBadge = $this->platformWideGamificationBadgesProvider->getInfluencerBadge($referrer->id);
                $referrer->notify(new ReferredQuestionnaireAnswered($questionnaire, $influencerBadge, new GamificationBadgeVM($influencerBadge)));
                $this->webSessionManager->setReferrerId(null);
            }
        }
    }

    public function handleQuestionnaireSharer(Questionnaire $questionnaire, User $user) {
        if(!$this->questionnaireShareRepository->questionnaireShareExists($questionnaire->id, $user->id)) {
            $communicatorBadge = $this->platformWideGamificationBadgesProvider->getCommunicatorBadge($user->id);
            try {
                $user->notify(new QuestionnaireShared($questionnaire, $communicatorBadge, new GamificationBadgeVM($communicatorBadge)));
            } catch (\Exception $e) {
                Log::error($e);
            }
        }
    }

}
