@php use Illuminate\Contracts\Auth\Access\Gate; @endphp
        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('partials.favicons')
    <title>@yield('title_prefix', config('app.name')) @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=10, user-scalable=yes" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="stylesheet" media="print" onload="this.onload=null;this.removeAttribute('media');"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
    @vite('resources/assets/sass/common.scss')
    @vite('resources/assets/sass/common-backoffice.scss')
    @stack('css')
    @include('analytics')
</head>
<body class="backoffice logged-in-env {{ !app(Gate::class)->check("moderate-content-by-users") ? "no-sidebar" : "" }} @yield('body_class')">
<div id="app">
    @include("backoffice.partials.header-controls")
    <div class="bo-body">
        @canany(['moderate-content-by-users'])
            @include("backoffice.partials.sidebar-menu")
        @endcanany
        <main class="bo-main">
            <section class="content">
                <div class="container" id="main-content">
                    <div class="content-header">
                        <div class="row my-4">
                            <div class="col p-0">
                                @yield("content-header")
                            </div>
                        </div>
                    </div>
                    @include('partials.flash-messages-and-errors')
                    @yield('content')
                </div>
            </section>
            <footer class="bo-footer">
                <div class="float-end d-none d-sm-inline">
                    <b>Version</b> {{ config("app.version") }}
                </div>
                <strong>Created by <a target="_blank" href="https://www.scify.org">SciFY.org</a></strong>
            </footer>
        </main>
    </div>
</div>

@stack("modals")
@include("partials.footer-scripts", ["includeBackofficeCommonJs" => true])

</body>
</html>
