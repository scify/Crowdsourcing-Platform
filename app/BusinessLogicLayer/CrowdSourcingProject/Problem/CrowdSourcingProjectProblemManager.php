<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject\Problem;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectTranslationManager;
use App\Repository\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemRepository;
use App\ViewModels\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemsLandingPage;

class CrowdSourcingProjectProblemManager {
    protected CrowdSourcingProjectProblemRepository $crowdSourcingProjectProblemRepository;
    protected CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager;
    protected CrowdSourcingProjectProblemTranslationManager $crowdSourcingProjectProblemTranslationManager;

    public function __construct(
        CrowdSourcingProjectProblemRepository $crowdSourcingProjectProblemRepository,
        CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager,
        CrowdSourcingProjectProblemTranslationManager $crowdSourcingProjectProblemTranslationManager
    ) {
        $this->crowdSourcingProjectProblemRepository = $crowdSourcingProjectProblemRepository;
        $this->crowdSourcingProjectTranslationManager = $crowdSourcingProjectTranslationManager;
        $this->crowdSourcingProjectProblemTranslationManager = $crowdSourcingProjectProblemTranslationManager;
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
}
