@if (Auth::check())
<li>
    <a href="/my-dashboard">DASHBOARD</a>
</li>
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        @if (Auth::user()->avatar)
        <img src="{{ Auth::user()->avatar}}" class="user-image" >
        @endif
        <span class="hidden-xs">{{Auth::user()->nickname}}</span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            @if (Auth::user()->avatar)
            <img src="{{Auth::user()->avatar}}" class="img-circle">
            @endif
            <p>
                {{ Auth::user()->name }} {{ Auth::user()->nickname }}
                <small>Member since   {{ Auth::user()->created_at }}</small>
            </p>
        </li>

        <li class="user-footer">
            <div class="pull-left">
                <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
            </div>
            <div class="pull-right">
                <a id="log-out" href="{{ route('logout') }}"
                   class="btn btn-default btn-flat"
                   onclick="e">Sign out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{--                                {{ csrf_field() }}--}}
                </form>
            </div>
        </li>
    </ul>
</li>
@else
<li>
    <a href="/login">LOGIN</a>
</li>
<li>
    <a href="/register">REGISTER</a>
</li>
@endif