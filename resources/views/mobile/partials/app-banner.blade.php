{{-- The strip across the top of home, notices and hello. Set in admin under
     Cms → App Header Banner; the bundled gif stands in until one is uploaded,
     and again at runtime if the uploaded file has gone missing. --}}
@php
    $fallbackBanner = asset('mobile/img/mainbanner.gif');
@endphp

<header class="appbar-banner">
    <img src="{{ ($headerBanner ?? null) ? getImage($headerBanner) : $fallbackBanner }}"
         alt=""
         data-fallback="{{ $fallbackBanner }}">
</header>
