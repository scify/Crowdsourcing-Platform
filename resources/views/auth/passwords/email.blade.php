@extends('auth.layout')

@section('auth-form')
    <h1>Let's define our future!</h1>
    <div class="reset">
        <p class="login-box-msg">Reset your password</p>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('password/email') }}" method="post">
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
            >Send Password Reset link</button>
        </form>
    </div>
@stop

