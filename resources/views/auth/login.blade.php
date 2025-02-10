@extends('layouts.minimal')
@section('content')
    <div class="py-5">
        <section class="container">
            <div class="text-center mt-5">
                {{-- <img src="{{getImage(cms('logo'))}}" alt="Drebba.com" width="100"> --}}
                <h2 class="fw-bold mb-4">
                    <span class="text-secondary">Welcome to</span>
                    <span class="text-primary">Drebba</span>
                </h2>
            </div>
            <div class="mt-5" style="max-width: 485px; margin: auto">
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-center text-success">
                        {{ session('status') }}
                    </div>
                @elseif ($errors->any())
                    <div class="mb-4 font-medium text-sm text-center text-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="form-email" class="form-label">Phone</label>
                        <input
                            type="number"
                            id="form-email"
                            class="form-control"
                            placeholder="Enter phone number"
                            name="phone"
                            value="{{ old('phone') }}"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label for="form-password" class="form-label">Password</label>
                        <input
                            type="password"
                            id="form-password"
                            class="form-control"
                            name="password"
                            placeholder="password"
                            required
                        />
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="remember_me"
                                name="remember"
                            />
                            <label class="form-check-label" for="remember_me">Remember me</label>
                        </div>

                            <a href="{{ route('password.request') }}" class="text-primary">
                            Forgot password?
                            </a>

                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Log in</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <x-open-inmobile-view/>

@endsection

