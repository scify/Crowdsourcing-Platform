<div @if (App::environment('staging')) class="header-margin-top" @endif>
    <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light fixed-top navbar-default navbar-fixed-top m-0"
         style="z-index: 100000;">
        <a class="navbar-brand" href="#">
            <img loading="lazy" alt="ECAS" src="{{asset('images/projects/ecas/ecas_logo_scaled.png')}}">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#top-menu-content"
                aria-controls="top-menu-content" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse pull-right" id="top-menu-content">
            <ul class="nav navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="#about">ABOUT US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">FEATURES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#projects">WHAT ARE WE CROWDSOURCING?</a>
                    </li>
                @endguest
                @include("partials.login-menu-options")
            </ul>
        </div>
    </nav>
</div>
