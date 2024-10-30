<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject\Problem;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectTranslationManager;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblem;
use App\Models\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemTranslation;
use App\Repository\CrowdSourcingProject\Problem\CrowdSourcingProjectProblemRepository;
use App\ViewModels\CrowdSourcingProject\Problem\CreateEditProblem;
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

    public function getCreateEditProblemViewModel(?int $id = null): CreateEditProblem {
        // if ($id) {
        //     $project = $this->getCrowdSourcingProject($id);
        // } else {
        //     $project = $this->crowdSourcingProjectRepository->getModelInstance();
        // }

        // $project = $this->populateInitialValuesForProjectIfNotSet($project);
        // $project->colors = $this->crowdSourcingProjectColorsManager->getColorsForCrowdSourcingProjectOrDefault($project->id);
        // $statusesLkp = $this->crowdSourcingProjectStatusManager->getAllCrowdSourcingProjectStatusesLkp();

        // $contributorBadge = new ContributorBadge(1, true);
        // $contributorBadgeVM = new GamificationBadgeVM($contributorBadge);
        // $questionnaire = $this->questionnaireRepository->getModelInstance();


        // $templateForNotification = (new QuestionnaireResponded(
        //     $questionnaire->defaultFieldsTranslation,
        //     $contributorBadge,
        //     $contributorBadgeVM,
        //     $project->defaultTranslation,
        //     app()->getLocale()
        // ))->toMail(null)->render();
        // $translations = $this->crowdSourcingProjectTranslationManager->getTranslationsForProject($project);

        // return new CreateEditCrowdSourcingProject(
        //     $project,
        //     $translations,
        //     $statusesLkp,
        //     $this->languageRepository->all(),
        //     $templateForNotification
        // );

        $problem = new CrowdSourcingProjectProblem;
        $problem->default_language_id = 6; // @todo change with lookuptable value - bookmark2
        $problem->setRelation('defaultTranslation', new CrowdSourcingProjectProblemTranslation); // bookmark2 - is this an "empty" relationship?

        return new CreateEditProblem(
            $problem
        );
    }
}
