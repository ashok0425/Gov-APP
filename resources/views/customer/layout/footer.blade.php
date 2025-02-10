<div class="footer bg-white shadow mt-auto border-top">
    <div class="d-flex align-items-center justify-content-between py-1">
        <a
            href="{{ route('home') }}"
            class="text-center col py-2 p-1 {{ request()->routeIs('home') ? 'link-dark' : 'text-muted' }}"
        >
            <i class="bi bi-house h3 m-0"></i>
            <p class="small m-0 pt-1">Home</p>
        </a>
        <a
            href="{{ route('store') }}"
            class="text-center col py-2 p-1 {{ request()->routeIs('store') ? 'link-dark' : 'text-muted' }}"
        >
            <i class="bi bi-shop h3 m-0"></i>
            <p class="small m-0 pt-1">Shop</p>
        </a>

        <a
            href="{{ route('cart') }}"
            class="text-muted text-center col py-2 p-1 position-relative"
        >
            <i class="bi bi-basket h3 m-0"></i>
            @if (auth()->user()->cart_count)
                <div
                    class="text-bg-primary rounded-circle position-absolute d-flex align-items-center justify-content-center"
                    style="height: 20px; width: 20px; top: 4px; left: 60%"
                >
                  <span >  {{ auth()->user()->cart_count }}</span>
                </div>
            @endif

            <div
                    class="text-bg-primary cartCount d-none rounded-circle position-absolute d-flex align-items-center justify-content-center"
                    style="height: 20px; width: 20px; top: 4px; left: 60%"
                >
                  <span class="">  {{ auth()->user()->cart_count }}</span>
                </div>

            <p class="small m-0 pt-1">Cart</p>
        </a>
        <a href="{{ route('profile.edit') }}" class="text-muted text-center col py-2 p-1">
            <i class="bi bi-person h3 m-0"></i>
            <p class="small m-0 pt-1">Profile</p>
        </a>
    </div>
</div>
