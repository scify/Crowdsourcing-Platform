<?php

namespace App\BusinessLogicLayer\Problem;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectTranslationManager;
use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\Models\Problem\Problem;
use App\Models\Problem\ProblemTranslation;
use App\Repository\LanguageRepository;
use App\Repository\Problem\ProblemRepository;
use App\Repository\RepositoryException;
use App\Utils\FileHandler;
use App\ViewModels\Problem\CreateEditProblem;
use App\ViewModels\Problem\ProblemsLandingPage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProblemManager {
    protected ProblemRepository $problemRepository;
    protected CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager;
    protected ProblemTranslationManager $problemTranslationManager;
    protected ProblemStatusManager $problemStatusManager;
    protected LanguageRepository $languageRepository;
    protected CrowdSourcingProjectManager $crowdSourcingProjectManager;

    const DEFAULT_IMAGE_PATH = '/images/problem_default_image.png';

    public function __construct(
        ProblemRepository $problemRepository,
        CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager,
        ProblemTranslationManager $problemTranslationManager,
        ProblemStatusManager $problemStatusManager,
        LanguageRepository $languageRepository,
        CrowdSourcingProjectManager $crowdSourcingProjectManager
    ) {
        $this->problemRepository = $problemRepository;
        $this->crowdSourcingProjectTranslationManager = $crowdSourcingProjectTranslationManager;
        $this->problemTranslationManager = $problemTranslationManager;
        $this->problemStatusManager = $problemStatusManager;
        $this->languageRepository = $languageRepository;
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
    }

    public function getProblemsLandingPageViewModel(string $crowdSouringProjectSlug): ProblemsLandingPage {
        $crowdSourcingProject = $this->problemRepository->getProjectWithProblemsByProjectSlug($crowdSouringProjectSlug);
        $crowdSourcingProject->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($crowdSourcingProject);

        return new ProblemsLandingPage($crowdSourcingProject);
    }

    public function getCreateEditProblemViewModel(?int $id = null): CreateEditProblem {
        if ($id) {
            $problem = $this->problemRepository->find($id);
        } else {
            $problem = new Problem;
            $problem->default_language_id = 6; // @todo change with lookuptable value - bookmark2
            $problem->setRelation('defaultTranslation', new ProblemTranslation);
        }

        $translations = $this->problemTranslationManager->getTranslationsForProblem($problem);

        $statusesLkp = $this->problemStatusManager->getAllProblemStatusesLkp();

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

        $crowdSourcingProjectProblem = Problem::create([
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
        $this->problemRepository->update($modelAttributes, $id);

        $defaultTranslation = [
            'language_id' => $attributes['problem-default-language'],
            'title' => $attributes['problem-title'],
            'description' => $attributes['problem-description'],
        ];
        $extraTranslations = isset($attributes['extra_translations']) ? json_decode($attributes['extra_translations']) : [];
        $this->problemTranslationManager
            ->updateProblemTranslations($id, $defaultTranslation, $extraTranslations);
    }

    public function deleteProblem(int $id): bool {
        $problem = $this->problemRepository->find($id);
        // if the image is not the default one
        // and if it does not start with "/images" (meaning it is a default public image)
        // and if it does not start with "http" (meaning it is an external image)
        if ($problem->img_url !== self::DEFAULT_IMAGE_PATH &&
            !str_starts_with($problem->img_url, '/images') &&
            !str_starts_with($problem->img_url, 'http')) {
            FileHandler::deleteUploadedFile($problem->img_url, 'problem_img');
        }

        return $this->problemRepository->delete($id);
    }

    public function getProblemStatusesForManagementPage(): Collection {
        $problemStatuses = $this->problemStatusManager->getAllProblemStatusesLkp();
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
        return $this->problemRepository->update(['status_id' => $status_id], $id);
    }

    public function getProblemsForCrowdSourcingProjectForManagement(int $projectId): Collection {
        return $this->problemRepository->getProblemsForCrowdSourcingProjectForManagement($projectId);
    }

    public function getProblemsForCrowdSourcingProjectForLandingPage(int $projectId, string $getLocale): Collection {
        $langId = $this->languageRepository->getLanguageByCode($getLocale)->id;

        return $this->problemRepository->getProblemsForCrowdSourcingProjectForLandingPage($projectId, $langId);
    }
}