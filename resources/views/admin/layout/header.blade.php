<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle d-flex">
        <i class="hamburger align-self-center"></i>
    </a>
    {{-- fetching all pending order --}}

    @php
        $orders = DB::table('orders')
            ->where('status', 0)
            ->get();
    @endphp

  <div class="navbar-collapse collapse">
    <ul class="navbar-nav navbar-align">

      <li class="nav-item dropdown">
        <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-toggle="dropdown">
          <div class="position-relative">
            <i class="fas fa-bell" style="font-size:16px"></i>
            <span class="indicator">{{ count($orders) }}</span>
          </div>
        </a>

        <div
          class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0"
          aria-labelledby="alertsDropdown"
        >
          <div class="dropdown-menu-header">{{ count($orders) }} New order</div>
          <div class="list-group">
            @foreach ($orders as $order)
              <a href="" class="list-group-item">
                <div class="row g-0 align-items-center">
                  <div class="col-2">
                    <i class="text-danger" data-feather="alert-circle"></i>
                  </div>
                  <div class="col-10">
                    <div class="text-dark">#{{ $order->order_id }}</div>
                    <div class="text-muted small mt-1">Price: {{ $order->final_total }}</div>
                    <div class="text-muted small mt-1">
                      {{ carbon\carbon::parse($order->created_at)->diffForHumans() }}
                    </div>
                </div>
              </a>
            @endforeach
          </div>
          <div class="dropdown-menu-footer">
            <a href="{{ route('admin.orders.index') }}" class="text-muted">
              Show all pending order
            </a>
          </div>
        </div>
      </li>

      @can('do:anything')

      <li class="nav-item dropdown">
        <a
          class="nav-icon dropdown-toggle d-inline-block d-sm-none"
          href="#"
          data-toggle="dropdown"
        >

        </a>

                <a
                    class="nav-link dropdown-toggle d-none d-sm-inline-block"
                    href="#"
                    data-toggle="dropdown"
                >
                <i class="fas fa-cog"></i>

                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('admin.times.index') }}">
                        <i class="far fa-clock"></i>
                      <span class="align-middle">Delivery Time</span>
                    </a>

                    <a class="dropdown-item" href="{{ route('admin.units.index') }}">
                        <i class="fab fa-unity"></i>
                      <span class="align-middle">Manage Unit</span>
                    </a>

                    <a class="dropdown-item" href="{{ route('admin.locations.index') }}">
                        <i class="fas fa-location-arrow"></i>
                      <span class="align-middle">Location</span>
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.access.index') }}">
                        <i class="fas fa-users"></i>
                      <span class="align-middle">Manage Access</span>
                    </a>

                </div>
            </li>
            @endcan

      <li class="nav-item dropdown">
        <a
          class="nav-icon dropdown-toggle d-inline-block d-sm-none"
          href="#"
          data-toggle="dropdown"
        >
          <i class="align-middle" data-feather="settings"></i>
        </a>

                <a
                    class="nav-link dropdown-toggle d-none d-sm-inline-block"
                    href="#"
                    data-toggle="dropdown"
                >
                <i class="fas fa-user"></i>
                    <span class="text-dark">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                        <i class="align-middle mr-1" data-feather="user"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}">
                        <i class="fas fa-power-off"></i>
                        Log out
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
