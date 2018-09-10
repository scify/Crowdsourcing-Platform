<header class="main-header">
    <!-- Logo -->
    <span class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><a href="/"><img style="" src="{{asset("images/ecas_logo_200.png")}}"></a></span>
        <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><a href="/"><img src="{{asset("images/ecas_logo_200.png")}}"></a></span></span>
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


            {{--  <li class="{{ UrlMatchesMenuItem("contribute")}}">
                  <a href="{{url("contribute")}}">
                      <i class="fa fa-users"></i> <span>Contribute</span>
                  </a>
              </li>--}}

            <li class="{{ UrlMatchesMenuItem("my-account")}}">
                <a href="{{url("my-account")}}">
                    <i class="fa fa-user"></i> <span>My Account</span>

                </a>
            </li>

            @if($userHasContributedToAProject)
                <li class="{{ UrlMatchesMenuItem("myContributions")}}">
                    <a href="{{route("myContributions")}}">
                        <i class="fa fa-trophy"></i> <span>My Contributions</span>
                    </a>
                </li>
            @endif
            @can("manage-crowd-sourcing-projects")
                <li class="header">CONTENT MANAGEMENT</li>

                <li class="{{UrlMatchesMenuItem("project/1/edit")}}">
                    <a href="{{ route('editProject', ['id' => 1]) }}"><i
                                class="fa fa-file "></i><span>Edit Fair EU Page</span></a>
                </li>
                <li class="{{UrlMatchesMenuItem("project/1/questionnaire")}}">
                    <a href="{{ route('manageQuestionnaires', ['id' => 1]) }}"><i
                                class="fa fa-question-circle "></i><span>Manage
                            Questionnaires</span></a>
                </li>
                <li class="{{UrlMatchesMenuItem("project/1/reports")}}">
                    <a href="{{ route('reports', ['id' => 1]) }}"><i
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
