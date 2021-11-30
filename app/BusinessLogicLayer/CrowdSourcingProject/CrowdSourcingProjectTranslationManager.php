<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProjectTranslation;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectTranslationRepository;
use Illuminate\Support\Collection;

class CrowdSourcingProjectTranslationManager {

    protected $crowdSourcingProjectTranslationRepository;

    public function __construct(CrowdSourcingProjectTranslationRepository $crowdSourcingProjectTranslationRepository) {
        $this->crowdSourcingProjectTranslationRepository = $crowdSourcingProjectTranslationRepository;
    }

    public function getTranslationsForProject(int $project_id): Collection {
        return $this->crowdSourcingProjectTranslationRepository->allWhere(['project_id' => $project_id]);
    }

    public function storeOrUpdateTranslationsForProject(array $attributesArray, int $project_id) {
        $defaultLanguageContentForProject = $this->crowdSourcingProjectTranslationRepository->where(['project_id' => $project_id])->toArray();
        $allowedKeys = (new CrowdSourcingProjectTranslation())->getFillable();
        foreach ($attributesArray as $attributes) {
            $attributes = json_decode(json_encode($attributes), true);
            foreach ($attributes as $key => $value) {
                if (!$value)
                    $attributes[$key] = $defaultLanguageContentForProject[$key];
            }
            $filtered = array_filter(
                $attributes,
                function ($key) use ($allowedKeys) {
                    return in_array($key, $allowedKeys);
                },
                ARRAY_FILTER_USE_KEY
            );
            $filtered['project_id'] = $project_id;
            $this->crowdSourcingProjectTranslationRepository->updateOrCreate(
                ['project_id' => $project_id, 'language_id' => $filtered['language_id']],
                $filtered
            );
        }

    }
}
