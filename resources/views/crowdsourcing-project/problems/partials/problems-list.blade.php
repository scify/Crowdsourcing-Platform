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

    {{--
        <div class="row pb-5">
            <div class="col-12 d-flex justify-content-center">
                <button class="cta-btn">{{ __("project-problems.list_of_problems") }}</button> <!-- bookmark1 - add click handler / or hide for now -->
            </div>
        </div>
    --}}

</div>
@push('scripts')
    @vite('resources/assets/js/project/problem/landing-page.js')
@endpush