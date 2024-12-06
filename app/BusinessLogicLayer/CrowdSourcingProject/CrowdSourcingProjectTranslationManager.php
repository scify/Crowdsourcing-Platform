<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\CrowdSourcingProject\CrowdSourcingProjectTranslation;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectTranslationRepository;
use App\Repository\LanguageRepository;
use App\Utils\Helpers;
use Illuminate\Support\Collection;

class CrowdSourcingProjectTranslationManager {
    protected $crowdSourcingProjectTranslationRepository;
    protected $languageRepository;

    public function __construct(CrowdSourcingProjectTranslationRepository $crowdSourcingProjectTranslationRepository,
        LanguageRepository $languageRepository) {
        $this->crowdSourcingProjectTranslationRepository = $crowdSourcingProjectTranslationRepository;
        $this->languageRepository = $languageRepository;
    }

    public function getFieldsTranslationForProject(CrowdSourcingProject $project): CrowdSourcingProjectTranslation {
        $language = $this->languageRepository->where(['language_code' => app()->getLocale()]);
        if (!$language) {
            return $project->defaultTranslation;
        }
        $fieldsTranslation = $this->crowdSourcingProjectTranslationRepository->where([
            'project_id' => $project->id,
            'language_id' => $language->id,
        ]);

        return $fieldsTranslation ?: $project->defaultTranslation;
    }

    public function getTranslationsForProject(CrowdSourcingProject $project): Collection {
        if (!$project->id) {
            return new Collection;
        }

        return $this->crowdSourcingProjectTranslationRepository->allWhere(['project_id' => $project->id]);
    }

    public function storeOrUpdateDefaultTranslationForProject(array $attributes, int $project_id): void {
        $allowedKeys = (new CrowdSourcingProjectTranslation)->getFillable();
        $filtered = Helpers::getFilteredAttributes($attributes, $allowedKeys);
        $this->crowdSourcingProjectTranslationRepository->updateOrCreate(
            ['project_id' => $project_id, 'language_id' => $filtered['language_id']],
            $filtered
        );
    }

    public function storeOrUpdateExtraTranslationsForProject(array $extraTranslations, int $project_id, int $language_id): void {
        $defaultLanguageContentForProject = $this->crowdSourcingProjectTranslationRepository->where([
            'project_id' => $project_id, 'language_id' => $language_id, ])
            ->toArray();
        $allowedKeys = (new CrowdSourcingProjectTranslation)->getFillable();
        foreach ($extraTranslations as $extraTranslation) {
            $extraTranslation = json_decode(json_encode($extraTranslation), true);
            foreach ($extraTranslation as $key => $value) {
                if (!$value) {
                    $extraTranslation[$key] = $defaultLanguageContentForProject[$key] && $defaultLanguageContentForProject[$key] !== '<p><br></p>' ?
                        $defaultLanguageContentForProject[$key] : null;
                }
            }
            $filtered = Helpers::getFilteredAttributes($extraTranslation, $allowedKeys);
            $filtered['project_id'] = $project_id;
            $this->crowdSourcingProjectTranslationRepository->updateOrCreate(
                ['project_id' => $project_id, 'language_id' => $filtered['language_id']],
                $filtered
            );
        }
    }
}
