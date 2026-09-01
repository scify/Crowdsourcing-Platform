<nav class="bo-topbar navbar navbar-expand-lg">

    @canany(['moderate-content-by-users'])
        {{-- Desktop: collapse-to-icons toggle --}}
        <a id="sidebar-menu-toggler" class="nav-link p-0 d-none d-lg-inline-block me-3" href="#"
           role="button" aria-label="Toggle sidebar"><i class="fa fa-chevron-left"></i></a>
        {{-- Mobile: offcanvas toggle --}}
        <button class="btn d-lg-none me-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#backofficeSidebar" aria-controls="backofficeSidebar"
                aria-label="Open menu"><i class="fa fa-bars"></i></button>
    @endcanany

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}"> {{ __('menu.home') }} </a>
            </li>
            <li class="nav-item {{ UrlMatchesMenuItem('my-dashboard') }}">
                <a class="nav-link" href="{{ route('my-dashboard') }}"> {{ __('menu.my_dashboard') }} </a>
            </li>
            <li class="nav-item {{ UrlMatchesMenuItem('my-contributions') }}">
                <a class="nav-link"
                   href="{{ route('my-contributions') }}"> {{ __('my-contributions.my_contributions') }} </a>
            </li>
            @include('partials.user-actions-header-dropdown')
            @include('partials.language-selector')
        </ul>
    </div>
</nav>
