<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject\Problem;

use App\Repository\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemRepository;
use App\ViewModels\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemsLandingPage;

class CrowdSourcingProjectProblemManager {
    protected CrowdSourcingProjectProblemRepository $crowdSourcingProjectProblemRepository;

    public function __construct(CrowdSourcingProjectProblemRepository $crowdSourcingProjectProblemRepository) {
        $this->crowdSourcingProjectProblemRepository = $crowdSourcingProjectProblemRepository;
    }

    public function getCrowdSourcingProjectProblemsLandingPageViewModel(string $crowdSouringProjectSlug): CrowdSourcingProjectProblemsLandingPage {
        $crowdSourcingProject = $this->crowdSourcingProjectProblemRepository->getProjectWithProblemsByProjectSlug($crowdSouringProjectSlug);
        $crowdSourcingProjectProblems = $crowdSourcingProject->problems ?? collect();
        // create the view model
        return new CrowdSourcingProjectProblemsLandingPage($crowdSourcingProject, $crowdSourcingProjectProblems);
    }
}
