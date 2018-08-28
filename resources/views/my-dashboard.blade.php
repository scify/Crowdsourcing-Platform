@extends('loggedin-environment.layout')

@section('content-header')
    <h1>My Dashboard</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/my-dashboard.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Welcome</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            [todo:put some introductory text here, this is generic and relates to the crowdsourcing
                            platform]
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">My contribution</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table style="margin-top:5px; width:100%;">
                                <tr>
                                    <th>Project</th>
                                    <th>Status</th>
                                </tr>
                                @if($viewModel->projects->count() === 0)
                                    <tr>
                                        <td colspan="3" class="no-projects-found">No projects found!
                                        </td>
                                    </tr>
                                @else
                                    @foreach($viewModel->projects as $project)
                                    <tr>
                                        <td style="padding-top:15px"><a href="{{$project->slug}}"> <img height="30" alt="{{$project->name}}"
                                                                                              src="{{asset($project->logo_path)}}"></a>
                                        </td>
                                        <td style="padding-top:15px;">{{$project->status}}</td>
                                    </tr>
                            @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="awards" class="col-md-6 col-xs-12">
            @include('gamification.user-badges', ['badgesVM' => $viewModel->badgesVM])
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @include('gamification.next-step', ['nextStepVM' => $viewModel->gamificationNextStepVM])
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ mix('dist/js/myProfile.js')}}?{{env("APP_VERSION")}}"></script>
@endpush
