@extends('customer.layout.master')

@section('content')
    @include('customer.layout.mini-header', [
        'title' => 'Orders',
        'subtitle' => 'View and manage your order history'
    ])

<div class="container mt-2 d-flex justify-content-center">
<a href="{{route('order')}}" class="btn {{Route::is('order')?'btn-secondary':'border-secondary'}} btn-block w-100 me-2" >Order</a>
<a href="{{route('requisition')}}" class="btn {{Route::is('requisition')?'btn-secondary':'border-secondary'}} btn-block  w-100 ms-2">Requisition</a>
</div>

    {{-- //search --}}
    <div class="container mt-2">
        <div class="d-flex align-items-center gap-3 pb-3">
            <form class="flex-grow-1" method="GET">
                <div class="input-group bg-white rounded-3">
                    <input
                        type="text"
                        class="form-control"
                        id="dates"
                        name="dates"
                        aria-label="date"
                        value="{{ request('dates') }}"
                    />
                    <button type="submit" class="btn btn-secondary">Apply</button>
                </div>
            </form>

        </div>

        @if (request('dates'))
            <div class="mb-3">
                <a href="{{ route('order') }}">Reset Filter</a>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of
                {{ $orders->total() }} results
            </div>
            <div>Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}</div>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-3 shadow-sm mb-3">
            @foreach ($orders as $order)
                <div class="d-flex align-items-start  border-bottom p-3 showorderDetail" data-orderid="{{ $order->id }}">
                    <div data-bs-toggle="offcanvas" data-bs-target="#ordercanvas" aria-controls="ordercanvasLabel"
                        class="w-75">
                        <h6 class="fw-bold text-black osahan-mb-1">#{{ $order->order_id }}</h6>
                        <a href="#" class="text-muted">
                            Rs {{ $order->final_total }}
                            <i class="icofont-rounded-right ms-1"></i>
                        </a>
                    </div>
                    <div class="ml-auto ms-auto">
                        <div class="bg-success bg-opacity-10 mb-1 text-success rounded small px-2 py-1">
                            Delivery
                            <i class="icofont-check-circled ms-1"></i>
                        </div>
                        {{-- <div class="bg-danger bg-opacity-10 text-danger rounded small px-2 py-1">Cancel</div> --}}
                        <div class="bg-danger bg-opacity-10 mb-1 text-danger rounded small px-2 py-1 mb-1">
                            <a href="{{route('order.invoice',$order)}}" class="text-dark">
                                Invoice
                            <i class="icofont-download ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-3" data-bs-toggle="offcanvas" data-bs-target="#ordercanvas"
                    aria-controls="ordercanvasLabel">
                    <p class="mb-1">
                        @foreach ($order->orderItem as $item)
                            {{ $item->product->name }} ({{ $item->weight }}) x {{ $item->qty }},
                        @endforeach
                    </p>
                    <p class="text-muted small text-info m-0">
                        <i class="icofont-clock-time"></i>
                        {{ Carbon\Carbon::parse($order->created_at)->format('d M Y,H:i:G A') }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Product variation Offcanvas -->
    <div class="offcanvas offcanvas-bottom border-0" tabindex="-1" id="ordercanvas" aria-labelledby="ordercanvasLabel"
        style="height: 65vh">
        <div class="offcanvas-body" id="orderdetailCanvas">

        </div>
    </div>
@endsection


@push('style')
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"
    />
@endpush

@push('script')
    <script
        type="text/javascript"
        src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"
    ></script>
    <script
        type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"
    ></script>
    <script>
        $(document).ready(function () {
            $('#dates').daterangepicker();
        });
    </script>
@endpush

