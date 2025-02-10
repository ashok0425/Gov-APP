@extends('customer.layout.master')

@section('content')
    <div class="cart d-flex flex-column vh-100">
        @include('customer.layout.mini-header', ['title' => 'Profile', 'subtitle' => 'Manage your personal information'])
        <div class="my-auto vh-100 overflow-auto p-3">
            <form method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="form-label text-uppercase text-muted small mb-0">
                        Name
                    </label>
                    <input
                        type="text"
                        class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('name') is-invalid @enderror"
                        id="name"
                        name="name"
                        placeholder="Name"
                        required
                        value="{{ old('name', auth()->user()->name) }}"
                    />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="phone" class="form-label text-uppercase text-muted small mb-0">
                        Phone Number
                    </label>
                    <input
                        type="tel"
                        class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('phone') is-invalid @enderror"
                        id="phone"
                        name="phone"
                        placeholder="Phone Number"
                        required
                        value="{{ old('phone', auth()->user()->phone) }}"
                    />
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label text-uppercase text-muted small mb-0">
                        Email Address
                    </label>
                    <input
                        type="email"
                        class="form-control bg-transparent border-0 rounded-0 border-bottom px-0 py-2 @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        placeholder="Email"
                        required
                        value="{{ old('email', auth()->user()->email) }}"
                    />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="btn btn-primary w-100 mt-3 text-uppercase btn-lg fw-bold col rounded-3"
                >
                    Update
                </button>
            </form>
        </div>
    </div>
@endsection
