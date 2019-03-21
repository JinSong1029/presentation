<nav role="navigation" class="navbar navbar-default icc-navbar">
    <div class="icc-logo">
        <a class="" href="/"><img src="{{ asset('images/wm-logo.jpeg') }}" /></a>
        <ul class="icc-underlogo-menu">
            {{--<li><a href="{{ $CANONICAL_DASHBOARD_URL }}">Dashboard</a></li>--}}
            {{--<li><a href="{{ $CANONICAL_FRONTEND_URL }}">Site</a></li>--}}
        </ul>
    </div>
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle collapsed">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    @if (!Auth::guest())
        <div class="icc-user-details text-right">Welcome <strong>{{ $currentUser->name }}</strong> <a class="" href="{{ url('auth/logout') }}">Sign out</a></div>
    @endif
    <h2 class="text-right">Presentation dashboard</h2>
    <div id="navbarCollapse" class="collapse navbar-collapse navbar-right">
        <ul class='nav navbar-nav navbar-right icc-nav-menu'>
            <li @if(Request::is('presentations/select'))class="active"@endif><a href="{{ url('presentations/select') }}">Select presentation</a></li>
            <li @if(Request::is('presentations/create'))class="active"@endif><a href="{{ url('presentations/create') }}">Create presentation</a></li>
            <li @if(Request::is('presentations'))class="active"@endif><a href="{{ url('presentations') }}">Current presentations</a></li>
            <li @if(Request::is('presentations/archived'))class="active"@endif><a href="{{ url('presentations/archived') }}">Archived presentations</a></li>
            <li @if(Request::is('presentations/keys'))class="active"@endif><a href="{{ url('presentations/keys') }}">Client keys</a></li>
            @if($currentUser->hasRole('admin'))
            <li @if(Request::is('*users*'))class="active"@endif><a href="{{ url('users') }}">Manage users</a></li>
            @endif
            <li @if(Request::is('*defaults*'))class="active"@endif><a href="{{ url('defaults') }}">Defaults</a></li>
        </ul>
    </div>
</nav>