<div class="text-center content-container">
    {{-- Show Questionnaire Button if available and user has not answered --}}
    @if ($viewModel->questionnaire && !$viewModel->userResponse)
        {{-- If the questionnaire title is different from the project name --}}
        @if ($viewModel->project && ($viewModel->questionnaire->fieldsTranslation->title != $viewModel->project->currentTranslation->name))
            <h3 class="project-section-title text-center mb-5">
                {{ __("questionnaire.questionnaire_for") }} {{ $viewModel->project->currentTranslation->name }}
            </h3>
        @endif
        <h3 class="project-section-title text-center mb-5">
            {!! $viewModel->questionnaire->fieldsTranslation->title !!}
        </h3>
        <a href="{{ route('show-questionnaire-page', ['locale' => app()->getLocale(), 'project' => $viewModel->project->slug, 'questionnaire' => $viewModel->questionnaire->id]) }}"
           class="btn btn-primary w-100 respond-questionnaire call-to-action">
            {{ __("questionnaire.start_answering") }}
        </a>

        {{-- Show Problems Button if user has answered questionnaire or no questionnaire exists --}}
    @elseif (($viewModel->questionnaire && $viewModel->userResponse && $viewModel->projectHasPublishedProblems) ||
            (!$viewModel->questionnaire && $viewModel->projectHasPublishedProblems))
        <h3 class="project-section-title text-center mb-5">
            @if ($viewModel->questionnaire)
                {{ __("my-dashboard.see_the_problems_cta") }}
            @endif
        </h3>
        <a href="{{ route('project.problems-page', ['project_slug' => $viewModel->project->slug]) }}"
           class="btn btn-primary w-100 call-to-action">
            {{ __("project-problems.project_landing_page_problems_action_button") }}
            <i class="fas fa-arrow-right"></i>
        </a>
    @else
        <div>
            @if ($viewModel->project->status_id == App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp::FINALIZED)
                <h3 class="project-section-title">{{ __("questionnaire.project_finalized") }}</h3>
            @else
                <h3 class="project-section-title">{{ __("questionnaire.no_active_questionnaires") }}</h3>
                <h3 class="project-section-title">{{ __("questionnaire.next_questionnaire") }}</h3>
            @endif
        </div>
    @endif
</div>
