@php use Illuminate\Contracts\Auth\Access\Gate; @endphp
        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('partials.favicons')
    <title>@yield('title_prefix', config('app.name')) @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="stylesheet" media="print" onload="this.onload=null;this.removeAttribute('media');"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
    @vite('resources/assets/sass/common.scss')
    @vite('resources/assets/sass/common-backoffice.scss')
    @stack('css')
    <!--[if lt IE 9]>
    <script defer src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script defer src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
    @include('analytics')
</head>
<body class="logged-in-env {{ app(Gate::class)->check("moderate-results")? "display-admin-menu": ""  }} hold-transition skin-white sidebar-mini layout-fixed layout-navbar-fixed @yield('body_class')">
<div id="app" class="wrapper">
    @if(Auth::check())
        @include("loggedin-environment.partials.menu")
    @endif
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col">
                        @yield("content-header")
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                @include('partials.flash-messages-and-errors')
                @yield('content')
            </div>
        </section>
    </div>
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            <b>Version</b> {{ config("app.version")}}
        </div>
        <strong>Created by <a target="_blank" href="https://www.scify.org">SciFY.org</a></strong>
    </footer>

</div>

@stack("modals")
@include("partials.footer-scripts",["includeBackofficeCommonJs" => true])

</body>
</html>
