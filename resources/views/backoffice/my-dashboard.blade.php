@extends('backoffice.layout')

@push('css')
    @vite('resources/assets/sass/pages/my-dashboard.scss')
@endpush

@section('content')
    <div class="row">
        <div class="col">
            <h1>{{ __("common.welcome") }}, {{ $viewModel->user->nickname }}</h1>
        </div>
    </div>
    <div class="row gamification-box">
        <div class="col-md-12 mt-4 mb-4" style="float: none !important;">
            <div id="awards">
                @include('gamification.user-badges', ['badgesVM' => $viewModel->platformWideGamificationBadgesVM])
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            @include('gamification.user-progress', ['badgesVM' => $viewModel->platformWideGamificationBadgesVM])
        </div>
    </div>

    <div id="dashboard-actions-sections">
        <div class="container-fluid px-0">
            <div class="row">
                <div class="col">
                    <div class="accordion" id="projects-with-next-actions">
                        <div class="card">
                            <div class="card-header" id="projects-with-questionnaires-header">
                                <a href="#" class="btn btn-header-link" data-toggle="collapse"
                                   data-target="#projects-with-questionnaires-content"
                                   aria-expanded="true"
                                   aria-controls="projects-with-questionnaires-content">{{ __('my-dashboard.projects_with_active_questionnaires') }}</a>
                            </div>

                            <div id="projects-with-questionnaires-content" class="collapse show"
                                 aria-labelledby="projects-with-questionnaires-header"
                                 data-parent="#projects-with-next-actions">
                                <div class="card-body px-2">
                                    @include('backoffice.projects-with-active-questionnaires', ['questionnaires' => $viewModel->questionnaires])
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="projects-with-problems-header">
                                <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse"
                                   data-target="#projects-with-problems-content"
                                   aria-expanded="true" aria-controls="projects-with-problems-content">
                                    {{ __('my-dashboard.projects_to_suggest_solutions') }}
                                </a>
                            </div>

                            <div id="projects-with-problems-content" class="collapse show"
                                 aria-labelledby="projects-with-problems-header"
                                 data-parent="#projects-with-next-actions">
                                <div class="card-body px-2">
                                    @include('backoffice.projects-with-active-problems', ['projects' => $viewModel->projectsWithActiveProblems])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


