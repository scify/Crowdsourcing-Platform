<div class="container px-sm-0">

    <div class="row">
        <div class="col-12">
            <h2>{{ __("project-problems.list_of_problems") }}</h2>
            <p style="font-size: 1.429rem; line-height: 1.949rem; text-align: center; margin-bottom: 0;">
                @if (count($viewModel->project->problems) === 0)
                    {{ __("project-problems.no_problems_currently_published") }}
                @else
                    {{ __("project-problems.select-a-problem-to-begin") }}
                @endif
            </p>
        </div>
    </div>
    <problems
            :project-id='{{ $viewModel->project->id }}'
            :project-slug='@json($viewModel->project->slug)'
            :button-text-color-theme='@json($viewModel->project->lp_btn_text_color_theme)'
            :locale="'{{app()->getLocale()}}'">
    </problems>

</div>
@push('scripts')
    @vite('resources/assets/js/problem/landing-page.js')
@endpush