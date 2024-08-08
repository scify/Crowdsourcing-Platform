<?php

namespace App\ViewModels;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Language;
use Illuminate\Support\Collection;

class CreateEditCrowdSourcingProject {
    public $project;
    public $translations;
    public $projectStatusesLkp;
    public $contributorEmailView;
    public $translationsMetaData;
    public $languagesLkp;
    public $defaultLanguageCode = 'en';

    public function __construct(CrowdSourcingProject $project, Collection $translations,
        Collection $projectStatusesLkp,
        Collection $languagesLkp, string $contributorEmailView) {
        $this->project = $project;
        $this->translations = $translations;
        $this->projectStatusesLkp = $projectStatusesLkp;
        $this->languagesLkp = $languagesLkp;
        $this->contributorEmailView = $contributorEmailView;
        $this->translationsMetaData = [
            'name' => [
                'display_title' => 'Project Name (*)',
                'required' => true,
            ],
            'description' => [
                'display_title' => 'Project description (*)',
                'required' => true,
            ],
            'motto_title' => [
                'display_title' => 'Project Motto Title (*)',
                'required' => true,
            ],
            'motto_subtitle' => [
                'display_title' => 'Project Motto Subtitle',
                'required' => true,
            ],
            'about' => [
                'display_title' => 'About Text (*)',
                'required' => true,
            ],
            'footer' => [
                'display_title' => 'Footer Text (*)',
                'required' => true,
            ],
            'sm_title' => [
                'display_title' => 'Social Media Title',
                'required' => true,
            ],
            'sm_description' => [
                'display_title' => 'Social Media Description',
                'required' => true,
            ],
            'sm_keywords' => [
                'display_title' => 'Social Media Keywords',
                'required' => true,
            ],
            'questionnaire_response_email_intro_text' => [
                'display_title' => 'Congratulations email intro text',
                'required' => true,
            ],
            'questionnaire_response_email_outro_text' => [
                'display_title' => 'Congratulations email outro text',
                'required' => true,
            ],
            'banner_title' => [
                'display_title' => 'Landing page banner title',
                'required' => false,
            ],
            'banner_text' => [
                'display_title' => 'Landing page banner text',
                'required' => false,
            ],
        ];
    }

    public function isEditMode(): bool {
        return $this->project->id !== null;
    }

    public function shouldLanguageBeSelected(Language $language): bool {
        if ($this->project->language_id) {
            return $this->project->language_id == $language->id;
        }

        return $language->language_code === $this->defaultLanguageCode;
    }
}
