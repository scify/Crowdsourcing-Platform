<?php

declare(strict_types=1);

namespace App\ViewModels\Questionnaire;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;

class QuestionnaireSocialShareButtons {
    /**
     * @var \App\Models\Questionnaire\Questionnaire
     */
    public $questionnaire;

    /**
     * QuestionnaireSocialShareButtons constructor.
     *
     * @param  $questionnaire  Questionnaire the questionnaire to be shared
     * @param  $referrerId  int (optional) the id of the user that will share
     *                     the questionnaire
     */
    public function __construct(Questionnaire $questionnaire, public $referrerId = null) {
        $this->questionnaire = $questionnaire;
    }

    public function getSocialShareURL(CrowdSourcingProject $project, $medium): string {
        $url = match ($medium) {
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=',
            'twitter' => 'https://x.com/share?url=',
            default => '',
        };

        return $url . route('project.landing-page',
            ['locale' => app()->getLocale(), 'slug' => $project->slug]) . urlencode('?open=1&referrerId=' . $this->referrerId . '&questionnaireId=' . $this->questionnaire->id);
    }
}
