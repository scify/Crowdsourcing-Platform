<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('partials.favicons')
    <title>@yield('title_prefix', config('app.name')) @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=10, user-scalable=yes" name="viewport">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
    @vite('resources/assets/sass/common.scss')
    @vite('resources/assets/sass/auth.scss')
    @stack('css')

    @include('analytics')
</head>
<body class="hold-transition background-page @yield('body_class') container-fluid"
      style="background-image: url('{{ asset('images/active_participation.webp') }}');">
@include('partials.staging-indicator')
<div id="app" class="row h-100 justify-content-center align-items-center">
    <div class="login-box col-xl-4 col-lg-5 col-md-9 col-sm-10">
        <div class="login-box-body px-md-5 px-sm-2 py-5 w-100">
            @yield('auth-form')
        </div>
    </div>
</div>

@include("partials.footer-scripts")

@stack('scripts')

</body>
</html>
