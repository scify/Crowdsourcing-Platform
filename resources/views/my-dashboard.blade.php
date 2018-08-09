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
                                <tr>
                                    <td style="padding-top:15px"><a href="/fair-eu"> <img height="30" alt="FAIR EU"
                                                                                          src="https://dev.ecas/images/default-project/fair-eu.png"></a>
                                    </td>
                                    <td style="padding-top:15px;">In progress</td>
                                    <td style="padding-top:15px;margin-right:100px;"><a href="/fair-eu?open=1">Responding
                                            to a questionnaire</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="awards" class="col-md-6 col-xs-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    @if($viewModel->count() === 0)
                        <h3 class="box-title">You don't have any awards assigned. That's a pity!</h3>
                    @else
                        <h3 class="box-title">You have unlocked {{$viewModel->count()}} award(s) so far</h3>
                    @endif
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12 text-center badges-container">
                            @if($viewModel->count() === 0)
                                <a href="/fair-eu?open=1" class="to-do-next">Respond to FAIR-EU questionnaire <br> and
                                    gain
                                    the Influencer award
                                    <br>
                                    <br>
                                    <img src="{{asset("images/badges/award.png")}}">
                                </a>
                            @else
                                @foreach($viewModel as $badge)
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
