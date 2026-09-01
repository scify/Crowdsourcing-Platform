<aside class="bo-sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="backofficeSidebar"
       aria-label="{{ __('menu.projects') }}">
    <div class="offcanvas-header d-lg-none">
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas"
                data-bs-target="#backofficeSidebar" aria-label="Close"></button>
    </div>
    <nav class="offcanvas-body d-lg-block p-0">
        <ul class="nav flex-column" role="menu">
            @can("manage-platform-content")
                <li class="nav-header">{{ __('menu.projects') }}</li>

                <li class="nav-item {{UrlMatchesMenuItem('projects.index')}}">
                    <a class="nav-link" href="{{ route('projects.index') }}"><i
                                class="nav-icon fa fa-list"></i>
                        <p>{{ __('menu.see_all_projects') }}</p></a>
                </li>
                <li class="nav-item {{UrlMatchesMenuItem('projects.create')}}">
                    <a class="nav-link" href="{{ route('projects.create') }}"><i
                                class="nav-icon fa fa-plus"></i>
                        <p>{{ __('menu.create_new_project') }}</p></a>
                </li>
                <li class="nav-header mt-5">{{ __('menu.questionnaires') }}</li>
                <li class="nav-item {{UrlMatchesMenuItem("questionnaires.all")}}">
                    <a class="nav-link" href="{{ route('questionnaires.all') }}"><i
                                class="nav-icon fa fa-list"></i>
                        <p>{{ __('menu.see_all_questionnaires') }}</p></a>
                </li>
                <li class="nav-item {{UrlMatchesMenuItem("questionnaires.reports")}}">
                    <a class="nav-link" href="{{ route('questionnaires.reports') }}"><i
                                class="nav-icon fa fa-question-circle"></i>
                        <p>{{ __('menu.responses') }}</p></a>
                </li>
                <li class="nav-header mt-5">{{ __('menu.problems') }}</li>
                <li class="nav-item {{UrlMatchesMenuItem("problems.index")}}">
                    <a class="nav-link" href="{{ route('problems.index') }}"><i
                                class="nav-icon fa fa-list"></i>
                        <p>{{ __('menu.see_all_problems') }}</p></a>
                </li>
                <li class="nav-item {{UrlMatchesMenuItem("problems.create")}}">
                    <a class="nav-link" href="{{ route('problems.create') }}"><i
                                class="nav-icon fa fa-plus"></i>
                        <p>{{ __('menu.create_new_problem') }}</p></a>
                </li>
                <li class="nav-header mt-5">{{ __('menu.solutions') }}</li>
                <li class="nav-item {{UrlMatchesMenuItem("solutions.index")}}">
                    <a class="nav-link" href="{{ route('solutions.index') }}"><i
                                class="nav-icon fa fa-list"></i>
                        <p>{{ __('menu.see_all_solutions') }}</p></a>
                </li>
            @endcan
            @can("manage-users")
                <li class="nav-header mt-5">{{ __('menu.platform_management') }}</li>
                <li class="nav-item {{UrlMatchesMenuItem("manage-users")}}">
                    <a class="nav-link" href="{{ route("manage-users") }}"><i
                                class="nav-icon fa fa-users"></i>
                        <p>Manage Users</p></a>
                </li>
                <li class="nav-item {{UrlMatchesMenuItem("mailchimp-integration.get")}}">
                    <a class="nav-link" href="{{ route('mailchimp-integration.get') }}"><i
                                class="nav-icon fa fa-envelope"></i>
                        <p>MailChimp</p></a>
                </li>
            @endcan
        </ul>
    </nav>
</aside>
