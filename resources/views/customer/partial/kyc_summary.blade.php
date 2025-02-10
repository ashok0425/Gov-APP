<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">KYC Details Summary</h5>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-4">Full Name</dt>
            <dd class="col-sm-8">{{ $user->name }}</dd>

            <dt class="col-sm-4">Phone Number</dt>
            <dd class="col-sm-8">{{ $user->phone }}</dd>

            <dt class="col-sm-4">Email Address</dt>
            <dd class="col-sm-8">{{ $user->email }}</dd>

            <dt class="col-sm-4">Address</dt>
            <dd class="col-sm-8">{{ $user->address }}</dd>

            <dt class="col-sm-4">City</dt>
            <dd class="col-sm-8">{{ $user->city }}</dd>

            <dt class="col-sm-4">State</dt>
            <dd class="col-sm-8">{{ $user->state }}</dd>

            <dt class="col-sm-4">Bank Name</dt>
            <dd class="col-sm-8">{{ $user->bank_name }}</dd>

            <dt class="col-sm-4">Bank Account No</dt>
            <dd class="col-sm-8">{{ $user->account_no }}</dd>

            <dt class="col-sm-4">Account Holder Name</dt>
            <dd class="col-sm-8">{{ $user->account_holder }}</dd>

            <dt class="col-sm-4">ID Info</dt>
            <dd class="col-sm-8">{{ $user->id_info }}</dd>

            <dt class="col-sm-4">ID Proof</dt>
            <dd class="col-sm-8">
                @if ($user->id_proof)
                    <a href="{{ asset('storage/' . $user->id_proof) }}" target="_blank">
                        View ID Proof
                    </a>
                @else
                    Not provided
                @endif
            </dd>
        </dl>
    </div>
</div>
