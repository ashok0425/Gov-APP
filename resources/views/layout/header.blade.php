<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle d-flex">
        <i class="hamburger align-self-center"></i>
    </a>
    {{-- fetching all pending order --}}


  <div class="navbar-collapse collapse">
    <ul class="navbar-nav navbar-align">


      <li class="nav-item dropdown">
                <a
                    class="nav-link dropdown-toggle d-none d-sm-inline-block"
                    href="#"
                    data-toggle="dropdown"
                >
                <i class="fas fa-user"></i>
                    <span class="text-dark">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="align-middle mr-1" data-feather="user"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="fas fa-power-off"></i>
                        Log out
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
