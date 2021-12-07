@if (Auth::check())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('my-dashboard') }}"> {{ __("menu.dashboard") }} </a>
    </li>

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
                       class="btn btn-default btn-flat">{{ __("menu.sign_out")}}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </li>

@else
    <li class="nav-item">
        <a class="nav-link" href="{{route("login")}}">{{ __("menu.login")}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route("register")}}">{{ __("menu.register")}}</a>
    </li>
@endif
@include('partials.language-selector')
