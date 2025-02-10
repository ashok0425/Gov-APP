@extends('customer.layout.master')

@section('content')
    @include('customer.layout.mini-header', [
        'title' => 'Requisitions',
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
                <a href="{{ route('requisition') }}">Reset Filter</a>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                Showing {{ $requisitions->firstItem() }} to {{ $requisitions->lastItem() }} of
                {{ $requisitions->total() }} results
            </div>
            <div>Page {{ $requisitions->currentPage() }} of {{ $requisitions->lastPage() }}</div>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-3 shadow-sm mb-3">
            @foreach ($requisitions as $requisition)

                <div class="card border-0 border-bottom">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <p class="mb-1">
                                    {{ $requisition->requisition}}
                            </p>
                            <p class="text-muted small text-info m-0">
                                <i class="icofont-clock-time"></i>
                                {{ Carbon\Carbon::parse($requisition->created_at)->format('d M Y,H:i:G A') }}
                            </p>
                            <p><strong>{{ucfirst($requisition->status)}}</strong></p>
                            </div>
                            <div class="col-3">

                            </div>
                        </div>
                    </div>
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

