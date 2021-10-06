<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('partials.favicons')
    <title>@yield('title_prefix', config('app.name')) @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="canonical" href="{{url('/')}}">
    @include('home.partials.' . config('app.installation_resources_dir') . '.head-meta')
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{ mix('dist/css/common.css') }}">
    <link rel="stylesheet" href="{{ mix('dist/css/landing-page.css') }}">
    <link rel="stylesheet" href="{{ mix('dist/css/home.css') }}">
    @stack('css')
        <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @include('analytics')
</head>
<body class="container-fluid">
@if (App::environment('staging'))
    <div class="row mb-3 fixed-top">
        <div class="col p-0">
            <div class="sticky-top w-100 staging-warning py-2 text-center">
                <h5 class="m-0">~~~ WARNING: STAGING ENVIRONMENT ~~~</h5>
            </div>
        </div>
    </div>
@endif
<div class="row">
    <div class="col-12">
        @include('home.partials.' . config('app.installation_resources_dir') . '.navbar')
    </div>
</div>
@if(session('flash_message_success'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> {{ session('flash_message_success') }}</h4>
    </div>
@endif
<div id="app">
    @yield('content')
</div>

<footer>
    @include('home.partials.' . config('app.installation_resources_dir') . '.footer')
</footer>
<div class="loader-wrapper hidden">
    <img loading="lazy" src="{{asset('images/loading.gif')}}" alt="loading image">
</div>
<script>
    window.Laravel = {!! json_encode([
                'baseUrl' => url('/'),
                'routes' => collect(\Route::getRoutes())->mapWithKeys(function ($route) { return [$route->getName() => $route->uri()]; })
            ]) !!};
</script>
@include('partials.footer-scripts')

<script src="{{ mix('dist/js/home.js') }}"></script>

</body>
</html>
