<div @if (App::environment('staging')) class="header-margin-top" @endif>
    <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light fixed-top navbar-default navbar-fixed-top m-0"
         style="z-index: 100000;">
        <a class="navbar-brand" href="{{route('home', ['locale' => app()->getLocale()])}}">
            <img loading="lazy" alt="homepage"
                 src="{{asset('images/projects/' . config('app.installation_resources_dir') . '/logo_menu.png')}}">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#top-menu-content"
                aria-controls="top-menu-content" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse pull-right" id="top-menu-content">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}"> {{ __('menu.home') }} </a>
                </li>
                @if(isset($viewModel->project))
                    <li class="nav-item">
                        <a class="nav-link"
                           href="/{{ app()->getLocale() }}/{{ $viewModel->project->slug }}">{{ __("menu.the_campaign")}}</a>
                    </li>
                @endif
                @if(!isset($onErrorPage))
                    @include("partials.login-menu-options")
                @endif
                @include("partials.language-selector")
            </ul>
        </div>
    </nav>
</div>
