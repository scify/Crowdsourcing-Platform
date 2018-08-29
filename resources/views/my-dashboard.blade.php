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
                        <h3 class="box-title">Project Goal</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 text-center col-main">
                                @if($viewModel->projects->count() === 0)
                                    <div class="no-projects-found">There are currently no active projects.
                                    </div>
                                @else
                                    @foreach($viewModel->projects as $project)
                                        <div style="padding-top:15px"><a href="{{$project->slug}}"> <img height="70" alt="{{$project->name}}"
                                                                                                         src="{{asset($project->logo_path)}}"></a>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="row">
                                    <div class="col-xs-3 progress-container">
                                        @if($viewModel->projectGoalVM)
                                            @include('landingpages.partials.project-goal', ['projectGoalVM' => $viewModel->projectGoalVM])
                                        @endif
                                    </div>
                                </div>
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
        <div class="col-md-12" style="position: relative">
        <div class="col-md-7" style="margin: 10px auto; float: none !important;">
            <div id="awards">
                @include('gamification.user-badges', ['badgesVM' => $viewModel->badgesVM])
            </div>
        </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ mix('dist/js/myProfile.js')}}?{{env("APP_VERSION")}}"></script>
@endpush
