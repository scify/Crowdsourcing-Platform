<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.ico') }}"/>
    <title>@yield('title_prefix', env('APP_NAME')) @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('dist/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/register.css') }}">
    @stack('css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="hold-transition register-page @yield('body_class')">

<div class="login-box">
    <div class="login-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! '<b>Crowdsourcing Platform</b>' !!}</a>
    </div>

    <div class="login-box-body">
        @yield('auth-form')
    </div>
</div>

@include("partials.footer-scripts")

@stack('scripts')

</body>
</html>
