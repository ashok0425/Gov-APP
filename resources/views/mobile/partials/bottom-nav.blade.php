{{-- Four tabs on a white bar around a centre-docked Home button. The FAB is
     absolutely placed against the shell, so the notch below keeps the two
     inner tabs clear of it. --}}
<div class="fab-dock">
    <a href="{{ route('m.home') }}"
       class="fab {{ request()->routeIs('m.home') ? 'is-active' : '' }}"
       aria-label="गृह">
        <img src="{{ asset('mobile/img/thumb-icon.png') }}" alt="" class="fab-logo">
    </a>
</div>

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

    {{-- Spacer under the docked FAB. --}}
    <span class="nav-notch" aria-hidden="true"></span>

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
