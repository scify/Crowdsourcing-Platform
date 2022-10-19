<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('partials.favicons')
    <title>@yield('title_prefix', isset($viewModel->project) ? $viewModel->project->currentTranslation->name : config('app.name')) @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if (isset($viewModel->socialMediaMetadataVM))
        @include('landingpages.partials.header-meta', ['viewModel' => $viewModel->socialMediaMetadataVM])
    @else
        <link rel="canonical" href="{{route('home', ['locale' => app()->getLocale()])}}">
    @endif
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
    <link rel="preload" href="{{ mix('dist/css/common.css') }}" as="style"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ mix('dist/css/common.css') }}">
    </noscript>
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
@include('landingpages.partials.navbar')
@include('partials.flash-messages-and-errors')
<div id="app" style="padding-top: @if (App::environment('staging')) 128.75px @else 93.75px @endif">
    @yield('content')
</div>

@if(isset($viewModel->project))
    <footer class="py-5">
        <div class="container">
            {!! $viewModel->project->defaultTranslation->footer !!}
        </div>
    </footer>
@endif
<div id="pyro" class="">
    <div class="before"></div>
    <div class="after"></div>
</div>

<div class="loader-wrapper hidden">
    <img loading="lazy" src="{{asset('images/loading.gif')}}" alt="loading image">
</div>
@stack("modals")

@include('partials.footer-scripts')
</body>
</html>
