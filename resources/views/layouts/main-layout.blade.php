<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.ico') }}"/>
    <title>@yield('title_prefix', env('APP_NAME')) @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/skins/skin-blue.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('dist/css/common.css') }}">
    {{--Loading summernote CSS via CDN because webpack does not seem to get it working...--}}
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('dist/css/sweetalert.css') }}">
    @stack('css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="hold-transition skin-blue sidebar-mini @yield('body_class')">

<div class="wrapper">



    @include("layouts.menu")

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @yield("content-header")
           {{-- <ol class="breadcrumb">
                <li><a href="{{ url("/") }}"><i class="fa fa-dashboard"></i>Home</a></li>
                <li class="active"> {{ isset($pageTitle) ? $pageTitle : ''}}</li>
            </ol>--}}
        </section>


        <section class="content">
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
        </section>

    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> {{ env("APP_VERSION")}}
        </div>
        <strong>Copyright &copy; {{ date("Y") }} <a target="_blank" href="http://www.enikos.gr">Enikos.gr</a></strong>
        All rights reserved.
    </footer>
    @include("layouts.control-sidebar")

</div>


@include("layouts.footer-scripts")

</body>
</html>
