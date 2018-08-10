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
                                    <th>You can help by:</th>
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
                                        <td style="padding-top:15px;margin-right:100px;">{!! $project->help_by !!}</td>
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
            <div class="box box-danger">
                <div class="box-header with-border">
                    @if($viewModel->badges->count() === 0)
                        <h3 class="box-title">You don't have any awards assigned. That's a pity!</h3>
                    @else
                        <h3 class="box-title">You have unlocked {{$viewModel->badges->count()}} award(s) so far</h3>
                    @endif
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 text-center badges-container">
                            @if($viewModel->badges->count() === 0)
                                {{--TODO: this is not correct, we need to change it to whatever gamification challenge we need to propose to the user--}}
                                <a href="/fair-eu?open=1" class="to-do-next">Respond to FAIR-EU questionnaire <br> and
                                    gain
                                    the Contributor award
                                    <br>
                                    <br>
                                    <img src="{{asset("images/badges/award.png")}}">
                                </a>
                            @else
                                @foreach($viewModel->badges as $badge)
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 single-badge">{!! $badge !!}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ mix('dist/js/myProfile.js')}}?{{env("APP_VERSION")}}"></script>
@endpush
