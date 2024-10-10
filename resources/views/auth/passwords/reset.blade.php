@extends('auth.layout')

@section('auth-form')
    <h1>{{ __("login-register.moto_login_page") }}</h1>
    <div class="reset">
        <p class="login-box-msg">{{ __("login-register.password_reset_message") }}</p>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}"
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
            <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Retype Password">
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                @endif
            </div>
            <div class="container-fluid">
                <div class="row auth-btn-container">
                    <div class="col-md-6 col-sm-11 mx-auto">
                        <button type="submit"
                                class="btn btn-primary btn-block btn-flat m-0"
                        >{{ __("email_messages.reset_password")}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
