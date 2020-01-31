<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top navbar-default navbar-fixed-top">
    @if (App::environment('staging'))
        <div class="staging-warning">
            <p>~~~WARING: STAGING ENVIRONMENT~~~</p>
        </div>
    @endif
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <img alt="ECAS" src="{{asset('images/projects/fair-eu/ecas_logo.png')}}">
            </a>
            <button type="button" class="navbar-toggle collapsed" data-widget="collapse"
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
