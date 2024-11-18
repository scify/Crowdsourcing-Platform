<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject\Problem;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectTranslationManager;
use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslation;
use App\Repository\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemRepository;
use App\Repository\LanguageRepository;
use App\Repository\RepositoryException;
use App\Utils\FileHandler;
use App\ViewModels\CrowdSourcingProject\Problem\CreateEditProblem;
use App\ViewModels\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemsLandingPage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CrowdSourcingProjectProblemManager {
    protected CrowdSourcingProjectProblemRepository $crowdSourcingProjectProblemRepository;
    protected CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager;
    protected CrowdSourcingProjectProblemTranslationManager $crowdSourcingProjectProblemTranslationManager;
    protected CrowdSourcingProjectProblemStatusManager $crowdSourcingProjectProblemStatusManager;
    protected LanguageRepository $languageRepository;
    protected CrowdSourcingProjectManager $crowdSourcingProjectManager;

    const DEFAULT_IMAGE_PATH = '/images/problem_default_image.png';

    public function __construct(
        CrowdSourcingProjectProblemRepository $crowdSourcingProjectProblemRepository,
        CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager,
        CrowdSourcingProjectProblemTranslationManager $crowdSourcingProjectProblemTranslationManager,
        CrowdSourcingProjectProblemStatusManager $crowdSourcingProjectProblemStatusManager,
        LanguageRepository $languageRepository,
        CrowdSourcingProjectManager $crowdSourcingProjectManager
    ) {
        $this->crowdSourcingProjectProblemRepository = $crowdSourcingProjectProblemRepository;
        $this->crowdSourcingProjectTranslationManager = $crowdSourcingProjectTranslationManager;
        $this->crowdSourcingProjectProblemTranslationManager = $crowdSourcingProjectProblemTranslationManager;
        $this->crowdSourcingProjectProblemStatusManager = $crowdSourcingProjectProblemStatusManager;
        $this->languageRepository = $languageRepository;
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
    }

    public function getCrowdSourcingProjectProblemsLandingPageViewModel(string $crowdSouringProjectSlug): CrowdSourcingProjectProblemsLandingPage {
        $crowdSourcingProject = $this->crowdSourcingProjectProblemRepository->getProjectWithProblemsByProjectSlug($crowdSouringProjectSlug);
        $crowdSourcingProject->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($crowdSourcingProject);

        return new CrowdSourcingProjectProblemsLandingPage($crowdSourcingProject);
    }

    public function getCreateEditProblemViewModel(?int $id = null): CreateEditProblem {
        if ($id) {
            $problem = $this->crowdSourcingProjectProblemRepository->find($id);
        } else {
            $problem = new CrowdSourcingProjectProblem;
            $problem->default_language_id = 6; // @todo change with lookuptable value - bookmark2
            $problem->setRelation('defaultTranslation', new CrowdSourcingProjectProblemTranslation); // bookmark2 - is this an "empty" relationship?
        }

        $translations = $this->crowdSourcingProjectProblemTranslationManager->getTranslationsForProblem($problem);

        $statusesLkp = $this->crowdSourcingProjectProblemStatusManager->getAllCrowdSourcingProjectProblemStatusesLkp();

        $languagesLkp = $this->languageRepository->all();

        $projects = $this->crowdSourcingProjectManager->getAllCrowdSourcingProjectsWithDefaultTranslation();

        return new CreateEditProblem(
            $problem,
            $translations,
            $statusesLkp,
            $languagesLkp,
            $projects
        );
    }

    public function storeProblem(array $attributes): int {
        if (isset($attributes['problem-image']) && $attributes['problem-image']->isValid()) {
            $imgPath = FileHandler::uploadAndGetPath($attributes['problem-image'], 'problem_img');
        } else {
            $imgPath = self::DEFAULT_IMAGE_PATH;
        }

        $crowdSourcingProjectProblem = CrowdSourcingProjectProblem::create([
            'project_id' => $attributes['problem-owner-project'],
            'user_creator_id' => Auth::id(),
            'slug' => Str::random(16), // temporary - will be changed after record creation
            'status_id' => $attributes['problem-status'],
            'img_url' => $imgPath,
            'default_language_id' => $attributes['problem-default-language'],
        ]);

        $crowdSourcingProjectProblem->slug = Str::slug($attributes['problem-title'] . '-' . $crowdSourcingProjectProblem->id);
        $crowdSourcingProjectProblem->save();

        $crowdSourcingProjectProblem->defaultTranslation()->create([
            'title' => $attributes['problem-title'],
            'description' => $attributes['problem-description'],
        ]);

        return $crowdSourcingProjectProblem->id;
    }

    /**
     * @throws RepositoryException
     */
    public function updateProblem(int $id, array $attributes) {
        if (isset($attributes['problem-image']) && $attributes['problem-image']->isValid()) {
            $imgPath = FileHandler::uploadAndGetPath($attributes['problem-image'], 'problem_img');
        } else {
            $imgPath = self::DEFAULT_IMAGE_PATH;
        }

        $modelAttributes['project_id'] = $attributes['problem-owner-project'];
        $modelAttributes['slug'] = $attributes['problem-slug'];
        $modelAttributes['status_id'] = $attributes['problem-status'];
        $modelAttributes['img_url'] = $imgPath;
        $modelAttributes['default_language_id'] = $attributes['problem-default-language'];
        $this->crowdSourcingProjectProblemRepository->update($modelAttributes, $id);

        $defaultTranslation = [
            'language_id' => $attributes['problem-default-language'],
            'title' => $attributes['problem-title'],
            'description' => $attributes['problem-description'],
        ];
        $extraTranslations = isset($attributes['extra_translations']) ? json_decode($attributes['extra_translations']) : [];
        $this->crowdSourcingProjectProblemTranslationManager
            ->updateProblemTranslations($id, $defaultTranslation, $extraTranslations);
    }

    public function deleteProblem(int $id): bool {
        $problem = $this->crowdSourcingProjectProblemRepository->find($id);
        // if the image is not the default one
        // and if it does not start with "/images" (meaning it is a default public image)
        // and if it does not start with "http" (meaning it is an external image)
        if ($problem->img_url !== self::DEFAULT_IMAGE_PATH &&
            !str_starts_with($problem->img_url, '/images') &&
            !str_starts_with($problem->img_url, 'http')) {
            FileHandler::deleteUploadedFile($problem->img_url, 'problem_img');
        }

        return $this->crowdSourcingProjectProblemRepository->delete($id);
    }

    public function getProblemStatusesForManagementPage(): Collection {
        $problemStatuses = $this->crowdSourcingProjectProblemStatusManager->getAllCrowdSourcingProjectProblemStatusesLkp();
        foreach ($problemStatuses as $problemStatus) {
            switch ($problemStatus->id) {
                case CrowdSourcingProjectStatusLkp::DRAFT:
                    $problemStatus->badgeCSSClass = 'badge-secondary';
                    break;
                case CrowdSourcingProjectStatusLkp::PUBLISHED:
                    $problemStatus->badgeCSSClass = 'badge-success';
                    break;
                case CrowdSourcingProjectStatusLkp::FINALIZED:
                    $problemStatus->badgeCSSClass = 'badge-info';
                    break;
                case CrowdSourcingProjectStatusLkp::UNPUBLISHED:
                    $problemStatus->badgeCSSClass = 'badge-danger';
                    break;
                default:
                    $problemStatus->badgeCSSClass = 'badge-dark';
                    $problemStatus->description = 'The problem is in an unknown status';
            }
        }

        return $problemStatuses;
    }

    public function updateProblemStatus(int $id, int $status_id) {
        return $this->crowdSourcingProjectProblemRepository->update(['status_id' => $status_id], $id);
    }

    public function getProblemsForCrowdSourcingProjectForManagement(int $projectId): Collection {
        return $this->crowdSourcingProjectProblemRepository->getProblemsForCrowdSourcingProjectForManagement($projectId);
    }

    public function getProblemsForCrowdSourcingProjectForLandingPage(int $projectId, string $getLocale): Collection {
        $langId = $this->languageRepository->getLanguageByCode($getLocale)->id;

        return $this->crowdSourcingProjectProblemRepository->getProblemsForCrowdSourcingProjectForLandingPage($projectId, $langId);
    }
}
