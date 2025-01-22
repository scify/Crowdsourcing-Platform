<div @if (App::environment('staging')) class="header-margin-top" @endif>
    <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light fixed-top navbar-default navbar-fixed-top m-0"
         style="z-index: 100000;">
        <a class="navbar-brand" href="{{route('home', ['locale' => app()->getLocale()])}}">
            <img loading="lazy" alt="ECAS" src="{{ $logoPath }}">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#top-menu-content"
                aria-controls="top-menu-content" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse pull-right" id="top-menu-content">
            <ul class="nav navbar-nav ml-auto">
                @if(Route::currentRouteName() !== 'home')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home', ['locale' => app()->getLocale()]) }}">
                            {{ __('common.home_page') }}
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home', ['locale' => app()->getLocale()]) }}#about">
                        {{ __('common.about_us') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home', ['locale' => app()->getLocale()]) }}#features">
                        {{ __('common.features') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home', ['locale' => app()->getLocale()]) }}#projects">
                        {{ __('common.crowd_sourcing_campaigns') }}
                    </a>
                </li>
                @guest
                    <!-- Guest links here -->
                @endguest
                @if(!isset($onErrorPage))
                    @include("partials.login-menu-options")
                @endif
                @include("partials.language-selector")
            </ul>
        </div>
    </nav>
</div>