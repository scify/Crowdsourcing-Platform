<div class="container px-sm-0">

    <div class="row">
        <div class="col-12">
            <h2>{{ __("project-problems.list_of_problems") }}</h2>
        </div>
    </div>

    <problems
            :project-id='{{ $viewModel->project->id }}'
            :project-slug='@json($viewModel->project->slug)'
            :button-text-color-theme="{{ $viewModel->project->lp_btn_text_color_theme }}">
    </problems>

</div>
@push('scripts')
    @vite('resources/assets/js/problem/landing-page.js')
@endpush