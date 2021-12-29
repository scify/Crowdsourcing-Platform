<?php


namespace App\BusinessLogicLayer\questionnaire;


use App\BusinessLogicLayer\gamification\PlatformWideGamificationBadgesProvider;
use App\BusinessLogicLayer\LanguageManager;
use App\BusinessLogicLayer\WebSessionManager;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Language;
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

class QuestionnaireActionHandler
{

    protected $webSessionManager;
    protected $userRepository;
    protected $questionnaireResponseReferralManager;
    protected $platformWideGamificationBadgesProvider;
    protected $questionnaireShareRepository;
    protected $questionnaireResponseRepository;
    protected $questionnaireFieldsTranslationManager;
    protected $languageManager;

    public function __construct(WebSessionManager                      $webSessionManager,
                                UserRepository                         $userRepository,
                                QuestionnaireResponseReferralManager   $questionnaireResponseReferralManager,
                                PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider,
                                UserQuestionnaireShareRepository       $questionnaireShareRepository,
                                QuestionnaireResponseRepository        $questionnaireResponseRepository,
                                QuestionnaireFieldsTranslationManager  $questionnaireFieldsTranslationManager,
                                LanguageManager                        $languageManager)
    {
        $this->webSessionManager = $webSessionManager;
        $this->userRepository = $userRepository;
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
        $this->questionnaireShareRepository = $questionnaireShareRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->questionnaireFieldsTranslationManager = $questionnaireFieldsTranslationManager;
        $this->languageManager = $languageManager;
    }

    public function handleQuestionnaireContributor(Questionnaire $questionnaire,
                                                   CrowdSourcingProject $project,
                                                   User $user,
                                                   Language $language)
    {
        //check if the contributor email should be sent
        if ($project->should_send_email_after_questionnaire_response)
            $this->awardContributorBadgeToUser($questionnaire, $project, $user,$language);
    }

    public function awardContributorBadgeToUser(Questionnaire $questionnaire, CrowdSourcingProject $project,
                                                User $user,
                                                Language $language)
    {
        $questionnaireIdsUserHasAnsweredTo = $this->questionnaireResponseRepository
            ->allWhere(['user_id' => $user->id])->pluck('questionnaire_id')->toArray();
        $contributorBadge = $this->platformWideGamificationBadgesProvider->getContributorBadge($questionnaireIdsUserHasAnsweredTo);

        $project_translation = $project->translations->firstWhere("language_id","=",$language->id);
        $questionnaire_translation = $questionnaire->fieldsTranslations->firstWhere("language_id","=",$language->id);
        $event = new QuestionnaireResponded(
            $questionnaire_translation,
            $contributorBadge,
            new GamificationBadgeVM($contributorBadge),
            $project_translation,
            $language->language_code);

        $user->notify($event);
    }


    public function handleQuestionnaireReferrer(Questionnaire $questionnaire,
                                                User $user,
                                                Language $language)
    {
        $referrerId = $this->webSessionManager->getReferredId();
        if ($referrerId) {
            $referrer = $this->userRepository->getUser($referrerId);
            if ($referrer && $referrerId !== $user->id) {
                $this->questionnaireResponseReferralManager->createQuestionnaireResponseReferral($questionnaire->id, $user->id, $referrer->id);
                $influencerBadge = $this->platformWideGamificationBadgesProvider->getInfluencerBadge($referrer->id);
                $referrer->notify(new ReferredQuestionnaireAnswered(
                    $questionnaire->currentFieldsTranslation,
                    $influencerBadge,
                    new GamificationBadgeVM($influencerBadge),
                    $language->language_code));
                $this->webSessionManager->setReferrerId(null);
            }
        }
    }

    public function handleQuestionnaireSharer(Questionnaire $questionnaire, User $user, Language $language)
    {
        if (!$this->questionnaireShareRepository->questionnaireShareExists($questionnaire->id, $user->id)) {
            $communicatorBadge = $this->platformWideGamificationBadgesProvider->getCommunicatorBadge($user->id);
            $user->notify(new QuestionnaireShared(
                $questionnaire->currentFieldsTranslation,
                $communicatorBadge,
                new GamificationBadgeVM($communicatorBadge),
                $language->language_code));

        }
    }

}
