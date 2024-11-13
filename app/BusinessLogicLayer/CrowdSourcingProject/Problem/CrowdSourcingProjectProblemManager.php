<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject\Problem;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectTranslationManager;
use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslation;
use App\Repository\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemRepository;
use App\Repository\LanguageRepository;
use App\Utils\FileUploader;
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
        $crowdSourcingProjectProblems = $crowdSourcingProject->problems ?? collect();
        foreach ($crowdSourcingProjectProblems as $crowdSourcingProjectProblem) {
            $crowdSourcingProjectProblem->currentTranslation = $this->crowdSourcingProjectProblemTranslationManager->getFieldsTranslationForProjectProblem($crowdSourcingProjectProblem);
        }

        return new CrowdSourcingProjectProblemsLandingPage($crowdSourcingProject, $crowdSourcingProjectProblems);
    }

    public function getCrowdSourcingProjectProblem(int $id): CrowdSourcingProjectProblem {
        $problem = $this->crowdSourcingProjectProblemRepository->find($id);

        return $problem;
    }

    public function getCreateEditProblemViewModel(?int $id = null): CreateEditProblem {
        if ($id) {
            $problem = $this->getCrowdSourcingProjectProblem($id);
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
            $imgPath = FileUploader::uploadAndGetPath($attributes['problem-image'], 'problem_image');
        } else {
            $imgPath = self::DEFAULT_IMAGE_PATH;
        }

        $crowdSourcingProjectProblem = CrowdSourcingProjectProblem::create([
            'project_id' => $attributes['problem-owner-project'],
            'user_creator_id' => Auth::id(),
            'slug' => Str::random(16), // temporary - will be changed after record creation
            'status_id' => $attributes['problem-status'],
            'img_url' => $imgPath ?? null,
            'default_language_id' => $attributes['problem-default-language'], // bookmark2 - default or generally another translation language?
        ]);

        $crowdSourcingProjectProblem->slug = Str::slug($attributes['problem-title'] . '-' . $crowdSourcingProjectProblem->id);
        $crowdSourcingProjectProblem->save();

        $crowdSourcingProjectProblemTranslation = $crowdSourcingProjectProblem->defaultTranslation()->create([ // bookmark2 - default or regular translation?
            'title' => $attributes['problem-title'],
            'description' => $attributes['problem-description'],
        ]);

        return $crowdSourcingProjectProblem->id;
    }

    public function deleteProblem(int $id): bool {
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
}
