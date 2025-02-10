<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="img/logo.png" type="image/png" />
        <title>{{cms('meta_title')}}</title>

        <!-- Bootstrap Css -->
        <link
            rel="stylesheet"
            href="{{ asset('customer/vender/bootstrap/css/bootstrap.min.css') }}"
        />
        <!-- Icofont -->
        <link rel="stylesheet" href="{{ asset('customer/vender/icofont/icofont.min.css') }}" />
        <!-- Slick SLider Css -->
        <link rel="stylesheet" href="{{ asset('customer/vender/slick/slick/slick.css') }}" />
        <link rel="stylesheet" href="{{ asset('customer/vender/slick/slick/slick-theme.css') }}" />
        <!-- Sidebar css -->
        <link rel="stylesheet" href="{{ asset('customer/vender/sidebar/demo.css') }}" />
        <!-- Custom Css -->
        <link rel="stylesheet" href="{{ asset('customer/style.css') }}" />
        <link
            rel="stylesheet"
            type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        />
        @stack('style')
    </head>

    <body>
        @yield('content')



    <!-- Bootstrap Bundle Js -->
    <script src="{{ asset('customer/vender/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Jquery -->
    <script src="{{ asset('customer/vender/jquery/jquery.min.js') }}"></script>
        @stack('script')
    </body>
</html>
