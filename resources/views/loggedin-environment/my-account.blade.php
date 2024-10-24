@extends('loggedin-environment.layout')

@section('content-header')
    <h1>{{ __("my-account.my_account") }}</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="card card-info card-outline">
                <div class="card-header py-3 px-5">
                    <h3 class="card-title"> {{ __("my-account.personal_details") }}</h3>
                </div>
                <div class="card-body p-5">
                    <div class="container-fluid p-0">
                        <div class="row p-0">
                            <div class="col">
                                <form id="form-change-password" class="w-100" method="POST"
                                      action="{{ route('user.update') }}"
                                      enctype="multipart/form-data">
                                    @method('PUT')
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="container-fluid p-0">
                                        <div class="row p-0">
                                            <label class="col-12 control-label">{{ __("login-register.email") }}</label>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input id="email" type="email" class="form-control mb-1"
                                                           name="email"
                                                           value="{{ $viewModel->user->email  }}"
                                                           required
                                                           autofocus
                                                           placeholder="{{ __("login-register.email") }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-0">
                                            <label class="col-12 control-label">{{ __("my-account.profile_image") }}</label>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input id="avatar" type="file" class="form-control p-2 h-auto"
                                                           name="avatar"
                                                           accept="image/png,image/jpeg,image/jpg"
                                                           placeholder="{{ __("my-account.profile_image") }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-0">
                                            <label class="col-12 control-label">{{ __("login-register.nickname") }}</label>
                                            <div class="col-12">
                                                <div class="form-group has-feedback">
                                                    <input id="nickname" type="text" class="form-control mb-1"
                                                           name="nickname"
                                                           value="{{ $viewModel->user->nickname  }}"
                                                           required
                                                           autofocus
                                                           placeholder="Name">
                                                    <span class="help-block hidden my-1" id="nickname-help">
                                                        <small>{{ __('my-account.nickname_help') }}</small>
                                                    </span>
                                                </div>
                                            </div>

                                            <span class="form-control-feedback"></span>
                                            @if ($errors->has('nickname'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('nickname') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="row p-0">
                                            @if($viewModel->user->password)
                                                <label for="current_password"
                                                       class="col-12 control-label">{{ __("my-account.current_password") }}</label>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <input type="password" class="form-control"
                                                               id="current_password"
                                                               name="current_password"
                                                               placeholder="{{ __("my-account.current_password") }}">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row p-0">
                                            <label for="password"
                                                   class="col-12 control-label">{{ __("my-account.new_password") }}</label>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" id="password"
                                                           name="password"
                                                           placeholder="{{ __("login-register.password") }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3 p-0">
                                            <label for="password_confirmation"
                                                   class="col-12 control-label">{{ __("my-account.re_enter_password") }}</label>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="password" class="form-control"
                                                           id="password_confirmation"
                                                           name="password_confirmation"
                                                           placeholder="{{ __("my-account.re_enter_password") }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-0">
                                            <div class="col-lg-4 col-sm-12">
                                                <button type="submit"
                                                        class="btn btn-primary btn-slim w-100">{{ __("my-account.update") }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="card card-info card-outline">
                <div class="card-header py-3 px-5">
                    <h3 class="card-title">{{ __("my-account.my_data") }}</h3>
                </div>
                <div class="card-body p-5">
                    <div class="container-fluid p-0">
                        <div class="row p-0">
                            <div class="col">
                                <a href="{{ route('my-data.download') }}" data-widget="tooltip"
                                   title="This includes all your responses to questionnaires" target="_blank"
                                   class="btn btn-primary btn-slim">{{ __("my-account.download_my_data") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <div class="card card-default card-outline">
                <div class="card-header py-3 px-5">
                    <h3 class="card-title">{{ __("my-account.account_deactivation") }}</h3>
                </div>
                <div class="card-body p-5">
                    <div class="container-fluid p-0">
                        <div class="row p-0">
                            <div class="col-12">
                                <a href="#deactivationConfirmationModal"
                                   class="btn btn-outline-danger btn-slim"
                                   data-toggle="modal">{{ __("my-account.deactivate_my_account") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="deactivationConfirmationModal" class="modal fade">
        <div class="modal-dialog modal-lg" style="margin-top: 10%">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __("my-account.are_you_sure") }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">{!! __("my-account.warning_for_deactivation") !!}</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ url('/user/deactivate') }}" class="w-100"
                          novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <button type="button" class="btn btn-default btn-slim w-100" data-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <button type="submit"
                                            class="btn btn-danger btn-slim w-100">{{ __("my-account.deactivate_my_account_2") }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('scripts')
    @vite('resources/assets/js/pages/register.js')
@endpush
