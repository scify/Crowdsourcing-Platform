<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.ico') }}"/>
    <title>@yield('title_prefix', $viewModel->project->name) @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
    <link rel="canonical" href="{{url('/')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="ECAS, crowdsourcing, Europe, EU, democracy, {{$viewModel->project->name}}" >
    <meta name="description" content="{{$viewModel->project->motto}}">
    <!--FACEBOOK-->
    <meta property="og:title" content="ECAS Crowdsourcing Platform" >
    <meta property="og:site_name" content="ECAS Crowdsourcing Platform">
    <meta property="og:url" content="{{url($viewModel->project->slug)}}" >
    <meta property="og:description" content="Are you an EU citizen living abroad? Take part in our questionnaire!" >
    <meta property="og:image" content="{{asset("images/active_participation.png")}}" >
    <meta property="og:type" content="website" >
    <meta property="og:locale" content="en-US" >
    <!--TWITTER-->
    <meta property="twitter:card" content="summary" >
    <meta property="twitter:title" content="EU mobile citizen?" >
    <meta property="twitter:description" content="Help us tackle the obstacles" >
    <meta property="twitter:creator" content="ecas_europe" >
    <meta property="twitter:url" content="{{url($viewModel->project->slug)}}" >
    <meta property="twitter:image" content="{{asset("images/active_participation.png")}}" >
    <meta property="twitter:image:alt" content="crowdsourcing" >
    <!--GOOGLE+-->
    <link rel="author" href="https://plus.google.com/u/0/+ECASBrussels">

    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/skins/skin-blue.min.css')}} ">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{ asset('dist/css/common.css') }}?{{env("APP_VERSION")}}">
    <link rel="stylesheet" href="{{ asset('dist/css/sweetalert.css') }}">
    <link href="{{asset('dist/css/survey.css')}}" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('dist/css/landing-page.css') }}?{{env("APP_VERSION")}}">

    <link rel="shortcut icon" href="https://ecas.org/wp-content/uploads/2015/05/favicon_32.png">
    <link rel="apple-touch-icon-precomposed" href="https://ecas.org/wp-content/uploads/2015/05/favicon_57.png">
    <link rel="apple-touch-icon-precomposed" sizes="76x76"
          href="https://ecas.org/wp-content/uploads/2015/05/favicon_76.png">
    <link rel="apple-touch-icon-precomposed" sizes="120x120"
          href="https://ecas.org/wp-content/uploads/2015/05/favicon_120.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="https://ecas.org/wp-content/uploads/2015/05/favicon_152.png">


    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="container-fluid">
<div class="row">
    <div class="col-md-12">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">
                        <img alt="{{$viewModel->project->name}}" src="{{asset($viewModel->project->logo_path)}}">
                    </a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#top-menu-content">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse pull-right" id="top-menu-content">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#about">ABOUT</a>
                        </li>
                        @include("partials.login-menu-options")
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<section id="motto">
    @include('landingpages.partials.motto')
</section>
<section id="about">
    @include('landingpages.partials.about')
</section>

<section id="questionnaire">
    @include('landingpages.partials.questionnaire')
</section>

@if($viewModel->questionnaire)
    <section id="collective-goal">
        @include("landingpages.partials.goal-and-activity")
    </section>
@endif

<section id="newsletter">
    @include('partials.signup_to_newsletter')
</section>
<footer>
    <div class="container">

            {!! $viewModel->project->footer !!}

    </div>
</footer>

<div id="pyro" class="">
    <div class="before"></div>
    <div class="after"></div>
</div>

<div class="loader-wrapper hidden">
    <img src="{{asset('images/loading.gif')}}" alt="loading image">
</div>
@include('partials.footer-scripts')
<script src="{{asset('dist/js/landingPage.js')}}?{{env("APP_VERSION")}}"></script>
</body>
</html>
