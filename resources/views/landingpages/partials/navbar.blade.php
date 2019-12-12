<nav class="navbar navbar-default navbar-fixed-top">
    @if (App::environment('staging'))
        <div class="staging-warning">
            <p>~~~WARING: STAGING ENVIRONMENT~~~</p>
        </div>
    @endif
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