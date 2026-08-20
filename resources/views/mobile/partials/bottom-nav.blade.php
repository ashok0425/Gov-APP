{{-- Five tabs on a white bar. Home sits in the middle at the same level as
     the others — the logo drawn tab-icon size instead of a raised FAB. --}}
<nav class="bottom-nav">
    <a href="{{ route('m.search') }}"
       class="nav-tab {{ request()->routeIs('m.search') ? 'is-active' : '' }}">
        <span class="nav-icon">
            <span class="material-symbols-rounded">search</span>
        </span>
        <span>खोज</span>
    </a>

    <a href="{{ route('m.categories') }}"
       class="nav-tab {{ request()->routeIs('m.categories') || request()->routeIs('m.category') ? 'is-active' : '' }}">
        <span class="nav-icon">
            <span class="material-symbols-rounded">grid_view</span>
        </span>
        <span>मेनु</span>
    </a>

    <a href="{{ route('m.home') }}"
       class="nav-tab nav-home {{ request()->routeIs('m.home') ? 'is-active' : '' }}"
       aria-label="गृह">
        <span class="nav-icon">
            <img src="{{ asset('mobile/img/thumb-icon.png') }}" alt="" class="nav-home-logo">
        </span>
    </a>

    <a href="{{ route('m.notifications') }}"
       class="nav-tab {{ request()->routeIs('m.notifications') ? 'is-active' : '' }}">
        <span class="nav-icon">
            <span class="material-symbols-rounded">campaign</span>
            @if (($noticeCount ?? 0) > 0)
                <span class="nav-badge">{{ $noticeCount }}</span>
            @endif
        </span>
        <span>सूचना</span>
    </a>

    <a href="{{ route('m.settings') }}"
       class="nav-tab {{ request()->routeIs('m.settings') ? 'is-active' : '' }}">
        <span class="nav-icon">
            <span class="material-symbols-rounded">settings</span>
        </span>
        <span>सेटिङ</span>
    </a>
</nav>
