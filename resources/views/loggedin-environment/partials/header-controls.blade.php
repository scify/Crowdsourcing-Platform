<nav class="main-header  navbar navbar-expand navbar-white navbar-light">
    <!-- Sidebar toggle button-->
    <ul class="navbar-nav">
        <li class="nav-item"> <img loading="lazy" height="40" src="{{ asset('images/projects/' . config('app.installation_resources_dir') . '/logo_menu.png') }}"
                                   alt="Main Logo" class="brand-image"></li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item {{ UrlMatchesMenuItem("my-dashboard")}}">
            <a class="nav-link" href="{{route("my-dashboard")}}"> {{ __("menu.my_dashboard") }} </a>
        </li>
        <li class="nav-item {{ UrlMatchesMenuItem("my-account")}}">
            <a class="nav-link" href="{{route("my-account")}}"> {{ __("menu.my_account_2") }} </a>
        </li>
        @if($userHasContributedToAProject)
            <li class="nav-item {{ UrlMatchesMenuItem("myHistory")}}">
                <a class="nav-link" href="{{route("myHistory")}}"> {{ __("menu.my_history") }} </a>
            </li>
        @endif
        <li class="nav-item dropdown user user-menu">
            <a class="nav-link" href="#" class="dropdown-toggle" data-toggle="dropdown">
                @if (Auth::user()->avatar)
                    <img loading="lazy" src="{{ Auth::user()->avatar}}" class="user-image">
                @endif
                <span class="hidden-xs">{{Auth::user()->nickname}}</span>
                <i class="fas fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    @if (Auth::user()->avatar)
                        <img loading="lazy" src="{{Auth::user()->avatar}}" class="img-circle">
                    @endif
                    <p>
                        {{ Auth::user()->name }} {{ Auth::user()->nickname }}
                        <small>Member since {{ Auth::user()->created_at }}</small>
                    </p>
                </li>

                <li class="user-footer">
                    <div class="pull-right">
                        <a id="log-out" href="{{ route('logout') }}"
                           class="btn btn-default btn-flat">Sign out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            @include("partials.language-selector")
        </li>
    </ul>
</nav>
