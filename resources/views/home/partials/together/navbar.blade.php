<div @if (App::environment('staging')) class="header-margin-top" @endif>
    <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light fixed-top navbar-default navbar-fixed-top m-0">
        <a class="navbar-brand" href="#">
            <img alt="Together" src="{{asset('images/projects/together/logo.png')}}">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#top-menu-content"
                aria-controls="top-menu-content" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse pull-right" id="top-menu-content">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#about">ABOUT US</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#features">FEATURES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#projects">WHAT ARE WE CROWDSOURCING?</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#past-projects">PAST PROJECTS</a>
                </li>
                @include("partials.login-menu-options")
            </ul>
        </div>
    </nav>
</div>
