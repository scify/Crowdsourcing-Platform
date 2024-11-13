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
        <a class="dropdown-item text-center"
           href="{{ route('my-account') }}"> {{ __('menu.my_account') }} </a>
        <div class="dropdown-divider"></div>
        <a id="log-out" href="javascript:void(0);"
           class="dropdown-item text-center">{{ __('menu.sign_out') }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    @include('partials.language-selector')
</li>