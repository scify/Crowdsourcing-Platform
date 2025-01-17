<div class="container px-sm-0">

    <solutions
            :user-logged-in='@json(Auth::check())'
            :problem-id='{{ $viewModel->problem->id }}'
            :problem-slug='@json($viewModel->problem->slug)'
            :project-slug='@json($viewModel->project->slug)'
            :max-votes-per-user-for-solutions='@json($viewModel->project->max_votes_per_user_for_solutions)'
            :button-text-color-theme='@json($viewModel->project->lp_btn_text_color_theme)'
            :project-primary-color='@json($viewModel->project->lp_primary_color)'
            :locale="'{{app()->getLocale()}}'">
    </solutions>

</div>
@push('scripts')
    @vite('resources/assets/js/problem/problem-page.js')
@endpush