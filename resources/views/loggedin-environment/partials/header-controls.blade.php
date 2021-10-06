<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Sidebar toggle button-->
    <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
    </ul>

    <ul class="navbar-nav ml-auto">

        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                @if (Auth::user()->avatar)
                    <img loading="lazy" src="{{ Auth::user()->avatar}}" class="user-image">
                @endif
                <span class="hidden-xs">{{Auth::user()->nickname}}</span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    @if (Auth::user()->avatar)
                        <img loading="lazy" src="{{Auth::user()->avatar}}" class="img-circle"">
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
        </li>
    </ul>
</nav>
