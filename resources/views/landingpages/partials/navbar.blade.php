<div @if (App::environment('staging')) class="header-margin-top" @endif>
    <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light fixed-top navbar-default navbar-fixed-top m-0"
         style="z-index: 100000;">
        @if(isset($viewModel->project) &&  isset($viewModel->project->external_url) && $viewModel->project->external_url !=null)
            <a class="navbar-brand" target="_blank" href="{{ $viewModel->project->external_url}}">
                <img loading="lazy" alt="{{$viewModel->project->name}}" src="{{asset($viewModel->project->logo_path)}}">
            </a>
        @else
            <a class="navbar-brand" href="{{ isset($viewModel->home_url) ? $viewModel->home_url : '#' }}">
                @if(isset($viewModel->project))
                    <img loading="lazy" alt="{{$viewModel->project->name}}" src="{{asset($viewModel->project->logo_path)}}">
                @endif
            </a>
        @endif

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#top-menu-content"
                aria-controls="top-menu-content" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse pull-right" id="top-menu-content">
            <ul class="nav navbar-nav ml-auto">
                @include("partials.login-menu-options")
            </ul>
        </div>
    </nav>
</div>
