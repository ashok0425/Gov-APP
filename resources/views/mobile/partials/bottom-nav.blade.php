{{-- Five equal tabs on a white bar, the active one green under a short
     indicator. Home sits in the middle as an ordinary tab — no docked FAB. --}}
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
       class="nav-tab {{ request()->routeIs('m.home') ? 'is-active' : '' }}">
        <span class="nav-icon">
            <span class="material-symbols-rounded">home</span>
        </span>
        <span>गृह</span>
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
