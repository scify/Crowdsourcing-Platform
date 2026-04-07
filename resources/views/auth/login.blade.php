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
                    <div class="col-md-6 col-sm-12">
                        <div class="checkbox icheck">
                            <label>
                                <input class="icheck-input" type="checkbox" name="remember"><span class="ml-3">{{ __("login-register.remember_me") }}</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row auth-btn-container">
                    <div class="col-md-6 col-sm-11 mx-auto">
                        <button type="submit"
                                class="btn btn-primary btn-block btn-flat btn-lg my-0">{{ __("questionnaire.sign_in")}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @include('auth.partials.social-sign-in')
        <div class="auth-links">
            <a href="{{ route('register') }}"
               class="text-center mb-sm-2"
            >{{ __("login-register.register_option") }}</a>
            <br>
            <a href="{{ route('password.request') }}"
               class="text-center"
            >{{ __("login-register.i_forgot_my_password") }}</a>
            <br>
        </div>
    </div>
    @if (App::environment('staging'))
    <div class="demo-access mx-4 mb-4 mt-2 p-3">
        <div class="demo-access__label d-flex align-items-center mb-2">
            <i class="fas fa-flask mr-2 text-muted" aria-hidden="true"></i>
            <span class="text-muted font-weight-bold" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:.05em;">
                Demo Quick Access
            </span>
        </div>
        <div class="d-flex" style="gap:.5rem;">
            <button type="button"
                    class="btn btn-outline-secondary btn-block btn-sm demo-login-btn"
                    data-email="demo-user@demo.com"
                    data-password="{{ config('app.admin_pass_seed') }}">
                <i class="fas fa-user mr-1" aria-hidden="true"></i> Demo User
            </button>
            <button type="button"
                    class="btn btn-outline-danger btn-block btn-sm demo-login-btn mt-0"
                    data-email="demo-admin@demo.com"
                    data-password="{{ config('app.admin_pass_seed') }}">
                <i class="fas fa-user-shield mr-1" aria-hidden="true"></i> Demo Admin
            </button>
        </div>
        <p class="text-muted mt-2 mb-0" style="font-size:0.7rem;">
            These accounts contain demo data only and are not for production use.
        </p>
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('.demo-login-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var form = document.querySelector('form[action="{{ route('login') }}"]');
                form.querySelector('input[name="email"]').value = this.dataset.email;
                form.querySelector('input[name="password"]').value = this.dataset.password;
                form.submit();
            });
        });
    </script>
    @endpush
    @endif
@endsection

