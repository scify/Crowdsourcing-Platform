<?php

namespace App\ViewModels\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Utils\Helpers;

abstract class CrowdSourcingProjectLayoutPage {
    public CrowdSourcingProject $project;

    public function __construct(CrowdSourcingProject $crowdSourcingProject) {
        $this->project = $crowdSourcingProject;
    }

    public function projectHasExternalURL(): bool {
        return isset($this->project)
            && !empty($this->project->external_url)
            && $this->project->external_url !== null
            && starts_with($this->project->external_url, ['http', 'https'])
            && filter_var($this->project->external_url, FILTER_VALIDATE_URL);
    }

    public function projectHasCustomFooter(): bool {
        return Helpers::HTMLValueIsNotEmpty($this->project->defaultTranslation->footer);
    }
}
