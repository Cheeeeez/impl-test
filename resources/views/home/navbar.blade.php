<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a style="width: 170px" class="navbar-brand" href="index.html">Start Bootstrap</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
            class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    @yield('search')
    <!-- Navbar-->
    <ul style="margin-right: 0px !important; margin-left: auto !important" class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false"><img src="{{Auth::user()->avatar}}" width="50px"
                    style="border-radius: 50%" alt="Avatar"></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
            </div>
        </li>
    </ul>
</nav>
