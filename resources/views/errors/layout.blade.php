<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('dist/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/errors.css') }}">
</head>
<body class="hold-transition background-page @yield('body_class')">
@if (App::environment('staging'))
    <div class="staging-warning">
        <p>~~~WARING: STAGING ENVIRONMENT~~~</p>
    </div>
@endif
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="code">
            @yield('code')
        </div>
        <div class="title">
            @yield('message')
        </div>
    </div>
</div>
</body>
</html>
