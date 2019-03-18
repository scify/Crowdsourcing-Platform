<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('partials.favicons')
    <title>@yield('title_prefix', config('app.name')) @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{ asset('dist/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/auth.css') }}">
    @stack('css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @if (App::environment('production'))
        @include('analytics')
    @endif
</head>
<body class="hold-transition background-page @yield('body_class')" style="background-image: url('{{ asset('images/projects/' . config('app.project_resources_dir') . '/active_participation.png') }}');">
@if (App::environment('staging'))
    <div class="staging-warning">
        <p>~~~WARING: STAGING ENVIRONMENT~~~</p>
    </div>
@endif
<div class="login-box">
    <div class="login-box-body">
        @yield('auth-form')
    </div>
</div>

@include("partials.footer-scripts")

@stack('scripts')

</body>
</html>
