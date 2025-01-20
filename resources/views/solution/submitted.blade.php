@extends('crowdsourcing-project.layout')
@push('css')
    @vite('resources/assets/sass/problem/show-page.scss')
    <style>
        :root {
            --project-primary-color: {{ $viewModel->project->lp_primary_color}};
            --btn-text-color: {{ $viewModel->project->lp_btn_text_color_theme == "light" ? "#ffffff" : "#212529"}};
        }
    </style>
@endpush

@section('content')

    <div id="single-problem-page" class="pb-5">

        <div class="container px-sm-0">

            <div class="row">
                <div class="col-12 mt-2 mb-4 pt-1">
                    <x-go-back-link href="/{{ app()->getLocale() .'/'. $viewModel->project->slug . '/problems/' . $viewModel->problem->slug }}"
                                    class="d-none d-lg-block">{{ __("project-problems.back-to-the-solutions") }}</x-go-back-link>
                </div>
            </div>

            <div class="row how-to-vote">

                <div class="col-12 col-lg-7">
                    <h2 class="section-title">{{ __("solution.thanks_for_proposal_title") }}</h2>
                    <div class="section-body pb-5 pb-lg-0">
                        <p>{!! __("solution.thanks_for_proposal_message") !!}</p>
                    </div>
                </div>

                <div class="col-12 col-lg-4 offset-lg-1 align-self-end text-center">
                    <img src="/images/problems/problem-page-intro-top-thinking@2x.png" alt="" width="384" height="344"
                         class="img-fluid">
                </div>

            </div>


            <div class="row">
                <div class="col-12 my-4 my-lg-3 pt-2">
                    <h3 class="section-title">{{ __("solution.solution_title") }}</h3>
                    <div class="section-body pb-5 pb-lg-0">
                        <p>{{ $viewModel->solution->defaultTranslation->title }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 pt-4">
                    <h3 class="section-title">{{ __("solution.solution_description") }}</h3>
                    <div class="section-body pb-5 pb-lg-0">
                        <p>{!! $viewModel->solution->defaultTranslation->description !!}</p>
                    </div>
                </div>
                <div class="col-12 py-4">
                    <h3>{{ __("solution.help_us_more_message") }}</h3>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-5 col-sm-11 mx-auto my-1 my-lg-1 py-3">
                    <a class="btn btn-primary btn-block"
                       href="{{ route('project.problems-page', [
                            'locale' => app()->getLocale(),
                            'project_slug' => $viewModel->project->slug
                       ]) }}">
                        {{ __("menu.see_all_problems") }} & {{ __('project-problems.suggest_solution') }}<i
                                class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

        </div>


    </div>

@endsection
