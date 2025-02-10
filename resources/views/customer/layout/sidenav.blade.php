<nav id="main-nav">
    <ul class="second-nav">
        <li class="osahan-user-profile bg-primary">
            <div class="d-flex align-items-center gap-2">
                <img src="img/delivery-boy.jpg" alt="" class="rounded-pill img-fluid" />
                <div class="ps-1">
                    <h5 class="fw-bold text-white osahan-mb-1">{{ auth()->user()->name }}</h5>
                    <p class="text-white-50 m-0">{{ auth()->user()->phone }}</p>
                </div>
            </div>
        </li>
        <li>
            <a href="{{ route('home') }}">
                <i class="bi bi-house me-3"></i>
                Home
            </a>
        </li>
        <li>
            <a href="{{ route('profile.edit') }}">
                <i class="bi bi-grid me-3"></i>
                Profile
            </a>
        </li>
        <li>
            <a href="#"
            data-bs-toggle="offcanvas"
            data-bs-target="#location"
            aria-controls="location"
            >
                <i class="icofont-location-arrow me-3"></i>
                Address
            </a>
        </li>
        <li>
            <a href="{{ route('kyc') }}">
                <i class="bi bi-bank me-3"></i>
                KYC
            </a>
        </li>
        <li>
            <a href="{{ route('order') }}">
                <i class="bi bi-stopwatch me-3"></i>
                Orders
            </a>
        </li>
        <li>
            <a href="{{ route('payments.index') }}">
                <i class="bi bi-credit-card me-3"></i>
                Payments
            </a>
        </li>
        <li>
            <a
                href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            >
                <i class="bi bi-box-arrow-right me-3"></i>
                Logout
            </a>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
            @csrf
        </form>
    </ul>
</nav>
