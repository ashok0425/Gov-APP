<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password|{{cms('meta_title')}}</title>
    <link
    rel="stylesheet"
    href="{{ asset('customer/vender/bootstrap/css/bootstrap.min.css') }}"
/>
<link
rel="stylesheet"
type="text/css"
href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
/>
<link rel="stylesheet" href="{{ asset('customer/style.css') }}" />

</head>
<body>
    @include('customer.layout.mini-header', ['title' => 'Verify Otp', 'subtitle' => 'Check your phone for OTP'])
    <div class="container mt-5 pt-5">
        <div class="row align-items-center">
            <div class="col-md-6 offset-3">
                <p>
                    Enter Verification Code
                </p>

                <div class="text-center">
                    <form action="{{ route('otp.verify') }}" method="POST">
                        @csrf
                        <div class="form-group mt-2">
                            <input
                                type="tel"
                                class="form-control"
                                name="otp"
                                required
                                minlength="6"
                                maxlength="6"
                                placeholder="Enter Verification code"
                            />

                        </div>

                        <div class="form-group mt-3">
                            <input
                                type="submit"
                                value="Verify"
                                class="form-control btn btn-success"
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   <!-- Jquery -->
   <script src="{{ asset('customer/vender/jquery/jquery.min.js') }}"></script>
        <script
            type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        ></script>
    <script>

    @if (Session::has('message')) //toatser
        var type = "{{ Session::get('alert-type', 'info') }}"
        switch (type) {
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;
            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;
            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
    @endif
    </script>
</body>
</html>
