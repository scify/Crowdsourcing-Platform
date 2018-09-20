<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.ico') }}"/>
    <link rel="shortcut icon" href="https://ecas.org/wp-content/uploads/2015/05/favicon_32.png">
    <link rel="apple-touch-icon-precomposed" href="https://ecas.org/wp-content/uploads/2015/05/favicon_57.png">
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="https://ecas.org/wp-content/uploads/2015/05/favicon_76.png">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="https://ecas.org/wp-content/uploads/2015/05/favicon_120.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://ecas.org/wp-content/uploads/2015/05/favicon_152.png">
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
