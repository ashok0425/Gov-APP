{{-- One organization or category hit on the search screen: its icon, its
     name, and where it sits in the menu. --}}
<a href="{{ $href }}" class="search-menu-row">
    <span class="search-menu-icon">
        @if (filled($thumbnail))
            <img src="{{ asset('storage/' . $thumbnail) }}"
                 alt=""
                 width="40"
                 height="40"
                 loading="lazy"
                 data-fallback="{{ asset('mobile/img/placeholder-thumb.jpeg') }}">
        @else
            <span class="material-symbols-rounded">{{ $icon }}</span>
        @endif
    </span>
    <span class="search-menu-text">
        <span class="search-menu-name">{{ $name }}</span>
        @if (filled($sub))
            <span class="search-menu-sub">{{ $sub }}</span>
        @endif
    </span>
    <span class="material-symbols-rounded search-menu-chevron">chevron_right</span>
</a>
