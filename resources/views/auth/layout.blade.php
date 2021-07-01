<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('partials.favicons')
    <title>@yield('title_prefix', config('app.name')) @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{ mix('dist/css/common.css') }}">
    <link rel="stylesheet" href="{{ mix('dist/css/auth.css') }}">
    @stack('css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @if (App::environment('production'))
        @include('analytics')
    @endif
</head>
<body class="hold-transition background-page @yield('body_class')" style="background-image: url('{{ asset('images/active_participation.png') }}');">
@if (App::environment('staging'))
    <div class="sticky-top w-100 staging-warning py-2 text-center">
        <h5 class="m-0">~~~ WARNING: STAGING ENVIRONMENT ~~~</h5>
    </div>
@endif
<div id="app" class="login-box row h-100 justify-content-center align-items-center">
    <div class="login-box-body p-5 col-12">
        @yield('auth-form')
    </div>
</div>

@include("partials.footer-scripts")

@stack('scripts')

</body>
</html>
