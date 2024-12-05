<div class="container px-sm-0">

    <div class="row">
        <div class="col-12">
            <h2>{{ __("project-problems.list_of_solution") }}</h2>
        </div>
    </div>

    <solutions
            :problem-id='{{ $viewModel->problem->id }}'
            :problem-slug='@json($viewModel->problem->slug)'
            :project-slug='@json($viewModel->project->slug)'
            :button-text-color-theme="{{ $viewModel->project->lp_btn_text_color_theme }}">
    </solutions>

</div>
@push('scripts')
    @vite('resources/assets/js/problem/problem-page.js')
@endpush