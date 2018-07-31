@extends('auth.layout')

@section('auth-form')
    <h1>Let's define our future!</h1>
    <div class="reset">
        <p class="login-box-msg">{{ trans('adminlte::adminlte.password_reset_message') }}</p>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ url(config('adminlte.password_email_url', 'password/email')) }}" method="post">
            {!! csrf_field() !!}

            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <input type="email" name="email" class="form-control" value="{{ $email or old('email') }}"
                       placeholder="{{ trans('adminlte::adminlte.email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                @endif
            </div>
            <button type="submit"
                    class="btn btn-primary btn-block btn-flat"
            >{{ trans('adminlte::adminlte.send_password_reset_link') }}</button>
        </form>
    </div>
@stop

