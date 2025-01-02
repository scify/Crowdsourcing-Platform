@extends('crowdsourcing-project.layout')
@push('css')
    <style>
        :root {
            --project-primary-color: {{ $viewModel->project->lp_primary_color}};
            --btn-text-color: {{ $viewModel->project->lp_btn_text_color_theme == "light" ? "#ffffff" : "#212529"}};
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid h-100 w-100 px-0">
        @include('partials.flash-messages-and-errors')
        <section id="motto" style="height: 750px;">
            @include('crowdsourcing-project.partials.motto')
        </section>
        <section>
            @include('crowdsourcing-project.partials.about')
        </section>
        @if($viewModel->questionnaire)
            <section id="collective-goal" class="pt-5">
                @include('crowdsourcing-project.partials.goal-and-activity')
            </section>
        @endif
        <section>
            @include('crowdsourcing-project.partials.next-actions')
        </section>
        
        <section>
            @include('partials.signup_to_newsletter')
        </section>
    </div>
@endsection
@push('scripts')
    <script defer type="text/javascript">
		const viewModel = @json($viewModel);
    </script>
    @vite('resources/assets/js/project/landing-page.js')
@endpush
