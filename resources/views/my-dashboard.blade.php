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
                        <div class="col-md-6 text-center col-main">
                            @if($viewModel->projects->isEmpty())


                                <div class="no-projects-found">There are currently no active projects.
                                </div>
                            @else
                                <table id="available-projects" class="table table-hover" cellspacing="0"
                                       style="width: 100%;">
                                    <thead>
                                    <tr>

                                        <th>
                                            Logo
                                        </th>
                                        <th>
                                            er
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($viewModel->projects as $project)
                                        <tr>
                                            <td class="logo-column">
                                                <div><a href="{{ route('project.landing-page', $project->slug) }}"> <img
                                                                height="70" alt="{{$project->name}}"
                                                                src="{{asset($project->logo_path)}}"></a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress-container">
                                                    @if($project->projectGoalVM)
                                                        @include('landingpages.partials.project-goal', ['projectGoalVM' => $project->projectGoalVM, 'projectId' => $project->id])
                                                    @else
                                                        <p>This project does not have an active questionnaire yet.</p>
                                                    @endif
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="col-md-6 col-main">
                            @include('gamification.next-step', ['nextStepVM' => $viewModel->gamificationNextStepVM])
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row gamification-box">
        <div class="col-lg-7" style="margin: 10px auto; float: none !important;">
            <div id="awards">
                @include('gamification.user-badges', ['badgesVM' => $viewModel->badgesVM])
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ mix('dist/js/myProfile.js')}}?{{env("APP_VERSION")}}"></script>
    <script src="{{ mix('dist/js/projectGoal.js')}}?{{env("APP_VERSION")}}"></script>
@endpush
