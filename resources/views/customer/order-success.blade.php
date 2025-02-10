@extends('customer.layout.master')

@section('content')
    @include('customer.layout.mini-header', ['title' => 'Order Successfully Placed', 'subtitle' => 'View Your Order Details'])

    <div class="d-flex flex-column">
        <div class="order-received d-flex align-items-center justify-content-center">
            <a href="{{route('order')}}" class="link-dark">
                <div class="text-center p-4">
                    <img src="{{asset('order-received.png')}}" alt="" class="img-fluid w-50 mb-4" />
                    <div>
                        <h3 class="fw-bold">Yay! Order Recieved</h3>
                        <p class="text-muted">You've saved <sub>Rs</sub>20 on this order.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="mt-auto p-4">
            <a href="{{route('order')}}" class="btn btn-primary w-100 text-uppercase btn-lg fw-bold">
                View Order
            </a>
        </div>
    </div>

    {{-- @include('customer.layout.footer') --}}
@endsection
