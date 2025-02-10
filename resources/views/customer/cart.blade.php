@extends('customer.layout.master')

@section('content')
    <div class="cart d-flex flex-column vh-100">
        <!-- navbar -->
        @include('customer.layout.mini-header', ['title' => 'Cart', 'subtitle' => 'Review Your Items'])

        <!-- body -->
        <div class="my-auto vh-100 overflow-auto p-3">
            <!-- review items -->
            @if (count($cartItems) > 0)
                @foreach ($cartItems as $cartItem)
                    <div
                        class="cart-item p-3 border rounded-3 mb-3 position-relative"
                        data-productid="{{ $cartItem->product->id }}"
                    >
                        <button
                            class="btn bg-white btn-sm btn-outline-danger px-2 py-1 align-self-start remove-item position-absolute"
                            style="top: -8px; right: -8px"
                            data-productid="{{ $cartItem->product->id }}"
                        >
                            <i class="icofont-trash"></i>
                        </button>

                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img
                                src="{{getImage( $cartItem->product->thumbnail) }}"
                                alt="{{ $cartItem->product->name }}"
                                class="img-fluid bg-light p-1 border rounded-3 cart-product"
                                style="width: 80px; height: 80px; object-fit: cover"
                                loading="lazy"
                            />

                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $cartItem->product->name }}</h5>
                                <p class="text-muted mb-0">
                                    {{ "{$cartItem->weight} {$cartItem->product->unit}" }}
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <div
                                class="quantity-control d-flex align-items-center border rounded-pill"
                            >
                                <button
                                    class="btn btn-sm btn-light cartminus"
                                    data-productid="{{ $cartItem->product->id }}"
                                >
                                    <i class="icofont-minus-circle"></i>
                                </button>
                                <input
                                    type="text"
                                    class="form-control box form-control-sm text-center border-0 quantity-input"
                                    value="{{ $cartItem->qty }}"
                                    style="width: 40px"
                                />
                                <button
                                    class="btn btn-sm btn-light cartplus"
                                    data-productid="{{ $cartItem->product->id }}"
                                >
                                    <i class="icofont-plus-circle"></i>
                                </button>
                            </div>

                            <div class="text-end">
                                <p class="mb-0">
                                    <span class="text-muted">Price:</span>
                                    <span class="fw-bold">
                                        <sub>Rs</sub>{{ number_format($cartItem->product->getPrice($cartItem->weight)['price'], 2) }}
                                    </span>
                                </p>
                                <p class="mb-0">
                                    <span class="text-muted">Total:</span>
                                    <span class="fw-bold text-primary">
                                        <sub>Rs</sub>
                                        <span id="productprice{{ $cartItem->product->id }}">
                                            {{ number_format($cartItem->product->getPrice($cartItem->weight)['price']* $cartItem->qty, 2) }}
                                        </span>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    {{--
                        <div class="d-flex align-items-center gap-3 mb-3 justify-content-between">
                        <img
                        src="{{ $cartItem->product->thumbnail }}"
                        alt="{{ $cartItem->product->name }}"
                        class="img-fluid bg-light p-1 border rounded-3 cart-product"
                        />
                        <div class="me-auto">
                        <p class="osahan-mb-1 fw-bold">{{ $cartItem->product->name }}</p>
                        <p class="text-muted small m-0">50 g</p>
                        </div>
                        <div
                        class="osahan-count d-flex align-items-center justify-content-between border border-dark-subtle rounded-pill h6 m-0 p-1"
                        >
                        <span
                        class="text-muted cartminus d-flex"
                        data-productid="{{ $cartItem->product->id }}"
                        >
                        <i class="icofont-minus-circle"></i>
                        </span>
                        <input
                        type="text"
                        class="lh-sm small text-black text-center box border-0"
                        value="{{ $cartItem->qty }}"
                        />
                        <span
                        class="text-muted cartplus d-flex"
                        data-productid="{{ $cartItem->product->id }}"
                        >
                        <i class="icofont-plus-circle"></i>
                        </span>
                        </div>
                        <h6 class="flex-shrink-0 m-0 text-primary" id="productprice1">
                        <sub>Rs</sub> {{ $cartItem->product->price_1 }}
                        </h6>
                        </div>
                    --}}
                @endforeach
            @else
                <div class="text-center my-5">
                    <i class="icofont-shopping-cart icofont-5x text-muted mb-3"></i>
                    <h3 class="text-muted">Your cart is empty</h3>
                    <p class="text-muted">
                        Add some items to your cart and come back here to complete your purchase.
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                        Continue Shopping
                    </a>
                </div>
            @endif

            {{-- <div class="bg-white p-3 mb-2 shadow-sm rounded-3">
                <form action="{{route('coupon.apply')}}" method="get">
                    <div class="input-group mt-2 rounded-0">
                        <input type="text" class="form-control  rounded-0" placeholder="Have a promocode,Enter here.." name="coupon" aria-label="Have a promocode,Enter here.." aria-describedby="basic-addon2">
                        <span class="input-group-text p-0 rounded-0" id="basic-addon2"><button class="btn btn-success rounded-0">Apply</button></span>
                      </div>
                </form>
            </div> --}}

            <!-- bill -->

            @if (count($cartItems) > 0)
                <div class="bg-white p-3 mb-2 shadow-sm rounded-3">
                    <h6 class="fw-bold text-black mb-3">Bill Details</h6>

                    <div class="border-bottom">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <p class="m-0">Items price</p>
                            <p class="m-0">
                                <sub>Rs</sub>
                                <span id="subtotal">
                                    {{ $cartTotals['subtotal'] }}
                                </span>
                            </p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <p class="m-0">Delivery Partner Fee</p>
                            <p class="m-0">
                                <sub>Rs</sub>
                                <span id="deliveryfee">
                                    {{ $cartTotals['deliveryFee'] }}
                                </span>
                            </p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <p class="text-info m-0">Handling Fee</p>
                            <p class="m-0">
                                <sub>Rs</sub>
                                <span id="handlingfee">
                                    {{ $cartTotals['handlingFee'] }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-3">
                        <h6 class="text-primary m-0">Grand Total</h6>
                        <h6 class="fw-bold text-primary m-0">
                            <sub>Rs</sub>
                            <span id="total">{{ $cartTotals['total'] }}</span>
                        </h6>
                    </div>

                </div>
            @endif

            <!-- cancellation policy -->
            <div class="bg-white shadow-sm p-3 rounded-3">
                <h6 class="fw-bold text-black mb-3">Cancellation policy</h6>
                <div>
                    <div class="d-flex align-items-center gap-3 mb-3 border bg-light p-3 rounded-3">
                        <i class="icofont-stopwatch icofont-2x text-danger"></i>
                        <p class="m-0">
                            Orders cannot be cancelled and are non-refundable once packed for
                            delivery.
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3 border bg-light p-3 rounded-3">
                        <i class="icofont-file-alt icofont-2x text-danger"></i>
                        <p class="m-0">
                            In case of unexpected delays or issues, a refund will be provided.
                        </p>
                    </div>
                </div>
                <p class="mb-0 small text-muted">
                    Check your order and address details before placing the order.
                    <a href="#" class="text-decoration-underline text-primary">Read policy</a>
                </p>
            </div>
        </div>
        <!-- footer -->
        @if (count($cartItems) > 0)
            <div class="mt-auto shadow-sm border-top">
                <div class="bg-white p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0">Grand Total</h6>
                        <h5 class="mb-0 fw-bold">
                            <sub>Rs</sub>
                            <span id="grandTotal">{{ $cartTotals['total'] }}</span>
                        </h5>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div
                            data-bs-toggle="offcanvas"
                            data-bs-target="#homelocation"
                            aria-controls="homelocation"
                            class="w-75"
                        >
                            <h6 class="mb-0">Delivery Address</h6>
                            <p class="text-muted text-truncate m-0">
                               {{ session()->get('userLocationDetail')['delivery_address']??'No Address Select'}}
                            </p>
                        </div>
                        <button
                            class="btn btn-outline-success border-dark-subtle fw-bold shadow-sm user-icon rounded-pill fs-6"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#location"
                            aria-controls="location"
                        >
                            <i class="icofont-edit"></i>
                        </button>
                    </div>
                    <div class="pt-3">
                        <a
                            href="#"
                            class="btn btn-success w-100 text-uppercase btn-lg fw-bold"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#deliveryoption"
                            aria-controls="deliveryoption"
                        >
                            Select delivery option
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- offcanvas delivery option -->
    <div
        class="offcanvas offcanvas-bottom bg-light border-0"
        style="height: auto"
        tabindex="-1"
        id="deliveryoption"
        aria-labelledby="deliveryoptionLabel"
    >
        <form action="{{ route('checkout') }}" method="post">
            @csrf
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold text-black" id="deliveryoptionLabel">
                    Select a delivery option
                </h5>
            </div>
            <div class="offcanvas-body p-0">
                <div class="bg-white shadow-sm p-3 border-bottom border-top">
                    <div class="form-check form-check-reverse">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="exampleRadios"
                            id="exampleRadios1"
                            value="option1"
                        />
                        <label
                            class="form-check-label d-flex align-items-center gap-2"
                            for="exampleRadios1"
                        >
                            <i class="icofont-free-delivery icofont-3x text-primary"></i>
                            <div class="text-start">
                                <h6 class="fw-bold mb-0">
                                    Delivery now -
                                    <span class="text-success">Rs 100</span>
                                </h6>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="bg-white shadow-sm p-3">
                    <div class="form-check form-check-reverse mb-3">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="exampleRadios"
                            id="exampleRadios2"
                            value="option2"
                            checked
                        />
                        <label
                            class="form-check-label d-flex align-items-center gap-2"
                            for="exampleRadios2"
                        >
                            <i class="icofont-delivery-time icofont-3x text-primary"></i>
                            <div class="text-start">
                                <h6 class="fw-bold mb-0">
                                    Delivery later -
                                    <span class="text-success">Free</span>
                                </h6>
                            </div>
                        </label>
                    </div>
                    <div class="row row-cols-2 g-2 custom-checkbox mb-3">
                        <div class="col">
                            <input
                                type="radio"
                                class="btn-check"
                                name="day"
                                id="day1"
                                autocomplete="off"
                                checked
                                value="today"
                            />
                            <label class="btn btn-outline-danger btn-sm w-100" for="day1">
                                <strong>Today</strong>
                            </label>
                        </div>

                        <div class="col">
                            <input
                                type="radio"
                                class="btn-check"
                                name="day"
                                id="day2"
                                checked
                                autocomplete="off"
                                value="tomorrow"

                            />
                            <label class="btn btn-outline-danger btn-sm w-100" for="day2">
                               <strong> Tomorrow</strong>
                            </label>
                        </div>
                    </div>
                    <div class="row row-cols-2 g-2 custom-checkbox">
                        @php
                            $times=App\Models\DeliveryTime::where('from','>',now()->addHours(2))->get();
                        @endphp
                        @foreach ($times as $time)
                        <div class="col-4">
                            <input
                                type="radio"
                                class="btn-check"
                                name="time"
                                id="time1"
                                autocomplete="off"
                                checked
                                value="{{Carbon\Carbon::parse($time->from)->format('H:i A')}}-{{Carbon\Carbon::parse($time->to)->format('H:i A')}}"
                            />
                            <label class="btn btn-outline-danger btn-sm w-100" for="time1">
                                {{Carbon\Carbon::parse($time->from)->format('H:i A')}}

                            </label>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="offcanvas-footer bg-white shadow-sm border-top">
                <button class="btn btn-success text-uppercase w-100 btn-lg fw-bold">
                    Place Order -  Rs
                    <span id="orderTotal"><sup>{{ $cartTotals['total'] }}</sup></span>
                </button>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.cartminus', function () {
                var productid = $(this).data('productid');
                var $input = $(this).parent().find('.box');
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                updateCart(productid, count);
                return false;
            });

            $(document).on('click', '.cartplus', function () {
                var productid = $(this).data('productid');
                var $input = $(this).parent().find('.box');
                $input.val(parseInt($input.val()) + 1);
                $input.change();
                var count = parseInt($input.val());
                updateCart(productid, count);
                return false;
            });

            $(document).on('click', '.remove-item', function () {
                var productid = $(this).data('productid');
                $.ajax({
                    url: '{{ route('cart.remove') }}',
                    type: 'DELETE',
                    data: {
                        product_id: productid,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        // Remove the cart item from the DOM
                        $(`.cart-item[data-productid="${productid}"]`).remove();

                        // Update totals
                        $('#subtotal').html(response.subtotal);
                        $('#deliveryfee').html(response.deliveryfee);
                        $('#handlingfee').html(response.handlingfee);
                        $('#total').html(response.total);
                        $('#grandTotal').html(response.total);
                        $('#orderTotal').html(response.total);

                        // alert(response.message);
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                        // alert('An error occurred while removing the item from the cart.');
                    },
                });
            });

            function updateCart(productid, qty) {
                $.ajax({
                    url: '/cart/update',
                    type: 'POST',
                    data: {
                        product_id: productid,
                        qty: qty,
                        _token: $('meta[name="csrf-token"]').attr('content'), // Add CSRF token
                    },
                    success: function (response) {
                        $(`#productprice${productid}`).html(response.productprice);
                        $('#subtotal').html(response.subtotal);
                        $('#deliveryfee').html(response.deliveryfee);
                        $('#handlingfee').html(response.handlingfee);
                        $('#total').html(response.total);
                        $('#grandTotal').html(response.total);
                        $('#orderTotal').html(response.total);
                    },
                    error: function (xhr, status, error) {
                        // Handle errors from the server or AJAX request
                        console.error(error);
                    },
                });
            }
        });
    </script>
@endpush
