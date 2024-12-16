<nav class="main-header navbar navbar-expand-lg navbar-white navbar-light">

    @canany(['moderate-content-by-users'])
        <!-- Sidebar toggle button-->
        <ul class="navbar-nav">
            <div class="sidebar-menu-toggler-container">
                <a id="sidebar-menu-toggler" class="nav-link p-0" data-widget="pushmenu" href="#"><i
                            class="fa fa-chevron-left"></i></a>
            </div>
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
