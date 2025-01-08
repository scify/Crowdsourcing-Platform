<?php

namespace App\BusinessLogicLayer\Solution;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectTranslationManager;
use App\BusinessLogicLayer\lkp\SolutionStatusLkp;
use App\BusinessLogicLayer\Problem\ProblemTranslationManager;
use App\Models\Solution\Solution;
use App\Models\Solution\SolutionShare;
use App\Models\Solution\SolutionTranslation;
use App\Models\User\User;
use App\Notifications\SolutionPublished;
use App\Notifications\SolutionSubmittedForReview;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectRepository;
use App\Repository\LanguageRepository;
use App\Repository\Problem\ProblemRepository;
use App\Repository\RepositoryException;
use App\Repository\Solution\SolutionRepository;
use App\Repository\Solution\SolutionShareRepository;
use App\Repository\Solution\SolutionUpvoteRepository;
use App\Utils\FileHandler;
use App\ViewModels\Solution\CreateEditSolution;
use App\ViewModels\Solution\ProposeSolutionPage;
use App\ViewModels\Solution\SolutionSubmitted;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SolutionManager {
    protected SolutionRepository $solutionRepository;
    protected SolutionUpvoteRepository $solutionUpvoteRepository;
    protected ProblemRepository $problemRepository;
    protected CrowdSourcingProjectRepository $crowdSourcingProjectRepository;
    protected SolutionTranslationManager $solutionTranslationManager;
    protected SolutionStatusManager $solutionStatusManager;
    protected LanguageRepository $languageRepository;
    protected CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager;
    protected ProblemTranslationManager $problemTranslationManager;
    protected SolutionShareRepository $solutionShareRepository;

    public function __construct(
        SolutionRepository $solutionRepository,
        SolutionUpvoteRepository $solutionUpvoteRepository,
        ProblemRepository $problemRepository,
        CrowdSourcingProjectRepository $crowdSourcingProjectRepository,
        SolutionTranslationManager $solutionTranslationManager,
        SolutionStatusManager $solutionStatusManager,
        LanguageRepository $languageRepository,
        CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager,
        ProblemTranslationManager $problemTranslationManager,
        SolutionShareRepository $solutionShareRepository
    ) {
        $this->solutionRepository = $solutionRepository;
        $this->solutionUpvoteRepository = $solutionUpvoteRepository;
        $this->problemRepository = $problemRepository;
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
        $this->solutionTranslationManager = $solutionTranslationManager;
        $this->solutionStatusManager = $solutionStatusManager;
        $this->languageRepository = $languageRepository;
        $this->crowdSourcingProjectTranslationManager = $crowdSourcingProjectTranslationManager;
        $this->problemTranslationManager = $problemTranslationManager;
        $this->solutionShareRepository = $solutionShareRepository;
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

    /**
     * Store a solution
     * @param array $attributes the attributes of the solution
     * @throws Exception
     */
    public function storeSolution(array $attributes): Solution {
        return $this->storeSolutionWithStatus($attributes, $attributes['solution-status']);
    }

    /**
     * Store a solution from a public form
     * @param array $attributes the attributes of the solution
     * @throws Exception
     */
    public function storeSolutionFromPublicForm(array $attributes): Solution {
        $solution = $this->storeSolutionWithStatus($attributes, SolutionStatusLkp::UNPUBLISHED);
        $user = Auth::user();
        if ($user && $user->email) {
            // notify the user that their solution has been submitted
            $user->notify(new \App\Notifications\SolutionSubmitted($solution));
        }

        // get the creator of the solution problem
        $problem_creator = $solution->problem->creator;

        // notify the creator of the solution submission
        $problem_creator->notify(new SolutionSubmittedForReview($solution));

        return $solution;
    }

    /**
     * Store a solution with a specific status
     * @param array $attributes the attributes of the solution
     * @throws Exception
     */
    protected function storeSolutionWithStatus(array $attributes, int $status_id): Solution {
        if (isset($attributes['solution-image']) && $attributes['solution-image']->isValid()) {
            $imgPath = FileHandler::uploadAndGetPath($attributes['solution-image'], 'solution_img');
        } else {
            $imgPath = null;
        }
        $solution_owner_problem_id = $attributes['solution-owner-problem'];

        $default_language_id = $this->problemRepository->find($solution_owner_problem_id)->default_language_id;
        try {
            DB::beginTransaction();
            $solution = Solution::create([
                'problem_id' => $solution_owner_problem_id,
                'user_creator_id' => Auth::id(),
                'slug' => Str::random(16), // temporary - will be changed after record creation
                'status_id' => $status_id,
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

            return $solution;
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getCode() . '  ' . $e->getMessage());
            DB::rollBack();
            throw new \Exception('An error occurred while creating the solution');
        }
    }

    /**
     * @throws RepositoryException
     */
    public function updateSolution(int $id, array $attributes) {
        if (isset($attributes['solution-image']) && $attributes['solution-image']->isValid()) {
            $imgPath = FileHandler::uploadAndGetPath($attributes['solution-image'], 'solution_img');
        } else {
            $imgPath = null;
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
        $current_language_id = ($current_language && $current_language->id) ? $current_language->id : $this->languageRepository->getDefaultLanguage()->id;

        return $this->solutionRepository->getSolutions($problem_id, $current_language_id, Auth::id());
    }

    public function updateSolutionStatus(int $id, int $status_id) {
        $result = $this->solutionRepository->update(['status_id' => $status_id], $id);

        // if the status was changed to published
        // and if the current user is different from the creator of the solution
        // we need to notify the user who created the solution

        if ($status_id === SolutionStatusLkp::PUBLISHED) {
            $solution = $this->solutionRepository->find($id);
            $user = Auth::user();
            if ($solution->user_creator_id !== $user->id) {
                $user->notify(new SolutionPublished($solution));
            }
        }

        return $result;
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

    public function getProposeSolutionPageViewModel(string $locale, string $project_slug, string $problem_slug): ProposeSolutionPage {
        $project = $this->problemRepository->getProjectWithProblemsByProjectSlug($project_slug);
        $project->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($project);

        $problem = $this->problemRepository->findBy('slug', $problem_slug);
        $problem->currentTranslation = $this->problemTranslationManager->getProblemCurrentTranslation($problem->id, $locale);

        // we use the default language of the problem
        $localeLanguage = $problem->defaultTranslation->language;

        return new ProposeSolutionPage($project, $problem, $localeLanguage);
    }

    public function getSolutionSubmittedViewModel(string $project_slug, string $problem_slug, string $solution_slug): SolutionSubmitted {
        $project = $this->crowdSourcingProjectRepository->findBy('slug', $project_slug);
        $project->currentTranslation = $this->crowdSourcingProjectTranslationManager->getFieldsTranslationForProject($project);

        $problem = $this->problemRepository->findBy('slug', $problem_slug);
        $problem->currentTranslation = $this->problemTranslationManager->getProblemCurrentTranslation($problem->id, app()->getLocale());

        $solution = $this->solutionRepository->findBy('slug', $solution_slug);

        return new SolutionSubmitted($solution, $problem, $project);
    }

    /**
     * Vote or downvote a solution
     *
     * Checks if the current user has already voted for this solution.
     * if they have, we need to remove their vote
     * if they haven't, we need to add their vote
     * in the end, we return:
     * - the current number of votes for the solution
     * - the current user's vote status (voted or not)
     * - the current user's remaining votes for this problem
     *
     * @param int $solution_id the id of the solution
     * @return array described above
     */
    public function voteOrDownVoteSolution(int $solution_id): array {
        $upvote = false;
        $user_id = Auth::id();
        // also get how many votes the user has left for this problem
        $problem = $this->solutionRepository->find($solution_id)->problem;
        $project = $problem->project;

        $user_votes = $this->getUserVotesNum($problem->id);
        $votes_left = $project->max_votes_per_user_for_solutions - $user_votes;

        $solution_upvote = $this->solutionUpvoteRepository->where([
            'solution_id' => $solution_id,
            'user_voter_id' => $user_id,
        ]);


        if ($solution_upvote) {
            $solution_upvote->delete();
        } else {
            // if the user does not have any votes left, we return an error
            if ($votes_left <= 0) {
                return [
                    'error' => 'You have no votes left for this problem',
                ];
            }
            $this->solutionUpvoteRepository->create([
                'solution_id' => $solution_id,
                'user_voter_id' => $user_id,
            ]);
            $upvote = true;
        }

        $solution_votes = $this->solutionUpvoteRepository->allWhere(['solution_id' => $solution_id])->count();

        return [
            'solution_votes' => $solution_votes,
            'upvote' => $upvote,
            'user_votes_left' => $upvote ? $votes_left - 1 : $votes_left + 1,
        ];
    }

    /**
     * Gets the number of votes the current user has for this problem
     * @param int $problem_id the id of the problem
     * @return int the number of votes the current user has for this problem
     */
    public function getUserVotesNum(int $problem_id): int {
        $user_id = Auth::id();
        if (!$user_id) {
            return 0;
        }
        $project = $this->problemRepository->find($problem_id)->project;
        $problem_ids = $project->problems->pluck('id')->toArray();
        $solution_ids = $this->solutionRepository->getSolutionsForProblems($problem_ids)->pluck('id')->toArray();

        return $this->solutionUpvoteRepository->getNumberOfVotesForUser($user_id, $solution_ids);
    }

    public function handleShareSolution(mixed $solution_id): ?SolutionShare {
        $solution = $this->solutionRepository->find($solution_id);
        // if the user who created the solution is different from the current user
        // we need to add a new share
        $current_user_id = Auth::id();
        if ($solution->user_creator_id !== $current_user_id) {
            $data = [
                'solution_id' => $solution_id,
                'user_id' => $current_user_id,
            ];

            return $this->solutionShareRepository->updateOrCreate($data, $data);
        }

        return null;
    }

    public function getSolutionsProposedByUser(User $user) {
        return $this->solutionRepository->allWhere(['user_creator_id' => $user->id], ['*'], $orderColumn = null, $order = null, $withRelationships = [
            'problem', 'problem.defaultTranslation', 'upvotes', 'problem.project',
        ]);
    }
}
