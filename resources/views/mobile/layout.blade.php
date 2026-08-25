<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#ffffff">
    <title>@yield('title', 'बारबर्दिया नगरपालिका')</title>
    <link rel="icon" href="{{ cms('fevicon') ? getImage(cms('fevicon')) : asset('mobile/img/app-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ cms('fevicon') ? getImage(cms('fevicon')) : asset('mobile/img/app-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0&display=swap">
    {{-- Versioned by the file's own timestamp, so a deploy busts every
         browser's cache without anyone remembering to bump a number. --}}
    <link rel="stylesheet" href="{{ asset('mobile/app.css') }}?v={{ filemtime(public_path('mobile/app.css')) }}">
</head>
<body>
    <div class="shell @yield('shell-class')">
        @yield('appbar')

        <div class="scroll-area">
            @yield('content')
        </div>

        @yield('bottom')
    </div>

    <script src="{{ asset('mobile/app.js') }}?v={{ filemtime(public_path('mobile/app.js')) }}"></script>
    {{-- Offline fallback: with no network, pages show /mobile/offline.html
         instead of the browser's own error. See public/sw.js. --}}
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').catch(function () {});
        }
    </script>
    @stack('scripts')
</body>
</html>
