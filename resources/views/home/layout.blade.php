@php use Illuminate\Support\Facades\Route; @endphp
        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('partials.favicons')
    <title>@yield('title_prefix', config('app.name')) @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=10, user-scalable=yes" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @if(!isset($onErrorPage))
        <link rel="canonical" href="{{route(getNameOfRoute(Route::current()), ['locale' => app()->getLocale()])}}">
        @foreach (explode('|', config('app.regex_for_validating_locale_at_routes')) as $language)
            @if(strlen($language) === 2)
                <link rel="alternate" hreflang="{{ $language }}"
                      href="{{route(getNameOfRoute(Route::current()), ['locale' => $language])}}" />
            @endif
        @endforeach
    @endif
    @include('home.partials.' . config('app.installation_resources_dir') . '.head-meta')
    <link rel="stylesheet" media="print" onload="this.onload=null;this.removeAttribute('media');"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
    @vite('resources/assets/sass/common.scss')
    @vite('resources/assets/sass/project/landing-page.scss')
    @vite('resources/assets/sass/pages/home.scss')
    @stack('css')
    @include('analytics')
</head>
<body class="container-fluid p-0">
@include('partials.staging-indicator')
<div class="row">
    <div class="col-12">
        @include('home.partials.navbar', ['logoPath' => asset('images/projects/' . config('app.installation_resources_dir') . '/logo_menu.png')])
    </div>
</div>
@include('partials.flash-messages-and-errors')
<div id="app" style="padding-top: @if (App::environment('staging')) 128.75px @else 93.75px @endif">
    @yield('content')
</div>
@if(!isset($onErrorPage))
    <footer>
        <div class="container-fluid">
            @include('home.partials.' . config('app.installation_resources_dir') . '.footer')
        </div>
    </footer>
@endif
<div class="loader-wrapper hidden">
    <img loading="lazy" src="{{asset('images/loading.gif')}}" alt="loading image">
</div>
<x-laravel-cookie-guard-scripts></x-laravel-cookie-guard-scripts>
<x-laravel-cookie-guard></x-laravel-cookie-guard>
@include('partials.footer-scripts')
</body>
</html>
