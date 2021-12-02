<?php


namespace App\BusinessLogicLayer\questionnaire;


use App\BusinessLogicLayer\gamification\PlatformWideGamificationBadgesProvider;
use App\BusinessLogicLayer\WebSessionManager;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User;
use App\Models\ViewModels\GamificationBadgeVM;
use App\Notifications\QuestionnaireResponded;
use App\Notifications\QuestionnaireShared;
use App\Notifications\ReferredQuestionnaireAnswered;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Repository\UserQuestionnaireShareRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Log;

class QuestionnaireActionHandler {

    protected $webSessionManager;
    protected $userRepository;
    protected $questionnaireResponseReferralManager;
    protected $platformWideGamificationBadgesProvider;
    protected $questionnaireShareRepository;
    protected $questionnaireResponseRepository;
    protected $questionnaireFieldsTranslationManager;

    public function __construct(WebSessionManager                      $webSessionManager,
                                UserRepository                         $userRepository,
                                QuestionnaireResponseReferralManager   $questionnaireResponseReferralManager,
                                PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider,
                                UserQuestionnaireShareRepository       $questionnaireShareRepository,
                                QuestionnaireResponseRepository        $questionnaireResponseRepository,
                                QuestionnaireFieldsTranslationManager  $questionnaireFieldsTranslationManager) {
        $this->webSessionManager = $webSessionManager;
        $this->userRepository = $userRepository;
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
        $this->questionnaireShareRepository = $questionnaireShareRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->questionnaireFieldsTranslationManager = $questionnaireFieldsTranslationManager;
    }

    public function handleQuestionnaireContributor(Questionnaire $questionnaire, CrowdSourcingProject $project, User $user) {
        //check if the contributor email should be sent
        if ($project->should_send_email_after_questionnaire_response)
            $this->awardContributorBadgeToUser($questionnaire, $project, $user);
    }

    public function awardContributorBadgeToUser(Questionnaire $questionnaire, CrowdSourcingProject $project, User $user) {
        $questionnaireIdsUserHasAnsweredTo = $this->questionnaireResponseRepository
            ->allWhere(['user_id' => $user->id])->pluck('questionnaire_id')->toArray();
        $contributorBadge = $this->platformWideGamificationBadgesProvider->getContributorBadge($questionnaireIdsUserHasAnsweredTo);
        try {
            $user->notify(new QuestionnaireResponded(
                    $questionnaire->currentFieldsTranslation,
                    $contributorBadge,
                    new GamificationBadgeVM($contributorBadge),
                    $project->defaultTranslation)
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
                $referrer->notify(new ReferredQuestionnaireAnswered(
                    $questionnaire->currentFieldsTranslation,
                    $influencerBadge, new GamificationBadgeVM($influencerBadge)));
                $this->webSessionManager->setReferrerId(null);
            }
        }
    }

    public function handleQuestionnaireSharer(Questionnaire $questionnaire, User $user) {
        if (!$this->questionnaireShareRepository->questionnaireShareExists($questionnaire->id, $user->id)) {
            $communicatorBadge = $this->platformWideGamificationBadgesProvider->getCommunicatorBadge($user->id);
            try {
                $user->notify(new QuestionnaireShared(
                    $questionnaire->currentFieldsTranslation,
                    $communicatorBadge, new GamificationBadgeVM($communicatorBadge)));
            } catch (\Exception $e) {
                Log::error($e);
            }
        }
    }

}
