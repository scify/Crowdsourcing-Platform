@php use Illuminate\Support\Facades\Route; @endphp
        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('partials.favicons')
    <title>@yield('title_prefix', config('app.name')) @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="canonical" href="{{route(getNameOfRoute(Route::current()), ['locale' => app()->getLocale()])}}">
    @foreach (explode('|', config('app.regex_for_validating_locale_at_routes')) as $language)
        @if(strlen($language) === 2)
            <link rel="alternate" hreflang="{{ $language }}"
                  href="{{route(getNameOfRoute(Route::current()), ['locale' => $language])}}"/>
        @endif
    @endforeach
    @include('home.partials.' . config('app.installation_resources_dir') . '.head-meta')
    <link rel="stylesheet" media="print" onload="this.onload=null;this.removeAttribute('media');"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{ mix('dist/css/common.css') }}">
    <link rel="preload" href="{{ mix('dist/css/landing-page.css') }}" as="style"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ mix('dist/css/landing-page.css') }}">
    </noscript>
    <link rel="preload" href="{{ mix('dist/css/home.css') }}" as="style"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ mix('dist/css/home.css') }}">
    </noscript>
    @stack('css')

    @include('analytics')
</head>
<body class="container-fluid p-0">
@include('partials.staging-indicator')
<div class="row">
    <div class="col-12">
        @include('home.partials.' . config('app.installation_resources_dir') . '.navbar')
    </div>
</div>
@include('partials.flash-messages-and-errors')
<div id="app" style="padding-top: @if (App::environment('staging')) 128.75px @else 93.75px @endif">
    @yield('content')
</div>

<footer>
    <div class="container-fluid">
        @include('home.partials.' . config('app.installation_resources_dir') . '.footer')
    </div>
</footer>
<div class="loader-wrapper hidden">
    <img loading="lazy" src="{{asset('images/loading.gif')}}" alt="loading image">
</div>

@include('partials.footer-scripts')

</body>
</html>
