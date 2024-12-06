@extends('crowdsourcing-project.layout')
@push('css')
    @vite('resources/assets/sass/problem/landing-page.scss')
    <style>
        :root {
            --project-primary-color: {{ $viewModel->project->lp_primary_color}};
            --btn-text-color: {{ $viewModel->project->lp_btn_text_color_theme == "light" ? "#ffffff" : "#212529"}};
        }
    </style>
@endpush

@section('content')

    <div id="problem-page" class="pb-5">

        @include('partials.flash-messages-and-errors')

        @include('problem.partials.problem-overview')

        <section id="solutions-list" class="bg-clr-primary-white bg-image-noise">
            @include('problem.partials.solutions-list')
        </section>

    </div>

    @if (App::environment('local'))
        <div class="fixed-bottom"> <!-- bookmark1 - for use only during development -->
            <div class="alert alert-danger text-center font-weight-bold"
                 style="top: -40px; width: 160px; margin: 0 auto; opacity: 0.25">
                <div class="d-block d-sm-none">xs (default)</div>
                <div class="d-none d-sm-block d-md-none">sm</div>
                <div class="d-none d-md-block d-lg-none">md</div>
                <div class="d-none d-lg-block d-xl-none">lg</div>
                <div class="d-none d-xl-block d-custom_xxl-none">xl</div>
                <div class="d-none d-custom_xxl-block">custom_xxl</div>
            </div>
        </div>
    @endif

@endsection