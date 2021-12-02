@extends('auth.layout')

@section('auth-form')
    <h1>{{ __("login-register.moto_login_page") }}</h1>
    <div class="reset">
        <p class="login-box-msg">{{ __("login-register.password_reset_message") }}</p>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('password.email') }}" method="post">
            {!! csrf_field() !!}

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
            <button type="submit"
                    class="btn btn-primary btn-block btn-flat"
            >{{ __("login-register.send_password_reset_link") }}</button>
        </form>
    </div>
@endsection

