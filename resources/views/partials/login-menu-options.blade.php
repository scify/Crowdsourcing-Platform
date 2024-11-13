@if (Auth::check())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('my-dashboard') }}"> {{ __("menu.dashboard") }} </a>
    </li>
    @include('partials.user-actions-header-dropdown')
@else
    <li class="nav-item">
        <a class="nav-link" href="{{ isset($redirectLoginURL) ? $redirectLoginURL : route("login") }}">{{ __("menu.login")}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ isset($redirectRegisterURL) ? $redirectRegisterURL : route("register") }}">{{ __("menu.register")}}</a>
    </li>
@endif
