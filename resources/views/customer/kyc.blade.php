@extends('customer.layout.master')

@section('content')
    <div class="cart d-flex flex-column vh-100">
        @include('customer.layout.mini-header', ['title' => 'KYC', 'subtitle' => 'Know Your Customer Verification'])
        <div class="my-auto vh-100 overflow-auto p-3">
            <!-- KYC Status Display -->
            @if (auth()->user()->canStartOrContinueKyc())
                <div class="alert alert-info mb-4">
                    <h5 class="alert-heading">
                        KYC Status:
                        {{ ucfirst(str_replace('_', ' ', auth()->user()->kyc_status)) }}
                    </h5>
                    @if (auth()->user()->kyc_remarks)
                        <p class="mb-0">Remarks: {{ auth()->user()->kyc_remarks }}</p>
                    @endif
                </div>
            @endif

            @if (auth()->user()->canStartOrContinueKyc() || request()->has('edit'))
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label
                            for="fullName"
                            class="form-label text-uppercase text-muted small mb-0"
                        >
                            Full Name
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('fullName') is-invalid @enderror"
                            id="fullName"
                            name="fullName"
                            placeholder="Enter your full name"
                            value="{{ old('fullName', auth()->user()->name) }}"
                            required
                            minlength="2"
                            maxlength="100"
                            pattern="[A-Za-z\s]+"
                        />
                        @error('fullName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="form-label text-uppercase text-muted small mb-0">
                            Phone Number
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="tel"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('phone') is-invalid @enderror"
                            id="phone"
                            name="phone"
                            placeholder="Enter your phone number"
                            value="{{ old('phone', auth()->user()->phone) }}"
                            required
                            pattern="^\+?[0-9]{10,14}$"
                        />
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label text-uppercase text-muted small mb-0">
                            Email Address
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="email"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            placeholder="Enter your email address"
                            value="{{ old('email', auth()->user()->email) }}"
                            required
                        />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label
                            for="address"
                            class="form-label text-uppercase text-muted small mb-0"
                        >
                            Address
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('address') is-invalid @enderror"
                            id="address"
                            name="address"
                            placeholder="Enter your address"
                            value="{{ old('address', auth()->user()->address) }}"
                            required
                            minlength="5"
                            maxlength="200"
                        />
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="city" class="form-label text-uppercase text-muted small mb-0">
                            City
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('city') is-invalid @enderror"
                            id="city"
                            name="city"
                            placeholder="Enter your city"
                            value="{{ old('city', auth()->user()->city) }}"
                            required
                            minlength="2"
                            maxlength="100"
                        />
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="state" class="form-label text-uppercase text-muted small mb-0">
                            State
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('state') is-invalid @enderror"
                            id="state"
                            name="state"
                            placeholder="Enter your state"
                            value="{{ old('state', auth()->user()->state) }}"
                            required
                            minlength="2"
                            maxlength="100"
                        />
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label
                            for="bank_name"
                            class="form-label text-uppercase text-muted small mb-0"
                        >
                            Bank Name
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('bank_name') is-invalid @enderror"
                            id="bank_name"
                            name="bank_name"
                            placeholder="Enter your bank name"
                            value="{{ old('bank_name', auth()->user()->bank_name) }}"
                            required
                            minlength="2"
                            maxlength="100"
                        />
                        @error('bank_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label
                            for="account_no"
                            class="form-label text-uppercase text-muted small mb-0"
                        >
                            Bank Account No
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('account_no') is-invalid @enderror"
                            id="accountNo"
                            name="account_no"
                            placeholder="Enter your bank account number"
                            value="{{ old('account_no', auth()->user()->account_no) }}"
                            required
                            pattern="[0-9]+"
                            minlength="8"
                            maxlength="20"
                        />
                        @error('account_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label
                            for="accountHolder"
                            class="form-label text-uppercase text-muted small mb-0"
                        >
                            Account Holder Name
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('account_holder') is-invalid @enderror"
                            id="accountHolder"
                            name="account_holder"
                            placeholder="Enter account holder's full name"
                            value="{{ old('account_holder', auth()->user()->account_holder) }}"
                            required
                            minlength="2"
                            maxlength="100"
                            pattern="[A-Za-z\s]+"
                        />
                        @error('account_holder')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="idInfo" class="form-label text-uppercase text-muted small mb-0">
                            Your ID Info (PAN, citizenship number, etc.)
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('id_info') is-invalid @enderror"
                            id="idInfo"
                            name="id_info"
                            placeholder="Enter your identification number"
                            value="{{ old('id_info', auth()->user()->id_info) }}"
                            required
                            minlength="5"
                            maxlength="20"
                        />
                        @error('id_info')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="idProof"
                            class="form-label text-uppercase text-muted small mb-0"
                        >
                            ID Proof
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="file"
                            class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('id_proof') is-invalid @enderror"
                            id="idProof"
                            name="id_proof"
                            accept=".pdf,.jpg,.jpeg,.png"
                            required
                        />
                        <small class="form-text text-muted">
                            Upload a clear picture of your ID (PAN card, citizenship card, etc.)
                        </small>
                        @error('id_proof')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary w-100 mt-3 text-uppercase btn-lg fw-bold col rounded-3"
                    >
                        {{ request()->has('edit') ? 'Update KYC' : 'Submit KYC' }}
                    </button>
                </form>
            @else
                @if (auth()->user()->kycUnderReview())
                    <div class="alert alert-warning">
                        <h5 class="alert-heading">KYC Under Review</h5>
                        <p>
                            Your KYC application is currently being reviewed. We'll notify you once
                            the process is complete.
                        </p>
                    </div>
                @elseif (auth()->user()->hasCompletedKyc())
                    <div class="alert alert-success">
                        <h5 class="alert-heading">KYC Approved</h5>
                        <p>
                            Your KYC has been approved. Thank you for completing the verification
                            process.
                        </p>
                    </div>
                @elseif (auth()->user()->kycRequiresAction())
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Action Required</h5>
                        <p>
                            Your KYC application requires further action. Please review the remarks
                            and resubmit your information.
                        </p>

                        <p>
                            <b>Remarks:</b>
                            {{ auth()->user()->kyc_remarks }}
                        </p>
                    </div>
                @endif

                @include('customer.partial.kyc_summary', ['user' => auth()->user()])

                <a
                    href="{{ route('kyc', ['edit' => 'true']) }}"
                    class="btn btn-primary w-100 mt-3 text-uppercase btn-lg fw-bold col rounded-3"
                >
                    Edit KYC
                </a>
            @endif
        </div>
    </div>
@endsection
