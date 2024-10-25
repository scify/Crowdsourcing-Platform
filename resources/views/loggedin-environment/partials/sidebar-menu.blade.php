<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                @can("manage-platform-content")
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
                @endcan
                @can("moderate-content-by-users")
                    <li class="nav-item {{UrlMatchesMenuItem("questionnaires")}}">
                        <a class="nav-link" href="{{ route('questionnaires.all') }}"><i
                                    class="nav-icon fa fa-question-circle "></i>
                            <p>Questionnaires</p></a>
                    </li>
                    <li class="nav-item {{UrlMatchesMenuItem("questionnaires/reports")}}">
                        <a class="nav-link" href="{{ route('questionnaires.reports') }}"><i
                                    class="nav-icon fa fa-question-circle "></i>
                            <p>Responses</p></a>
                    </li>
                @endcan
                @can("manage-platform")
                    <li class="nav-header">COMMUNICATION</li>

                    <li class="nav-item {{UrlMatchesMenuItem("communication/mailchimp")}}">
                        <a class="nav-link" href="{{ route('mailchimp-integration.get') }}"><i
                                    class="nav-icon fa fa-envelope"></i>
                            <p>MailChimp</p></a>
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
