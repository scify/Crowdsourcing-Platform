<header class="main-header">
    <!-- Logo -->
    <span class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">CG</span>
        <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">CPinNG</span></span>
    </span>
    @include("layouts.header-controls")
</header>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->

        <!-- search form -->
    {{--    <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>--}}
    <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
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

            @can("create-or-edit-article")
                <li class="{{ UrlMatchesMenuItem("article/new")}}">
                    <a href="{{url("article/new")}}">
                        <i class="fa fa-plus"></i> <span>New Article</span>
                    </a>
                </li>
            @endcan

            @can("view-my-articles")
                <li class="{{ UrlMatchesMenuItem("article/my-list")}}">
                    <a href="{{url("/article/my-list")}}">
                        <i class="fa fa-files-o"></i> <span>My Articles</span>
                    </a>
                </li>
            @endcan

            @can("view-collaboration-requests")
                <li class="{{ UrlMatchesMenuItem("/collaborations/requests")}}">
                    <a href="{{url("/collaborations/requests")}}">
                        <i class="fa fa-users"></i> <span>My Collaboration Requests</span>
                        <span class="pull-right-container">
            {{--  <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>--}}
                </span>
                    </a>
                </li>
            @endcan

            @if ($selectedCms!=null)
                <li class="header">{{strtoupper($selectedCms->name)}}</li>
            @endif

            @can("view-blog-roll")
                <li class="{{ UrlMatchesMenuItem("blog-roll")}}">
                    <a href="{{url("blog-roll")}}">
                        <i class="fa fa-globe"></i> <span>Blog Roll</span>
                        <span class="pull-right-container">
                </span>
                    </a>
                </li>
            @endcan

            @can("view-edit-room")
                <li class="{{ UrlMatchesMenuItem("edit-room")}}">
                    <a href="{{url("edit-room")}}">
                        <i class="fa fa-edit"></i> <span>Edit Room</span>
                        <span class="pull-right-container">
                </span>
                    </a>
                </li>
            @endcan

            @can("view-chief-room")
                <li class="treeview {{UrlMatchesMenuItem("/chiefs") }} ">
                    <a href="javascript:void(0)">
                        <i class="fa fa-users"></i> <span>Chiefs</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{UrlMatchesMenuItem("chief-room")}}"><a href="{{url("chief-room")}}"><i
                                        class="fa fa-files-o"></i> Chief room</a></li>
                    </ul>
                </li>
            @endcan

            @can("manage-cms")
                <li class="treeview {{ UrlMatchesMenuItem("admin*") }} ">
                    <a href="javascript:void(0)">
                        <i class="fa fa-wrench"></i>
                        <span>CMS Admin</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{UrlMatchesMenuItem("admin/manage-users")}}">
                            <a href="{{ url("admin/manage-users") }}"><i
                                        class="fa fa-users"></i> Manage Users</a></li>
                        <li class="{{UrlMatchesMenuItem("admin/manage-legal-terms")}}"><a
                                    href="{{ url("admin/manage-legal-terms") }}"><i
                                        class="fa fa-file-text-o"></i> Manage Legal Terms</a></li>
                        <li class="{{UrlMatchesMenuItem("admin/manage-privacy-policy")}}"><a
                                    href="{{ url("admin/manage-privacy-policy") }}"><i
                                        class="fa fa-file-text-o"></i> Manage Privacy Policy</a></li>
                        <li class="{{UrlMatchesMenuItem("admin/manage-cms")}}"><a
                                    href="{{ url("admin/manage-cms") }}"><i
                                        class="fa fa-cogs"></i> Manage CMS Parameters</a></li>
                        <li class="{{UrlMatchesMenuItem("admin/manage-categories")}}"><a
                                    href="{{ url("admin/manage-categories") }}"><i
                                        class="fa fa-sitemap"></i> Manage Categories</a></li>


                    </ul>
                </li>
            @endcan

            <li class="header">BUY ARTICLES</li>

            <li class="{{UrlMatchesMenuItem("online-store")}}">
                <a href="{{url("/online-store") }}"><i class="fa fa-shopping-basket text-yellow"></i>
                    <span>Online store</span></a>
            </li>

            <li class="header">PUBLIC URLS</li>
            <li>
                <a href="{{url("web/news-central") }}" target="_blank"><i class="fa fa-globe text-aqua"></i> <span>NewsCentral</span></a>
            </li>
            @foreach ($cmsUserManages as $cms)
                @if($cms->id !=1) {{-- dont display newscentral since its already in the menu --}}
                <li><a href="{{url("web")."/".$cms->system_name }}" target="_blank"><i
                                class="fa fa-circle-o text-red"></i>
                        <span>{{ $cms->name}}</span></a></li>
                @endif
            @endforeach


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
