<div @if (App::environment('staging')) class="header-margin-top" @endif>
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img alt="ECAS" src="{{asset('images/projects/eicon/logo.png')}}">
                </a>
                <button type="button" class="navbar-toggle" data-widget="collapse"
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
                        <a href="#about">ABOUT US</a>
                    </li>
                    <li>
                        <a href="#features">FEATURES</a>
                    </li>
                    <li>
                        <a href="#projects">WHAT ARE WE CROWDSOURCING?</a>
                    </li>
                    @include("partials.login-menu-options")
                </ul>
            </div>
        </div>
    </nav>
</div>
