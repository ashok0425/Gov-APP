@extends('customer.layout.master')

@section('content')
    @include('customer.layout.mini-header', ['title' => 'Payments', 'subtitle' => 'View and Manage Your Payment History'])

    <div class="container py-3">
        <div
            class="card shadow-sm rounded-3 border-0 text-white"
            style="background: linear-gradient(45deg, #737373, #1f1f1f) !important"
        >
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="text-start">
                            <h5 class="mb-0 fw-bold">
                                <i class="icofont-credit-card me-1 fs-5"></i>
                                Pending Payment
                            </h5>
                            <p class="mb-0 opacity-75">Your current pending payment amount</p>
                        </div>
                    </div>
                    <div class="fs-4 fw-bold"><sub>Rs</sub>250000.00</div>
                </div>

                <div class="text-warning">
                    {{-- <i class="bi bi-info-circle-fill"></i> --}}
                    Note: You can only make a new payment after your previous payment is confirmed.
                </div>
            </div>
        </div>
        <hr />

        <x-errormsg/>
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
            <div class="flex-shrink-0">
                <button
                    class="btn btn-primary py-2"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#paymentCanvas"
                >
                    <i class="icofont-plus"></i>
                    Add
                </button>
            </div>
        </div>

        @if (request('dates'))
            <div class="mb-3">
                <a href="{{ route('payments.index') }}">Reset Filter</a>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of
                {{ $payments->total() }} results
            </div>
            <div>Page {{ $payments->currentPage() }} of {{ $payments->lastPage() }}</div>
        </div>

        <div class="list-group mb-3">
            @forelse ($payments as $payment)
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <div>
                            <h4 class="mb-0"><sub>Rs</sub>{{ number_format($payment->amount, 2) }}</h4>
                        </div>
                        <div>
                            <span
                                class="badge rounded-pill text-uppercase @switch($payment->status)
                            @case(\App\Models\Payment::STATUS_PENDING_CONFIRMATION)
                                text-bg-warning
                                @break
                            @case(\App\Models\Payment::STATUS_CONFIRMED)
                                text-bg-success
                                @break
                            @case(\App\Models\Payment::STATUS_REJECTED)
                                text-bg-danger
                                @break
                            @default
                                text-bg-secondary
                        @endswitch"
                            >
                                {{Str::replace('_',' ',$payment->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="my-2">
                        <p class="mb-0">
                            <span class="text-muted">Payment Mode:</span>
                            <span class="text-uppercase">{{ $payment->payment_mode }}</span>
                        </p>

                        @if ($payment->account_number)
                            <p class="mb-0">
                                <span class="text-muted">Account Number:</span>
                                <span>{{ $payment->account_number }}</span>
                            </p>
                        @endif

                        @if ($payment->payment_id)
                            <p class="mb-0">
                                <span class="text-muted">Payment Id:</span>
                                <span>{{ $payment->payment_id }}</span>
                            </p>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="text-info">
                                {{ $payment->payment_date->format('d M Y') }}
                            </strong>
                        </div>

                        @if ($payment->receipt)
                            <a
                                href="{{ $payment->receipt }}"
                                class="btn btn-sm btn-outline-secondary"
                                download
                            >
                                <i class="icofont-download"></i>
                                Download Receipt
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="list-group-item text-center text-muted">No payments found.</div>
            @endforelse
        </div>

        {{ $payments->links() }}
    </div>

    <div
        class="offcanvas offcanvas-end bg-white border-0"
        tabindex="-1"
        id="paymentCanvas"
        aria-labelledby="paymentCanvasLabel"
    >
        <div
            class="offcanvas-header bg-primary shadow-sm d-flex align-items-center justify-content-start gap-3"
        >
            <a href="#" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="bi bi-arrow-left text-white fs-5"></i>
            </a>
            <h6 class="offcanvas-title text-uppercase text-white fw-bold" id="paymentCanvasLabel">
                Add Payment
            </h6>
        </div>
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="offcanvas-body">
                <div class="mb-4">
                    <label for="amount" class="form-label text-uppercase text-muted small mb-0">
                        Amount
                        <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2"
                        id="amount"
                        name="amount"
                        required
                        placeholder="Enter Payment Amount"
                    />
                </div>

                <div class="mb-4">
                    <label
                        for="payment_date"
                        class="form-label text-uppercase text-muted small mb-0"
                    >
                        Payment Date
                        <span class="text-danger">*</span>
                    </label>
                    <input
                        type="date"
                        class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2"
                        id="payment_date"
                        name="payment_date"
                        required
                        placeholder="Enter Payment Date"
                    />
                </div>

                <div class="mb-4">
                    <label for="payment_mode" class="form-label text-uppercase text-muted small">
                        Payment Type
                        <span class="text-danger">*</span>
                    </label>
                    <select name="payment_mode" id="payment_mode" class="form-select border-0 border-bottom" required>
                        <option value="" selected disabled>Choose Payment Method</option>
                        @foreach (\App\Models\Payment::getPaymentModes() as $mode)
                            <option value="{{ $mode }}">{{Str::replace('_',' ',$mode) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="bankAccNo">
                    <div class="mb-4">
                        <label
                            for="account_number"
                            class="form-label text-uppercase text-muted small mb-0"
                        >
                            Bank/Wallet Number
                        </label>
                        <input
                            type="text"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2"
                            id="account_number"
                            name="account_number"
                            placeholder="Enter Bank Account or Wallet Number"
                        />
                    </div>

                    <div class="mb-4">
                        <label for="payment_id" class="form-label text-uppercase text-muted small mb-0">
                            Payment Id
                        </label>
                        <input
                            type="text"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2"
                            id="payment_id"
                            name="payment_id"
                            placeholder="Enter Unique Payment ID (if applicable)"
                        />
                    </div>
                </div>
            </div>

            <div class="offcanvas-footer d-flex gap-3 p-3">
                <button
                    type="button"
                    class="btn btn-light text-primary w-100 text-uppercase btn-lg fw-bold"
                    data-bs-dismiss="offcanvas"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="btn btn-primary w-100 text-uppercase btn-lg fw-bold rounded-3"
                >
                    Submit
                </button>
            </div>
        </form>
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

            $('#payment_mode').change(function(){
                if($(this).val() == 'cash'){
                    $('.bankAccNo').hide();
                }else{
                    $('.bankAccNo').show();

                }
            })
        });
    </script>
@endpush
