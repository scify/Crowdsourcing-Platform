<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.ico') }}"/>
    <title>@yield('title_prefix', 'ECAS Crowdsourcing Platform') @yield('title_postfix', '')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/skins/skin-blue.min.css')}} ">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="{{ asset('dist/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/sweetalert.css') }}">
    <link href="{{asset('dist/css/survey.css')}}" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('dist/css/landing-page.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/crowdsourcing-landingpage.css') }}">

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
                        <img alt="ECAS" src="{{asset('images/ecas_logo.png')}}">
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
                            <a href="#features">FEATURES</a>
                        </li>
                        <li>
                            <a href="#projects">PROJECTS</a>
                        </li>
                        <li>
                            <a href="/login">LOGIN</a>
                        </li>
                        <li>
                            <a href="/register">REGISTER</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<section id="motto">
    @include('crowdsourcing-landingpage.partials.motto')
</section>
<section id="features">
    @include('crowdsourcing-landingpage.partials.features')
</section>
<section id="projects">
    @include('crowdsourcing-landingpage.partials.projects')
</section>
<footer>
    <div class="row" id="sitemap">
        <div class="col-sm-2 col-sm-offset-3">
            <div class="footer-grp">
                <h3>ECAS Crowdsourcing Platform</h3>
                <div>
                    <a href="#features">Features</a>
                </div>
                <div>
                    <a href="#projects">Projects</a>
                </div>
                <div>
                    <a href="/login">Login</a>
                </div>
                <div>
                    <a href="/register">Register</a>
                </div>
                <div>
                    <a href="https://ecas.org/about-us/" target="_blank">About us</a>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="footer-grp">
                <h3>Get in touch</h3>
                <div>
                    <b>Phone:</b> +32 (0) 2 548 04 90
                </div>
                <div>
                    <b>E-mail:</b> info(at)ecas.org
                </div>
                <div class="social-media">
                    <a href="https://www.facebook.com/pages/European-Citizen-Action-Service-ECAS/115314481819170?ref=hl"
                       title="Facebook" class="social-btn facebook" target="_blank"><span class="fa fa-facebook"></span>
                    </a>
                    <a href="https://plus.google.com/u/1/103643749839893160342" title="GooglePlus"
                       class="social-btn google-plus" target="_blank"><span class="fa fa-google-plus"></span>
                    </a>
                    <a href="https://www.linkedin.com/company/ecas-europe" title="LinkedIn" class="social-btn linkedin"
                       target="_blank"><span class="fa fa-linkedin"></span>
                    </a>
                    <a href="https://twitter.com/ecas_europe" title="Twitter" class="social-btn twitter"
                       target="_blank"><span class="fa fa-twitter"></span>
                    </a>
                    <a href="https://www.youtube.com/user/ECASBrussels/featured" title="Youtube"
                       class="social-btn youtube" target="_blank"><span class="fa fa-youtube-play"></span>
                    </a>
                    <a href="https://ecas.org/feed/" title="RSS" class="social-btn rss" target="_blank"><span
                                class="fa fa-rss"></span>
                    </a>
                </div>
            </div>
            <div class="footer-grp">
                <h3>Support</h3>
                <div>
                    <a href="https://ecas.org/privacy-policy/" target="_blank">Privacy Policy</a>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <img class="footer-logo" src="{{asset('images/ecas_logo.png')}}" alt="ecas logo">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="lower-footer">
                Copyright &copy; {{ date("Y") }} <a target=" _blank"
                                                    href="https://ecas.org">ECAS.org</a>
                All rights reserved.
            </div>
        </div>
    </div>
</footer>
<div class="loader-wrapper hidden">
    <img src="{{asset('images/loading.gif')}}" alt="loading image">
</div>
@include('partials.footer-scripts')
</body>
</html>
