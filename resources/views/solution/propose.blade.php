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

    <h2>propose-solution-works!</h2>

    <section id="propose-solution-overview" class="bg-clr-primary-white">
        @include('solution.partials.new-solution-form')
    </section>

@endsection
