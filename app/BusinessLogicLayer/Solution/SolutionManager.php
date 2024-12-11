<?php

namespace App\BusinessLogicLayer\Solution;

use App\BusinessLogicLayer\lkp\SolutionStatusLkp;
use App\Models\Solution\Solution;
use App\Models\Solution\SolutionTranslation;
use App\Repository\LanguageRepository;
use App\Repository\Problem\ProblemRepository;
use App\Repository\Solution\SolutionRepository;
use App\Utils\FileHandler;
use App\ViewModels\Solution\CreateEditSolution;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SolutionManager {
    protected SolutionRepository $solutionRepository;
    protected ProblemRepository $problemRepository;
    protected SolutionTranslationManager $solutionTranslationManager;
    protected SolutionStatusManager $solutionStatusManager;
    protected LanguageRepository $languageRepository;

    public function __construct(
        SolutionRepository $solutionRepository,
        ProblemRepository $problemRepository,
        SolutionTranslationManager $solutionTranslationManager,
        SolutionStatusManager $solutionStatusManager,
        LanguageRepository $languageRepository
    ) {
        $this->solutionRepository = $solutionRepository;
        $this->problemRepository = $problemRepository;
        $this->solutionTranslationManager = $solutionTranslationManager;
        $this->solutionStatusManager = $solutionStatusManager;
        $this->languageRepository = $languageRepository;
    }

    /**
     * In create mode $problem_id is passed to fn & $solution_id is null
     * In edit   mode $problem_id is null         & $solution_id is passed to fn
     */
    public function getCreateEditSolutionViewModel(?int $problem_id, ?int $solution_id = null): CreateEditSolution {
        if ($problem_id) {
            $problem = $this->problemRepository->find($problem_id);
        }

        if ($solution_id) {
            $solution = $this->solutionRepository->find($solution_id);
            $problem = $solution->problem;
        } else {
            $solution = new Solution;
            $solution->setRelation('defaultTranslation', new SolutionTranslation);
        }

        $translations = $this->solutionTranslationManager->getTranslationsForSolution($solution);

        $statusesLkp = $this->solutionStatusManager->getAllSolutionStatusesLkp();

        $languagesLkp = $this->languageRepository->all();

        return new CreateEditSolution(
            $solution,
            $translations,
            $statusesLkp,
            $languagesLkp,
            $problem
        );
    }

    public function storeSolution(array $attributes): int {
        if (isset($attributes['solution-image']) && $attributes['solution-image']->isValid()) {
            $imgPath = FileHandler::uploadAndGetPath($attributes['solution-image'], 'solution_img');
        }

        $solution_owner_problem_id = $attributes['solution-owner-problem'];

        $default_language_id = $this->problemRepository->find($solution_owner_problem_id)->default_language_id;

        try {
            DB::beginTransaction();
            $solution = Solution::create([
                'problem_id' => $solution_owner_problem_id,
                'user_creator_id' => Auth::id(),
                'slug' => Str::random(16), // temporary - will be changed after record creation
                'status_id' => $attributes['solution-status'],
                'img_url' => $imgPath,
            ]);

            $solution->slug = Str::slug($attributes['solution-title'] . '-' . $solution->id);
            $solution->save();

            $solution->defaultTranslation()->create([
                'title' => $attributes['solution-title'],
                'description' => $attributes['solution-description'],
                'language_id' => $default_language_id,
            ]);
            DB::commit();

            return $solution->id;
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getCode() . '  ' . $e->getMessage());
            DB::rollBack();
        }
    }

    /**
     * @throws RepositoryException
     */
    public function updateSolution(int $id, array $attributes) {
        if (isset($attributes['solution-image']) && $attributes['solution-image']->isValid()) {
            $imgPath = FileHandler::uploadAndGetPath($attributes['solution-image'], 'solution_img');
        }

        $modelAttributes['problem_id'] = $attributes['solution-owner-problem'];
        $modelAttributes['slug'] = $attributes['solution-slug'];
        $modelAttributes['status_id'] = $attributes['solution-status'];
        $modelAttributes['img_url'] = $imgPath;
        $this->solutionRepository->update($modelAttributes, $id);

        $default_language_id = $this->problemRepository->find($modelAttributes['problem_id'])->default_language_id;

        $defaultTranslation = [
            'language_id' => $default_language_id,
            'title' => $attributes['solution-title'],
            'description' => $attributes['solution-description'],
        ];
        $extraTranslations = isset($attributes['extra_translations']) ? json_decode($attributes['extra_translations']) : [];
        $this->solutionTranslationManager
            ->updateSolutionTranslations($id, $defaultTranslation, $extraTranslations);
    }

    public function getSolutionStatusesForManagementPage(): Collection {
        $solutionStatuses = $this->solutionStatusManager->getAllSolutionStatusesLkp();
        foreach ($solutionStatuses as $solutionStatus) {
            switch ($solutionStatus->id) {
                case SolutionStatusLkp::PUBLISHED:
                    $solutionStatus->badgeCSSClass = 'badge-success';
                    break;
                case SolutionStatusLkp::UNPUBLISHED:
                    $solutionStatus->badgeCSSClass = 'badge-danger';
                    break;
                default:
                    $solutionStatus->badgeCSSClass = 'badge-dark';
                    $solutionStatus->description = 'The problem is in an unknown status';
            }
        }

        return $solutionStatuses;
    }

    public function getFilteredSolutionsForManagement($filters): Collection {
        if (count($filters['problemFilters'])) {
            return $this->solutionRepository->getSolutionsForManagementFilteredByProblemIds($filters['problemFilters']);
        }
        $problem_ids = [];
        foreach ($filters['projectFilters'] as $project_id) {
            $problem_ids = array_merge($problem_ids, $this->problemRepository->getProblemsForCrowdSourcingProjectForManagement($project_id)->pluck('id')->toArray());
        }

        return $this->solutionRepository->getSolutionsForManagementFilteredByProjectIds($problem_ids);
    }

    public function getSolutions(mixed $problem_id): Collection {
        $current_language_code = app()->getLocale();
        $current_language = $this->languageRepository->getLanguageByCode($current_language_code);
        $current_language_id = $current_language ? $current_language->id : $this->languageRepository->getDefaultLanguage()->id;

        return $this->solutionRepository->getSolutions($problem_id, $current_language_id, Auth::id());
    }

    public function updateSolutionStatus(int $id, int $status_id) {
        return $this->solutionRepository->update(['status_id' => $status_id], $id);
    }

    public function deleteSolution(int $id): bool {
        $solution = $this->solutionRepository->find($id);
        // if the image is not the default one
        // and if it does not start with "/images" (meaning it is a default public image)
        // and if it does not start with "http" (meaning it is an external image)
        if ($solution->img_url &&
            !str_starts_with($solution->img_url, '/images') &&
            !str_starts_with($solution->img_url, 'http')) {
            FileHandler::deleteUploadedFile($solution->img_url, 'solution_img');
        }

        return $this->solutionRepository->delete($id);
    }
}
