<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\CrowdSourcingProject;

use App\Repository\CrowdSourcingProject\CrowdSourcingProjectColorsRepository;
use Illuminate\Database\Eloquent\Collection;

class CrowdSourcingProjectColorsManager {
    public function __construct(protected CrowdSourcingProjectColorsRepository $crowdSourcingProjectColorsRepository) {}

    public function getColorsForCrowdSourcingProjectOrDefault($project_id): Collection {
        $colors = $this->getColorsForCrowdSourcingProject($project_id);
        if ($colors->isEmpty()) {
            return $this->getDefaultColors();
        }

        return $colors;
    }

    public function getDefaultColors(): Collection {
        return $this->crowdSourcingProjectColorsRepository->allWhere(['project_id' => null]);
    }

    public function getColorsForCrowdSourcingProject($project_id): Collection {
        return $this->crowdSourcingProjectColorsRepository->allWhere(['project_id' => $project_id]);
    }

    public function saveColorsForCrowdSourcingProject(array $colors, int $project_id): void {
        $existingColorIds = $this->getColorsForCrowdSourcingProject($project_id)->pluck(['id'])->toArray();
        foreach ($colors as $color) {
            if (isset($color['id']) && in_array(intval($color['id']), $existingColorIds)) {
                $index = array_search(intval($color['id']), $existingColorIds, true);
                if ($index !== false) {
                    array_splice($existingColorIds, $index, 1);
                }
            }

            $this->crowdSourcingProjectColorsRepository->updateOrCreate(
                [
                    'project_id' => $project_id,
                    'color_name' => $color['color_name'],
                ],
                [
                    'project_id' => $project_id,
                    'color_name' => $color['color_name'],
                    'color_code' => $color['color_code'],
                ]
            );
        }

        foreach ($existingColorIds as $existingColorId) {
            $this->crowdSourcingProjectColorsRepository->delete($existingColorId);
        }
    }
}
