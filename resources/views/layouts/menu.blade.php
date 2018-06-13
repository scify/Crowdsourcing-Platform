<header class="main-header">
    <!-- Logo -->
    <span class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">CsP</span>
        <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">Crowdsourcing Platform</span></span>
    </span>
    @include("layouts.header-controls")
</header>

<aside class="main-sidebar">
    <section class="sidebar">

        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            @can("manage-platform")
                <li class="{{ UrlMatchesMenuItem("/platform-admin/manage-payments")}}">
                    <a href="{{url("/platform-admin/manage-payments")}}">
                        <i class="fa fa-user"></i> <span>Manage Payments</span>
                        <span class="pull-right-container"> </span>
                    </a>
                </li>
            @endcan
            @can("view-my-profile")
                <li class="{{ UrlMatchesMenuItem("my-profile")}}">
                    <a href="{{url("my-profile")}}">
                        <i class="fa fa-user"></i> <span>My profile</span>
                        <span class="pull-right-container">
                </span>
                    </a>
                </li>
            @endcan
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
