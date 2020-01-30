@extends('auth.layout')

@section('auth-form')
    <h1>
        @if ($displayQuestionnaireLabels)
            You're one step away!
        @else
            Let's define our future!
            @endif
    </h1>
    <div class="logIn">
        <div class="form-wrapper">
            <p class="login-box-msg">
                @if ($displayQuestionnaireLabels)
                    In order to avoid duplicate submissions, only logged-in users can contribute. Please login to continue
                    @else
                    Sign in with your account
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
                <div class="row">
                    <div class="col-xs-7">
                        <div class="checkbox icheck">
                            <label>
                                <input class="icheck-input" type="checkbox" name="remember"> Remember me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-5">
                        <button type="submit"
                                class="btn btn-primary btn-block btn-flat">Sign in</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        @include('auth.partials.social-sign-in')
        <div class="auth-links">
            <a href="{{ route('register') }}"
               class="text-center"
            >I want to register</a>
            <br>
            <a href="{{ route('password/reset') }}"
               class="text-center"
            >I forgot my password</a>
            <br>
        </div>
    </div>
@stop

