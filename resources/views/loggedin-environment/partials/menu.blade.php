@include("loggedin-environment.partials.header-controls")

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('home')}}" class="brand-link">
        <img loading="lazy" src="{{ asset('images/projects/' . config('app.installation_resources_dir') . '/logo_menu.png') }}"
             alt="Main Logo" class="brand-image">
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-header"> {{ __("menu.main_navigation") }}</li>
                <li class="nav-item {{ UrlMatchesMenuItem("my-dashboard")}}">
                    <a class="nav-link" href="{{route("my-dashboard")}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __("menu.my_dashboard") }}</p>

                    </a>
                </li>
                <li class="nav-item {{ UrlMatchesMenuItem("my-account")}}">
                    <a class="nav-link" href="{{route("my-account")}}">
                        <i class="nav-icon fa fa-user"></i>
                        <p>{{ __("menu.my_account") }}</p>

                    </a>
                </li>

                @if($userHasContributedToAProject)
                    <li class="nav-item {{ UrlMatchesMenuItem("myHistory")}}">
                        <a class="nav-link" href="{{route("myHistory")}}">
                            <i class="nav-icon fa fa-history"></i>
                            <p>{{ __("menu.my_history") }}</p>
                        </a>
                    </li>
                @endif
                @can("manage-crowd-sourcing-projects")
                    <li class="nav-header">CONTENT MANAGEMENT</li>

                    <li class="nav-item {{UrlMatchesMenuItem('projects')}}">
                        <a class="nav-link" href="{{ route('projects.index') }}"><i
                                    class="nav-icon fa fa-list "></i>
                            <p>See all Projects</p></a>
                    </li>
                    <li class="nav-item {{UrlMatchesMenuItem('projects/create')}}">
                        <a class="nav-link" href="{{ route('projects.create') }}"><i
                                    class="nav-icon fa fa-plus "></i>
                            <p>Create new Project</p></a>
                    </li>
                    <li class="nav-item {{UrlMatchesMenuItem("questionnaires")}}">
                        <a class="nav-link" href="{{ route('questionnaires.all') }}"><i
                                    class="nav-icon fa fa-question-circle "></i>
                            <p>Questionnaires</p></a>
                    </li>
                @endcan
                @can("manage-platform")
                    <li class="nav-header">COMMUNICATION MANAGEMENT</li>

                    <li class="nav-item {{UrlMatchesMenuItem("communication/mailchimp")}}">
                        <a class="nav-link" href="{{ route('mailchimp-integration') }}"><i
                                    class="nav-icon fa fa-envelope"></i>
                            <p>MailChimp Integration</p></a>
                    </li>
                @endcan
                @can("manage-users")
                    <li class="nav-header">PLATFORM MANAGEMENT</li>

                    <li class="nav-item {{UrlMatchesMenuItem("admin/manage-users")}}">
                        <a class="nav-link" href="{{ url("admin/manage-users") }}"><i
                                    class="nav-icon fa fa-users"></i>
                            <p>Manage Users</p></a>
                    </li>
                @endcan
            </ul>
        </nav>
    </div>
</aside>
