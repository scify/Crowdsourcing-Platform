<?php


namespace App\BusinessLogicLayer\CrowdSourcingProject;


use App\Repository\CrowdSourcingProject\CrowdSourcingProjectColorsRepository;
use Illuminate\Database\Eloquent\Collection;

class CrowdSourcingProjectColorsManager {

    protected $crowdSourcingProjectColorsRepository;

    public function __construct(CrowdSourcingProjectColorsRepository $crowdSourcingProjectColorsRepository) {
        $this->crowdSourcingProjectColorsRepository = $crowdSourcingProjectColorsRepository;
    }

    public function getColorsForCrowdSourcingProjectOrDefault(int $project_id): Collection {
        $colors = $this->getColorsForCrowdSourcingProject($project_id);
        if ($colors->isEmpty())
            $colors = $this->getDefaultColors();
        return $colors;
    }

    public function getDefaultColors(): Collection {
        return $this->crowdSourcingProjectColorsRepository->allWhere(['project_id' => null]);
    }

    public function getColorsForCrowdSourcingProject(int $project_id): Collection {
        return $this->crowdSourcingProjectColorsRepository->allWhere(['project_id' => $project_id]);
    }

    public function saveColorsForCrowdSourcingProject(array $colors, int $project_id) {
        $existingColorIds = $this->getColorsForCrowdSourcingProject($project_id)->pluck(['id'])->toArray();
        foreach ($colors as $color) {
            if (isset($color['id']) && in_array($color['id'], $existingColorIds))
                array_splice($existingColorIds, array_search($color['id'], $existingColorIds), 1);
            $this->crowdSourcingProjectColorsRepository->updateOrCreate(
                [
                    'project_id' => $project_id,
                    'color_name' => $color['color_name']
                ],
                [
                    'project_id' => $project_id,
                    'color_name' => $color['color_name'],
                    'color_code' => $color['color_code']
                ]
            );
        }
        foreach ($existingColorIds as $colorId) {
            $this->crowdSourcingProjectColorsRepository->delete($colorId);
        }
    }

}
