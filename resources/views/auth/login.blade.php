@extends('auth.layout')

@section('auth-form')
    <h1>
        @if ($displayQuestionnaireLabels)
            {{ __("login-register.one_step_away")}}
        @else
            {{ __("login-register.moto_login_page") }}
        @endif
    </h1>
    <div class="logIn">
        <div class="form-wrapper">
            <p class="login-box-msg">
                @if ($displayQuestionnaireLabels)
                    {{ __("login-register.avoid_duplicate_submissions")}}
                @else
                    {{ __("login-register.login_message") }}
                @endif
            </p>
            <form action="{{ route('login') }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="checkbox icheck">
                            <label>
                                <input class="icheck-input" type="checkbox" required name="privacy-policy">
                                <span class="ml-3">{!! __("notifications.agree_privacy_policy") !!}</a></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6 col-sm-10">
                        <div class="checkbox icheck">
                            <label>
                                <input class="icheck-input" type="checkbox" name="remember"><span class="ml-3">{{ __("login-register.remember_me") }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-10">
                        <button type="submit"
                                class="btn btn-primary btn-block btn-flat btn-lg">{{ __("questionnaire.sign_in")}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @include('auth.partials.social-sign-in')
        <div class="auth-links">
            <a href="{{ route('register') }}"
               class="text-center"
            >{{ __("login-register.register_option") }}</a>
            <br>
            <a href="{{ route('password.request') }}"
               class="text-center"
            >{{ __("login-register.i_forgot_my_password") }}</a>
            <br>
        </div>
    </div>
@endsection

