<?php

declare(strict_types=1);

namespace App\ViewModels\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Utils\Helpers;

abstract class CrowdSourcingProjectLayoutPage {
    public function __construct(public CrowdSourcingProject $project) {}

    public function projectHasExternalURL(): bool {
        return isset($this->project)
            && ! empty($this->project->external_url)
            && $this->project->external_url !== null
            && starts_with($this->project->external_url, ['http', 'https'])
            && filter_var($this->project->external_url, FILTER_VALIDATE_URL);
    }

    public function projectHasCustomFooter(): bool {
        return Helpers::HTMLValueIsNotEmpty($this->project->defaultTranslation->footer);
    }
}
