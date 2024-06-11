@extends('loggedin-environment.layout')

@section('content-header')
    <h1>{{ __("my-account.my_account") }}</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"> {{ __("my-account.personal_details") }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form id="form-change-password" class="w-100" role="form" method="POST"
                              action="{{ url('/user/update') }}"
                              novalidate>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <label class="col-sm-4 control-label">{{ __("login-register.email") }}</label>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div>{{ $viewModel->user->email  }}</div>
                                </div>
                            </div>
                            <label class="col-sm-4 control-label">{{ __("login-register.nickname") }}</label>
                            <div class="col-sm-8">
                                <div class="form-group has-feedback">
                                    <input id="nickname" type="text" class="form-control mb-1" name="nickname"
                                           value="{{ $viewModel->user->nickname  }}"
                                           required
                                           autofocus
                                           placeholder="Name">
                                </div>
                            </div>
                            <span class="help-block hidden col-sm-10 mb-2" id="nickname-help">
                                <strong>{{ __('my-account.nickname_help') }}</strong>
                            </span>
                            <span class="form-control-feedback"></span>
                            @if ($errors->has('nickname'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('nickname') }}</strong>
                                    </span>
                            @endif
                            @if($viewModel->user->password)
                                <label for="current_password"
                                       class="col-sm-4 control-label">{{ __("my-account.current_password") }}</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="current_password"
                                               name="current_password"
                                               placeholder="{{ __("my-account.current_password") }}">
                                    </div>
                                </div>
                            @endif
                            <label for="password"
                                   class="col-sm-4 control-label">{{ __("my-account.new_password") }}</label>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="{{ __("login-register.password") }}">
                                </div>
                            </div>
                            <label for="password_confirmation"
                                   class="col-sm-4 control-label">{{ __("my-account.re_enter_password") }}</label>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password_confirmation"
                                           name="password_confirmation"
                                           placeholder="{{ __("my-account.re_enter_password") }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary">{{ __("my-account.update") }}</button>
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
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ __("my-account.my_data") }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('downloadMyData') }}" data-widget="tooltip"
                               title="This includes all your responses to questionnaires" target="_blank"
                               class="btn btn-primary">{{ __("my-account.download_my_data") }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="card card-default card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ __("my-account.account_deactivation") }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="#deactivationConfirmationModal"
                               data-toggle="modal">{{ __("my-account.deactivate_my_account") }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="deactivationConfirmationModal" class="modal fade">
        <div class="modal-dialog" style="margin-top: 10%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __("my-account.are_you_sure") }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">{!! __("my-account.warning_for_deactivation") !!}</p>
                </div>
                <div class="modal-footer">
                    <form role="form" method="POST" action="{{ url('/user/deactivate') }}"
                          novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit"
                                class="btn btn-danger">{{ __("my-account.deactivate_my_account_2") }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    @vite('resources/dist/js/register.js')
@endpush
