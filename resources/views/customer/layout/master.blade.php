<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{getImage(cms('fevicon'))}}" type="image/png" />
    <title>{{cms('title')}}</title>

    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{ asset('customer/vender/bootstrap/css/bootstrap.min.css') }}" />
    <!-- Icofont -->
    <link rel="stylesheet" href="{{ asset('customer/vender/icofont/icofont.min.css') }}" />
    <!-- Slick SLider Css -->
    <link rel="stylesheet" href="{{ asset('customer/vender/slick/slick/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('customer/vender/slick/slick/slick-theme.css') }}" />
    <!-- Sidebar css -->
    <link rel="stylesheet" href="{{ asset('customer/vender/sidebar/demo.css') }}" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('customer/style.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <style>
        /* Hide the default pull-to-refresh text */
        .ptr--ptr {
            display: none !important;
            /* Completely hide the default pull-to-refresh content */
        }

        #custom-loader {
            display: none;
            text-align: center;
            font-size: 24px;
            padding: 10px;
        }

        #custom-loader i {
            animation: spin .3s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    @stack('style')
</head>

<body>
    <div id="custom-loader">
        <i class="icofont-spinner-alt-5 text-success"></i>
    </div>
    {{-- main content --}}
    @yield('content')

    {{-- branch location select option  --}}
    <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="store" aria-labelledby="locationLabel">
        <div class="offcanvas-header bg-primary d-flex align-items-center justify-content-start gap-3">
            <a href="#" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="bi bi-arrow-left fs-5 text-white"></i>
            </a>
            <h6 class="offcanvas-title text-white m-0" id="storeLabel">
                Select Store Location
            </h6>
        </div>
        <div class="offcanvas-body">
            <div class="mb-3">
                <p class="text-black text-uppercase small mb-1">Selected Location</p>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-action" data-bs-dismiss="offcanvas" aria-label="Close">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-geo-alt-fill text-primary fs-5 me-2"></i>
                            <div>
                                    <p class="mb-0">  {{ session()->get('userLocationDetail')['store_location']??''}}</p>

                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="mb-3">
                <p class="text-black text-uppercase small mb-1">Our Location</p>

                <ul class="list-group">
                    @foreach (App\Models\Location::all() as $location)
                        <form method="POST" action="{{ route('location.change', ['location' => $location->id]) }}"
                            id="location-form{{ $location->id }}">
                            @csrf
                            <li class="list-group-item list-group-item-action">
                                <div class="d-flex align-items-center" onclick="document.querySelector('#location-form{{ $location->id }}').submit()">

                                    <input type="radio">
                                    &nbsp; &nbsp;
                                    <div class="flex-grow-1 me-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-geo-alt-fill fs-5 me-2"></i>
                                            <p class="mb-0">
                                                {{ $location->name }}
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </li>
                        </form>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>


    <!-- location offcanvas -->
    <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="location" aria-labelledby="locationLabel">
        <div class="offcanvas-header bg-primary d-flex align-items-center justify-content-start gap-3">
            <a href="#" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="bi bi-arrow-left fs-5 text-white"></i>
            </a>
            <h6 class="offcanvas-title text-white m-0" id="locationLabel">
                Select delivery location
            </h6>
        </div>
        <div class="offcanvas-body">
            <div class="mb-3">
                <p class="text-black text-uppercase small mb-1">Selected Address</p>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-action" data-bs-dismiss="offcanvas" aria-label="Close">
                        <div class="d-flex">
                            <i class="bi bi-geo-alt-fill text-primary fs-5 me-2"></i>
                            <div>
                                @if (session('delivery_address'))
                                    <p class="mb-0">{{ session('delivery_address') }}</p>
                                @else
                                    <p class="mb-0">Please add an address</p>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="mb-3">
                <p class="text-black text-uppercase small mb-1">My Addresses</p>

                <ul class="list-group">
                    @foreach (auth()->user()->addresses as $address)
                        <form method="POST" action="{{ route('address.switch', $address->id) }}"
                            id="switch-address-form-{{ $address->id }}" class="d-none">
                            @csrf
                        </form>
                        <li class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 me-3"
                                    onclick="document.querySelector('#switch-address-form-{{ $address->id }}').submit()">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-geo-alt-fill fs-5 me-2"></i>
                                        <p class="mb-0">
                                            {{ $address->toString() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    @if ($loop->index)

                                    <button type="button" class="btn delete-address p-0" data-bs-toggle="modal"
                                        data-bs-target="#deleteConfirmModal" data-address-id="{{ $address->id }}">
                                        <i class="bi bi-trash fs-5"></i>
                                    </button>
                                    @endif

                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                data-bs-target="#addAddressModal">
                Add new delivery address
            </button>
        </div>
    </div>

    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('address.store') }}" id="addAddressForm">
                        @csrf
                        <div class="mb-3">
                            <label for="address" class="form-label">Address Name</label>
                            <input type="text" class="form-control" id="address" name="address" required />
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required />
                        </div>
                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" required />
                        </div>
                        <div class="mb-3">
                            <label for="zip" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="zip" name="zip" required />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" form="addAddressForm" class="btn btn-primary">
                        Save Address
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteAddressForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmModalLabel">
                            Confirm Deletion
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">Are you sure you want to delete this address?</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- sidebar nav -->
    @include('customer.layout.sidenav')

    <!-- Product variation Offcanvas -->
    <div class="offcanvas offcanvas-bottom border-0" tabindex="-1" id="productcanvas"
        aria-labelledby="productcanvasLabel" style="height: auto">
        <div class="offcanvas-body p-0" id="productDetail"></div>
    </div>

{{-- place manual order  canvas--}}
<div
        class="offcanvas offcanvas-end bg-white border-0"
        tabindex="-1"
        id="manualOrderCanvas"
        aria-labelledby="manualOrderCanvasLabel"
    >
        <div
            class="offcanvas-header bg-primary shadow-sm d-flex align-items-center justify-content-start gap-3"
        >
            <a href="#" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="bi bi-arrow-left text-white fs-5"></i>
            </a>
            <h6 class="offcanvas-title text-uppercase text-white fw-bold" id="paymentCanvasLabel">
                Add Requisition
            </h6>
        </div>
        <form method="POST" action="{{ route('requisition.store') }}" id="requisitionForm">
            @csrf
            <div class="offcanvas-body">
                <div class="mb-4">
                    <label for="amount" class="form-label text-uppercase text-muted small mb-0">
                        Enter your Requisition
                        <span class="text-danger">*</span>
                    </label>
                    <textarea name="requisition" class="form-control " id="" rows="2" oninput="autoResize(this)" required></textarea>
                </div>

            </div>

            <div class="offcanvas-footer d-flex gap-3 p-3">
                <button
                    type="button"
                    class="btn btn-light  text-primary w-100 text-uppercase  fw-bold"
                    data-bs-dismiss="offcanvas"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="btn btn-primary w-100 text-uppercase  fw-bold rounded-3"
                >
                    Submit
                </button>
            </div>
        </form>
    </div>








    <!-- Bootstrap Bundle Js -->
    <script src="{{ asset('customer/vender/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Jquery -->
    <script src="{{ asset('customer/vender/jquery/jquery.min.js') }}"></script>
    <!-- Slick Slider Js -->
    <script src="{{ asset('customer/vender/slick/slick/slick.min.js') }}"></script>
    <!-- Sidebar js -->
    <script src="{{ asset('customer/vender/sidebar/hc-offcanvas-nav.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pulltorefreshjs/0.1.22/index.umd.min.js"></script>


    <!-- Custom Js -->
    <script src="{{ asset('customer/custom.js') }}"></script>
    <script type="text/javascript">
        // Edit Address
        document.querySelectorAll('.edit-address').forEach((button) => {
            button.addEventListener('click', function() {
                const addressId = this.closest('.list-group-item').dataset.addressId;
                // Here you would typically fetch the address details from your server
                // For this example, we'll just populate with dummy data
                document.getElementById('editAddressId').value = addressId;
                document.getElementById('editAddressName').value = 'Location ' + addressId;
                document.getElementById('editStreetAddress').value = 'H.No. 2834 Street';
                document.getElementById('editCity').value = 'Ludhiana';
                document.getElementById('editState').value = 'Punjab';
                document.getElementById('editPostalCode').value = '784';
            });
        });

        // Handle Edit Form Submission
        document.getElementById('editAddressForm')?.addEventListener('submit', function(event) {
            event.preventDefault();
            const addressId = document.getElementById('editAddressId').value;
            // Here you would typically send the form data to your server
            console.log('Editing address', addressId, {
                addressName: document.getElementById('editAddressName').value,
                streetAddress: document.getElementById('editStreetAddress').value,
                city: document.getElementById('editCity').value,
                state: document.getElementById('editState').value,
                postalCode: document.getElementById('editPostalCode').value,
            });

            // Close the modal
            var modal = bootstrap.Modal.getInstance(
                document.getElementById('editAddressModal'),
            );
            modal.hide();
        });

        document.querySelectorAll('.delete-address').forEach((button) => {
            button.addEventListener('click', function() {
                const addressId = this.dataset.addressId;
                const deleteForm = document.getElementById('deleteAddressForm');
                deleteForm.action = `/address/${addressId}`;
            });
        });
    </script>

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
    <script>

function autoResize(textarea) {
    textarea.style.height = 'auto'; // Reset textarea height
    textarea.style.height = textarea.scrollHeight + 'px'; // Set new height based on content
}
    </script>

    @stack('script')
    <x-open-inmobile-view/>
</body>

</html>
