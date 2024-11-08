<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject\Problem;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectTranslationManager;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslation;
use App\Repository\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemRepository;
use App\Repository\LanguageRepository;
use App\ViewModels\CrowdSourcingProject\Problem\CreateEditProblem;
use App\ViewModels\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemsLandingPage;

class CrowdSourcingProjectProblemManager {
    protected CrowdSourcingProjectProblemRepository $crowdSourcingProjectProblemRepository;
    protected CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager;
    protected CrowdSourcingProjectProblemTranslationManager $crowdSourcingProjectProblemTranslationManager;
    protected CrowdSourcingProjectProblemStatusManager $crowdSourcingProjectProblemStatusManager;
    protected LanguageRepository $languageRepository;
    protected CrowdSourcingProjectManager $crowdSourcingProjectManager;

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

    public function getCreateEditProblemViewModel(?int $id = null): CreateEditProblem {
        // if ($id) {
        //     $project = $this->getCrowdSourcingProject($id);
        // } else {
        //     $project = $this->crowdSourcingProjectRepository->getModelInstance();
        // }

        // $project = $this->populateInitialValuesForProjectIfNotSet($project);
        $problem = new CrowdSourcingProjectProblem;
        $problem->default_language_id = 6; // @todo change with lookuptable value - bookmark2
        $problem->setRelation('defaultTranslation', new CrowdSourcingProjectProblemTranslation); // bookmark2 - is this an "empty" relationship?

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
}
