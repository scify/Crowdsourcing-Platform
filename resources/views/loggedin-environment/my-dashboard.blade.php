@extends('loggedin-environment.layout')

@section('content-header')
    <h1 class="m-0 text-dark">{{ __("menu.my_dashboard") }}</h1>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ mix('dist/css/my-dashboard.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ __("my-dashboard.contribution") }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="container-fluid table-responsive">
                                @if($viewModel->questionnaires->isEmpty())
                                    <div class="no-projects-found">{{ __("questionnaire.no_active_projects")}}
                                    </div>
                                @else
                                    <table id="available-projects"
                                           class="w-100 row table table-striped table-hover table-responsive-md">
                                        <tbody class="w-100">
                                        @foreach($viewModel->questionnaires as $questionnaire)
                                            <tr class="d-flex">
                                                <td class="h-75 col-md-4 col-sm-6 justify-content-center align-self-center border-top-0">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            @foreach($questionnaire->projects as $project)
                                                                <div class="col-md-6 col-sm-12 mx-auto">
                                                                    <a href="{{ route('project.landing-page', $project->slug) }}">
                                                                        <img loading="lazy" class="project-logo w-100"
                                                                             alt="Project logo for {{$project->defaultTranslation->name}}"
                                                                             src="{{asset($project->logo_path)}}">
                                                                        <br>
                                                                        <p class="project-title mt-2">{{ $project->defaultTranslation->name }}</p>
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                </td>
                                                <td class="h-75 col-md-4 col-sm-6 justify-content-center align-self-center border-top-0">
                                                    <div class="progress-container">
                                                        @include('landingpages.partials.project-goal',
                                                        ['questionnaireId' => $questionnaire->id, 'questionnaireViewModel' => $questionnaire->goalVM, 'project' => $questionnaire->projects->get(0)])
                                                        @if ($questionnaire->userHasAccessToViewStatisticsPage)
                                                            <div class="row">
                                                                <div class="col">
                                                                    <a class="btn btn-primary" target="_blank"
                                                                       href="{{ route('questionnaire.statistics', $questionnaire) }}">
                                                                        <i class="fas fa-chart-pie mr-2"></i> {{ __("my-dashboard.view_statistics")}}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="h-75 col-md-4 col-sm-12 justify-content-center align-self-center border-top-0">
                                                    @include('gamification.next-step', ['nextStepVM' => $questionnaire->gamificationNextStepVM])
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row gamification-box">
        <div class="col-md-9 col-sm-11 mx-auto mt-4 mb-4" style="float: none !important;">
            <div id="awards">
                @include('gamification.user-badges', ['badgesVM' => $viewModel->platformWideGamificationBadgesVM])
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('dist/js/myProfile.js')}}"></script>
    <script src="{{ mix('dist/js/projectGoal.js')}}"></script>
@endpush
