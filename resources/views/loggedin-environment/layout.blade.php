<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        @include('partials.favicons')
        <title>@yield('title_prefix', config('app.name')) @yield('title_postfix', '')</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="{{ asset('dist/css/common.css')}}?{{env("APP_VERSION")}}">
        <link href="{{asset('dist/css/select2.min.css')}}" rel="stylesheet">
        @stack('css')

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

        <![endif]-->
        @if (App::environment('production'))
            @include('analytics')
        @endif
    </head>
    <body class="hold-transition skin-white sidebar-mini layout-fixed layout-navbar-fixed @yield('body_class')">
        @if (App::environment('staging'))
            <div class="staging-warning">
                <p>~~~WARING: STAGING ENVIRONMENT~~~</p>
            </div>
        @endif
        <div class="wrapper">
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
                        @if(session('flash_message_success'))
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> {{ session('flash_message_success') }}</h4>
                            </div>
                        @endif

                        @if(session('flash_message_failure'))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> {{ session('flash_message_failure') }}</h4>
                            </div>
                        @endif
                        @if (count($errors) > 0 )
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                @foreach ($errors->all() as $error)
                                    <h4><i class="icon fa fa-ban"></i> {{ $error }}</h4>
                                @endforeach
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <div class="float-right d-none d-sm-inline">
                    <b>Version</b> {{ env("APP_VERSION")}}
                </div>
                <strong>Created by <a target="_blank" href="https://www.scify.org">SciFY.org</a></strong>
            </footer>

        </div>

        @stack("modals")

        @include("partials.footer-scripts")

    </body>
</html>
