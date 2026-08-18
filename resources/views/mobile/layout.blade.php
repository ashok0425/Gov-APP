<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#0e7f6b">
    <title>@yield('title', 'बारबर्दिया नगरपालिका')</title>
    <link rel="icon" href="{{ asset('mobile/img/app-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('mobile/img/app-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0&display=swap">
    <link rel="stylesheet" href="{{ asset('mobile/app.css') }}?v=15">
</head>
<body>
    <div class="shell @yield('shell-class')">
        @yield('appbar')

        <div class="scroll-area">
            @yield('content')
        </div>

        @yield('bottom')
    </div>

    <script src="{{ asset('mobile/app.js') }}?v=8"></script>
    @stack('scripts')
</body>
</html>
