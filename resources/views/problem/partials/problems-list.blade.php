<div class="container px-sm-0">

    <div class="row">
        <div class="col-12">
            <h2>{{ __("project-problems.list_of_problems") }}</h2>
        </div>
    </div>

    <crowd-sourcing-project-problems
            :project-id='{{ $viewModel->project->id }}'
            :button-text-color-theme="{{ $viewModel->project->lp_btn_text_color_theme }}">
    </crowd-sourcing-project-problems>

</div>
@push('scripts')
    @vite('resources/assets/js/problem/landing-page.js')
@endpush