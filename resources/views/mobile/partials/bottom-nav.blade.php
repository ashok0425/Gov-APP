{{-- BottomAppBar + centre-docked FAB + the menu modal sheet. --}}
<div class="fab-dock">
    <a href="{{ route('m.home') }}" class="fab" aria-label="Home">
        <img src="{{ asset('mobile/img/icon.png') }}" alt="">
    </a>
</div>

<nav class="bottom-nav">
    <a href="{{ route('m.notifications') }}" class="nav-tab">
        <span class="nav-icon">
            <span class="material-symbols-rounded">notifications</span>
            @if (($noticeCount ?? 0) > 0)
                <span class="nav-badge">{{ $noticeCount }}</span>
            @endif
        </span>
        <span>Notifications</span>
    </a>

    <button type="button" class="nav-tab" id="menu-open">
        <span class="nav-icon">
            <span class="material-symbols-rounded">grid_view</span>
        </span>
        <span>Menu</span>
    </button>
</nav>

<div class="sheet-scrim" id="menu-scrim"></div>

<div class="sheet" id="menu-sheet">
    <div class="sheet-handle"></div>

    <div class="sheet-grid">
        <a class="menu-item" href="{{ route('m.palika') }}">
            <span class="menu-item-icon"><img src="{{ asset('mobile/img/palika.png') }}" alt=""></span>
            <span>Palika</span>
        </a>

        <a class="menu-item" href="{{ route('m.wards') }}">
            <span class="menu-item-icon"><img src="{{ asset('mobile/img/ward.png') }}" alt=""></span>
            <span>My Ward</span>
        </a>

        <a class="menu-item" href="{{ route('m.hello') }}">
            <span class="menu-item-icon"><img src="{{ asset('mobile/img/hello.png') }}" alt=""></span>
            <span>Hello</span>
        </a>

        <a class="menu-item" href="{{ route('m.settings') }}">
            <span class="menu-item-icon"><img src="{{ asset('mobile/img/settings.png') }}" alt=""></span>
            <span>Settings</span>
        </a>
    </div>
</div>
