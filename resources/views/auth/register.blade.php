@extends('auth.layout')

@section('auth-form')
    <h1>Let's define our future!</h1>
    <div class="form-wrapper">
        <p class="welcome-msg">Create your account</p>
        <form action="{{ route('register') }}" method="post">
            @include('auth.partials.register_form')
            <button type="submit"
                    class="btn btn-primary btn-block btn-flat btn-lg">Create account</button>
        </form>
    </div>
    @include('auth.partials.social-sign-in')
    <div class="auth-links">
        <a href="{{ route('login') }}"
           class="text-center">I already have an account</a>
    </div>
@stop
@push('scripts')
    <script src="{{ asset('dist/js/register.js') }}"></script>
@endpush
