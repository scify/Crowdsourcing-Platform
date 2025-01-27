<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('partials.favicons')
    @if(!isset($viewModel->page_title))
        <title>@yield('title_prefix', isset($viewModel->project) ? $viewModel->project->currentTranslation->name : config('app.name')) @yield('title_postfix', '')</title>
    @else
        <title>{{ $viewModel->page_title }}</title>
    @endif
    <meta content="width=device-width, initial-scale=1, maximum-scale=10, user-scalable=yes" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('header-scripts')
    @if (isset($viewModel->socialMediaMetadataVM))
        @include('crowdsourcing-project.partials.header-meta', ['viewModel' => $viewModel->socialMediaMetadataVM])
    @else
        <link rel="canonical" href="{{route('home', ['locale' => app()->getLocale()])}}">
    @endif
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
    @vite('resources/assets/sass/common.scss')
    @vite('resources/assets/sass/project/landing-page.scss')
    @vite('resources/assets/sass/pages/home.scss')
    @stack('css')
    @include('analytics')
</head>
<body class="container-fluid p-0">
@include('partials.staging-indicator')
@include('crowdsourcing-project.partials.navbar')
@include('partials.flash-messages-and-errors')
<div id="app" class="project-layout"
     style="padding-top: @if (App::environment('staging')) 128.75px @else 93.75px @endif">
    @yield('content')
</div>
@if($viewModel->projectHasCustomFooter())
    <footer class="py-5">
        <div class="container">
            {!! $viewModel->project->defaultTranslation->footer !!}
        </div>
    </footer>
@else
    <footer class="pt-5">
        <div class="container-fluid">
            @include('home.partials.' . config('app.installation_resources_dir') . '.footer')
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
<x-laravel-cookies-consent></x-laravel-cookies-consent>
@include('partials.footer-scripts')
</body>
</html>
