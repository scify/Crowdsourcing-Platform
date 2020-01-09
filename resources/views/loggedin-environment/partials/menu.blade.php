@inject('CrowdSourcingProjectManager', 'App\BusinessLogicLayer\CrowdSourcingProjectManager')

<header class="main-header">
    <!-- Logo -->
    <span class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><a href="/"><img style=""
                                                     src="{{ asset('images/projects/' . config('app.project_resources_dir') . '/logo_50.png') }}"></a></span>
        <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><a href="/"><img
                            src="{{ asset('images/projects/' . config('app.project_resources_dir') . '/logo_50.png') }}"></a></span></span>
    </span>
    @include("loggedin-environment.partials.header-controls")
</header>

<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ UrlMatchesMenuItem("my-dashboard")}}">
                <a href="{{url("my-dashboard")}}">
                    <i class="fa fa-dashboard"></i> <span>My Dashboard</span>

                </a>
            </li>

            <li class="{{ UrlMatchesMenuItem("my-account")}}">
                <a href="{{url("my-account")}}">
                    <i class="fa fa-user"></i> <span>My Account</span>

                </a>
            </li>

            @if($userHasContributedToAProject)
                <li class="{{ UrlMatchesMenuItem("myHistory")}}">
                    <a href="{{route("myHistory")}}">
                        <i class="fa fa-history"></i> <span>My History</span>
                    </a>
                </li>
            @endif
            @can("manage-crowd-sourcing-projects")
                <li class="header">CONTENT MANAGEMENT</li>

                <li class="{{UrlMatchesMenuItem('projects')}}">
                    <a href="{{ route('projects.index') }}"><i
                                class="fa fa-list "></i><span>See all Projects</span></a>
                </li>
                <li class="{{UrlMatchesMenuItem('projects/create')}}">
                    <a href="{{ route('projects.create') }}"><i
                                class="fa fa-plus "></i><span>Create new Project</span></a>
                </li>
                <li class="{{UrlMatchesMenuItem("project/" . DEFAULT_PROJECT_ID . "/questionnaires")}}">
                    <a href="{{ route('manageQuestionnaires', ['id' => DEFAULT_PROJECT_ID]) }}"><i
                                class="fa fa-question-circle "></i><span>Manage
                            Questionnaires</span></a>
                </li>
                <li class="{{UrlMatchesMenuItem("project/" . DEFAULT_PROJECT_ID . "/reports")}}">
                    <a href="{{ route('reports', ['id' => DEFAULT_PROJECT_ID]) }}"><i
                                class="fa fa-line-chart"></i><span>Reports</span></a>
                </li>
            @endcan
            @can("manage-platform")
                <li class="header">COMMUNICATION MANAGEMENT</li>

                <li class="{{UrlMatchesMenuItem("communication/mailchimp")}}">
                    <a href="{{ route('mailchimp-integration') }}"><i
                                class="fa fa-envelope"></i><span>MailChimp Integration</span></a>
                </li>
            @endcan
            @can("manage-users")
                <li class="header">PLATFORM MANAGEMENT</li>

                <li class="{{UrlMatchesMenuItem("admin/manage-users")}}">
                    <a href="{{ url("admin/manage-users") }}"><i
                                class="fa fa-users"></i><span>Manage Users</span></a>
                </li>
                {{-- <li class="treeview {{ UrlMatchesMenuItem("admin*") }} ">
                     <a href="javascript:void(0)">
                         <i class="fa fa-wrench"></i>
                         <span>Administration</span>
                         <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                     </a>
                     <ul class="treeview-menu">
                         <li class="{{UrlMatchesMenuItem("admin/manage-users")}}">
                             <a href="{{ url("admin/manage-users") }}"><i
                                         class="fa fa-users"></i> Manage Users</a></li>
                     </ul>
                 </li>--}}
            @endcan
        </ul>
    </section>
</aside>
