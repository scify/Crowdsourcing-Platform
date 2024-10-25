<nav class="main-header navbar navbar-expand-lg navbar-white navbar-light">
    <!-- Sidebar toggle button-->
    @canany(['moderate-content-by-users'])
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link pl-0" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>
    @endcanany

    <!-- Burger menu button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="navbar-brand">
                    <img loading="lazy" height="40"
                         src="{{ asset('images/projects/' . config('app.installation_resources_dir') . '/logo_menu.png') }}"
                         alt="Main Logo" class="brand-image">
                </a>
            </li>
            <li class="nav-item {{ UrlMatchesMenuItem('my-dashboard') }}">
                <a class="nav-link" href="{{ route('my-dashboard') }}"> {{ __('menu.my_dashboard') }} </a>
            </li>
            @if($userHasContributedToAProject)
                <li class="nav-item {{ UrlMatchesMenuItem('my-contributions') }}">
                    <a class="nav-link"
                       href="{{ route('my-contributions') }}"> {{ __('my-history.my_contributions') }} </a>
                </li>
            @endif
            <li class="nav-item dropdown user user-menu">
                <a class="nav-link dropdown-toggle" href="#" id="userMenu" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    @if (Auth::user()->avatar)
                        <img loading="lazy" src="{{ Auth::user()->avatar }}" class="user-image" alt="User Image">
                    @endif
                    <span class="hidden-xs">{{ Auth::user()->nickname }}</span>
                    <i class="fas fa-caret-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right py-2" aria-labelledby="userMenu">
                    <!-- User image -->
                    <div class="dropdown-item user-header text-center">
                        @if (Auth::user()->avatar)
                            <img loading="lazy" src="{{ Auth::user()->avatar }}" class="img-circle" alt="User Image">
                        @endif
                        <p>
                            {{ Auth::user()->name }} {{ Auth::user()->nickname }}
                            <small>Member since {{ Auth::user()->created_at }}</small>
                        </p>
                    </div>
                    <a class="dropdown-item text-center"
                       href="{{ route('my-account') }}"> {{ __('menu.my_account') }} </a>
                    <div class="dropdown-divider"></div>
                    <a id="log-out" href="{{ route('logout') }}"
                       class="dropdown-item text-center">{{ __('menu.sign_out') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                @include('partials.language-selector')
            </li>
        </ul>
    </div>
</nav>
