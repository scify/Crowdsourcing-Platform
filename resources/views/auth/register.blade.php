@extends('auth.layout')

@section('auth-form')
    <h1>Let's define our future!</h1>
    <div class="form-wrapper">
        <p class="welcome-msg">Create your account</p>
        <form action="{{ url(config('adminlte.register_url', 'register')) }}" method="post">
            @include('auth.partials.register_form')
            <button type="submit"
                    class="btn btn-primary btn-block btn-flat"
            >{{ trans('adminlte::adminlte.register') }}</button>
        </form>
    </div>
    @include('auth.partials.social-sign-in')
    <div class="auth-links">
        <a href="{{ url(config('adminlte.login_url', 'login')) }}"
           class="text-center">{{ trans('adminlte::adminlte.i_already_have_a_membership') }}</a>
    </div>
@stop
@push('scripts')
    <script src="{{ asset('dist/js/register.js') }}"></script>
@endpush