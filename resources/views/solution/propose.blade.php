@extends('crowdsourcing-project.layout')
@push('css')
    @vite('resources/assets/sass/solution/propose-page.scss')
    <style>
        :root {
            --project-primary-color: {{ $viewModel->project->lp_primary_color}};
            --btn-text-color: {{ $viewModel->project->lp_btn_text_color_theme == "light" ? "#ffffff" : "#212529"}};
        }
    </style>
@endpush

@section('content')

    <div id="propose-solution-page" class="pb-5">

        @include('partials.flash-messages-and-errors')
        
        <section id="propose-solution-overview" class="bg-clr-primary-white">
            @include('solution.partials.propose-solution-overview')
        </section>

        <section id="propose-solution-form" class="bg-clr-primary-white bg-image-noise">
            @include('solution.partials.new-solution-form')
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
