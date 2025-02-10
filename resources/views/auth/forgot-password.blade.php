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
    @include('customer.layout.mini-header', ['title' => 'Forget password', 'subtitle' => 'Send otp to your phone number'])

    <div class="container mt-5 pt-5">
        <div class="row align-items-center">
            <div class="col-md-6 offset-3">
                <p>
                    Forget Password ? No worry ,Provide your valid Phone number we will send
                    otp to your phone number.
                </p>

                <div class="text-center">
                    <form action="{{ route('otp.send') }}" method="POST">
                        @if (session('status'))
                            <div class="mb-4 font-medium text-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @csrf
                        <div class="form-group mt-2">
                            <input
                                type="number"
                                class="form-control"
                                name="phone"
                                value="{{ old('phone') }}"
                                required
                                placeholder="Enter your register phone number"
                            />

                        </div>


                        <div class="form-group mt-3">
                            <input
                                type="submit"
                                value="Send OTP"
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
