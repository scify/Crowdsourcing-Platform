@extends('auth.layout')

@section('auth-form')
    <h1>{{ __("login-register.moto_login_page") }}</h1>
    <div class="form-wrapper">
        <p class="welcome-msg">{{ __("login-register.create_your_account") }}</p>
        <form action="{{ route('register') }}" method="post">
            @include('auth.partials.register_form')
            <div class="container-fluid">
                <div class="row auth-btn-container">
                    <div class="col">
                        <button type="submit"
                                class="btn btn-primary btn-block btn-flat btn-lg m-0">{{ __("login-register.register") }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('auth.partials.social-sign-in')
    <div class="auth-links">
        <a href="{{ route('login') }}"
           class="text-center">{{ __("login-register.i_already_have_a_membership") }}</a>
    </div>
@endsection
@push('scripts')
    @vite('resources/assets/js/pages/register.js')
@endpush
