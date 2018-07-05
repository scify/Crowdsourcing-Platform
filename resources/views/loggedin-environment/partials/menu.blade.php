<header class="main-header">
    <!-- Logo -->
    <span class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img style="" src="{{asset("images/ecas_logo_200.png")}}"></span>
        <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="{{asset("images/ecas_logo_200.png")}}"></span></span>
    </span>
    @include("loggedin-environment.partials.header-controls")
</header>

<aside class="main-sidebar">
    <section class="sidebar">

        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            @can("view-my-profile")
                <li class="{{ UrlMatchesMenuItem("my-profile")}}">
                    <a href="{{url("my-profile")}}">
                        <i class="fa fa-user"></i> <span>My profile</span>
                        <span class="pull-right-container"></span>
                    </a>
                </li>
            @endcan
            @can("manage-users")
                <li class="treeview {{ UrlMatchesMenuItem("admin*") }} ">
                    <a href="javascript:void(0)">
                        <i class="fa fa-wrench"></i>
                        <span>Platform Admin</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{UrlMatchesMenuItem("admin/manage-users")}}">
                            <a href="{{ url("admin/manage-users") }}"><i
                                        class="fa fa-users"></i> Manage Users</a></li>
                        @can("manage-crowd-sourcing-projects")
                            <li class="{{UrlMatchesMenuItem("admin/manage-projects")}}">
                                <a href="{{ url("admin/manage-projects") }}"><i
                                            class="fas fa-list-ul"></i> Manage Projects</a></li>
                        @endcan
                    </ul>
                </li>

            @endcan

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
