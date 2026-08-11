{{-- BottomAppBar with a centre-docked Home FAB and a tab group either side. --}}
<div class="fab-dock">
    <a href="{{ route('m.home') }}"
       class="fab {{ request()->routeIs('m.home') ? 'is-active' : '' }}"
       aria-label="Home">
        <span class="material-symbols-rounded">home</span>
    </a>
</div>

<nav class="bottom-nav">
    <span class="nav-side">
        <a href="{{ route('m.search') }}"
           class="nav-tab {{ request()->routeIs('m.search') ? 'is-active' : '' }}">
            <span class="nav-icon">
                <span class="material-symbols-rounded">search</span>
            </span>
            <span>Search</span>
        </a>

        @if ($showPalika ?? false)
            <a href="{{ route('m.palikas') }}"
               class="nav-tab {{ request()->routeIs('m.palikas') || request()->routeIs('m.palika') ? 'is-active' : '' }}">
                <span class="nav-icon">
                    <span class="material-symbols-rounded">location_city</span>
                </span>
                <span>Palika</span>
            </a>
        @endif
    </span>

    {{-- Spacer under the docked FAB. --}}
    <span class="nav-notch" aria-hidden="true"></span>

    <span class="nav-side">
        <a href="{{ route('m.notifications') }}"
           class="nav-tab {{ request()->routeIs('m.notifications') ? 'is-active' : '' }}">
            <span class="nav-icon">
                <span class="material-symbols-rounded">notifications</span>
                @if (($noticeCount ?? 0) > 0)
                    <span class="nav-badge">{{ $noticeCount }}</span>
                @endif
            </span>
            <span>Notice</span>
        </a>

        <a href="{{ route('m.settings') }}"
           class="nav-tab {{ request()->routeIs('m.settings') ? 'is-active' : '' }}">
            <span class="nav-icon">
                <span class="material-symbols-rounded">settings</span>
            </span>
            <span>Settings</span>
        </a>
    </span>
</nav>
