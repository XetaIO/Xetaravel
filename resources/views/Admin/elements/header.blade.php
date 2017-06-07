<header class="pos-f-t">
    <nav class="navbar navbar-toggleable-md navbar-dark bg-inverse">
        <button class="navbar-toggler hidden-md-up float-xs-right" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2" aria-expanded="false" aria-controls="exCollapsingNavbar2" aria-label="Toggle navigation"></button>
        <a class="navbar-brand float-xs-none float-md-left font-xeta text-white font-weight-bold" href="{{ route('page.index') }}">
            <img src="{{ asset('images/logo.svg') }}" width="25" height="25" class="d-inline-block align-middle" alt="Logo">
            Xetaravel
        </a>

      <div class="collapse navbar-toggleable-sm" id="exCollapsingNavbar2">

        @if (Auth::guest())
            <div class="float-sm-right">
                <a class="btn btn-header-register-login btn-outline-primary" href="{{ route('users.auth.register') }}">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Register
                </a>
                <a class="btn btn-header-register-login btn-outline-primary" href="{{ route('users.auth.login') }}">
                    <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                </a>
            </div>
        @else
            <div class="navbar-text btn-group float-md-right font-weight-bold">
                <a href="#" id="sidebar-trigger" class="nav-link">
                    {{ Auth::user()->username }}
                </a>
            </div>
            <span class="navbar-text navbar-hello-text text-white float-xs-left float-md-right font-weight-bold">
              Hello,&nbsp;
            </span>
        @endif


      </div>
    </nav>
</header>

<!-- Sidebar -->
@include('elements.sidebar')
