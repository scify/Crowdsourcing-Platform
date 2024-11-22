<?php

namespace App\BusinessLogicLayer\Solution;

use App\Models\Solution\Solution;
use App\Models\Solution\SolutionTranslation;
use App\Repository\LanguageRepository;
use App\Repository\Problem\ProblemRepository;
use App\Repository\Solution\SolutionRepository;
use App\Utils\FileHandler;
use App\ViewModels\Solution\CreateEditSolution;
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

    const DEFAULT_IMAGE_PATH = '/images/problem_default_image.png'; // bookmark3 - change this to the correct path

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

    public function getCreateEditSolutionViewModel(int $problem_id, ?int $id = null): CreateEditSolution {
        $problem = $this->problemRepository->find($problem_id);

        if ($id) {
            $solution = $this->solutionRepository->find($id);
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
        } else {
            $imgPath = self::DEFAULT_IMAGE_PATH;
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
}
