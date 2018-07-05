@extends('loggedin-environment.layout')

@section('content-header')
    <h1>Dashboard</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/my-profile.css') }}">
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
                            Under construction: Call to action to answer the question should be displayed here and any
                            welcome material
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
                    <h3 class="box-title">Gamification Elements</h3>
                </div>
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-12">
                            A summary of gamification tools can be displayed here. Badges and action required for next
                            level
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Personal Details</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form id="form-change-password" role="form" method="POST" action="{{ url('/user/update') }}"
                              novalidate>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">


                            <label class="col-sm-4 control-label">First Name</label>
                            <div class="col-sm-8">
                                <div class="form-group has-feedback">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ $viewModel->user->name  }}"
                                           required
                                           autofocus
                                           placeholder="Name">
                                </div>
                            </div>
                            <span class="form-control-feedback"></span>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif


                            <label class="col-sm-4 control-label">Surname</label>
                            <div class="col-sm-8">
                                <div class="form-group has-feedback">
                                    <input id="surname" type="text" class="form-control" name="surname"
                                           value="{{ $viewModel->user->surname}}"
                                           required
                                           autofocus placeholder="Surname">
                                </div>
                            </div>
                            @if ($errors->has('surname'))
                                <span class="help-block">
                                            <strong>{{ $errors->first('surname') }}</strong>
                                        </span>
                            @endif
                            <label for="current_password" class="col-sm-4 control-label">Current Password</label>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="current_password"
                                           name="current_password" placeholder="Current Password">
                                </div>
                            </div>
                            <label for="password" class="col-sm-4 control-label">New Password</label>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="Password">
                                </div>
                            </div>
                            <label for="password_confirmation" class="col-sm-4 control-label">Re-enter
                                Password</label>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password_confirmation"
                                           name="password_confirmation" placeholder="Re-enter Password">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ mix('dist/js/myProfile.js')}}?{{env("APP_VERSION")}}"></script>
@endpush
