@extends('loggedin-environment.layout')

@section('content-header')
    <h1>My Account</h1>
@stop

@push('css')
    <link rel="stylesheet" href="{{ asset('dist/css/my-dashboard.css') }}">
@endpush

@section('content')

    <div class="row">
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

                            <label class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <div class="form-group has-feedback">
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{ $viewModel->user->email  }}"
                                           required
                                           autofocus
                                           placeholder="Name">
                                </div>
                            </div>
                            <span class="form-control-feedback"></span>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif

                            <label class="col-sm-4 control-label">Nickname</label>
                            <div class="col-sm-8">
                                <div class="form-group has-feedback">
                                    <input id="nickname" type="text" class="form-control" name="nickname"
                                           value="{{ $viewModel->user->nickname  }}"
                                           required
                                           autofocus
                                           placeholder="Name">
                                </div>
                            </div>
                            <span class="form-control-feedback"></span>
                            @if ($errors->has('nickname'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('nickname') }}</strong>
                                    </span>
                            @endif
                            @if($viewModel->user->password)
                                <label for="current_password" class="col-sm-4 control-label">Current Password</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="current_password"
                                               name="current_password" placeholder="Current Password">
                                    </div>
                                </div>
                            @endif
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
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Account Deactivation</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="#deactivationConfirmationModal" data-toggle="modal" class="btn btn-danger">Deactivate my account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

<div id="deactivationConfirmationModal" class="modal fade">
    <div class="modal-dialog" style="margin-top: 10%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Are you sure?</h4>
            </div>
            <div class="modal-body">
                <p class="text-danger"><b>Waring:</b> This action will delete your account.<br><br>You will lose  all your badges and will not be able to participate in the platform any more.</p>
            </div>
            <div class="modal-footer">
                <form role="form" method="POST" action="{{ url('/user/deactivate') }}"
                      novalidate>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">I understand, please deactivate my account</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ mix('dist/js/myProfile.js')}}?{{env("APP_VERSION")}}"></script>
@endpush
