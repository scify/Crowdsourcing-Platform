@extends('loggedin-environment.layout')

@section('content-header')
    <h1>My Dashboard</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/my-dashboard.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Projects you can contribute to</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="container-fluid table-responsive">
                                @if($viewModel->projects->isEmpty())
                                    <div class="no-projects-found">There are currently no active projects.
                                    </div>
                                @else
                                    <table id="available-projects" class="row table table-hover">
                                        <tbody>
                                        @foreach($viewModel->projects as $project)
                                            <tr>
                                                <td class="col-md-3 col-sm-6 vertical-middle">
                                                    <div><a href="{{ route('project.landing-page', $project->slug) }}">
                                                            <img class="project-logo"
                                                                    alt="Project logo for {{$project->name}}"
                                                                    src="{{asset($project->logo_path)}}"></a>
                                                    </div>
                                                </td>
                                                <td class="col-md-4 col-sm-6 vertical-middle">
                                                    <div class="progress-container">
                                                        @if($project->currentQuestionnaireGoalVM)
                                                            @include('landingpages.partials.project-goal', ['viewModel' => $project->currentQuestionnaireGoalVM, 'projectId' => $project->id])
                                                        @else
                                                            <p>This project does not have an active questionnaire yet.</p>
                                                        @endif
                                                    </div>

                                                </td>
                                                <td class="col-md-5 col-sm-12 vertical-middle">
                                                    @include('gamification.next-step', ['nextStepVM' => $project->gamificationNextStepVM])
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
        <div class="col-lg-7" style="margin: 10px auto; float: none !important;">
            <div id="awards">
                @include('gamification.user-badges', ['badgesVM' => $viewModel->platformWideGamificationBadgesVM])
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ mix('dist/js/myProfile.js')}}?{{env("APP_VERSION")}}"></script>
    <script src="{{ mix('dist/js/projectGoal.js')}}?{{env("APP_VERSION")}}"></script>
@endpush
