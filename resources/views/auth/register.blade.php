@php
    define('PAGE', 'home');
@endphp

@extends('frontend.layout.master')
@section('content')
    <section class="container">
        <div class="text-center mt-5">
            <h2 class="custom-fs-50 custom-fw-700">
                <span class="custom-text-secondary">Welcome to</span>
                <span class="custom-text-primary">Rumor Has It</span>
            </h2>
        </div>
        <div class="mt-5" style="max-width: 485px; margin: auto">
            <x-errormsg />
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div>
                    <label for="form-name" class="form-label custom-fs-16 custom-fw-400">
                        Name
                    </label>
                    <input
                        type="text"
                        id="form-name"
                        class="custom-br-0 custom-fw-400 form-control p-2 border custom-fs-16 border-2 custom-bc-secondary"
                        placeholder="Full Name"
                        required
                    />
                </div>
                <div class="my-3">
                    <label for="form-email" class="form-label custom-fs-16 custom-fw-400">
                        Email
                    </label>
                    <input
                        type="email"
                        id="form-email"
                        class="custom-br-0 custom-fw-400 form-control p-2 border custom-fs-16 border-2 custom-bc-secondary"
                        placeholder="Email Address"
                        required
                    />
                </div>
                <div class="my-3">
                    <label for="form-password" class="form-label custom-fs-16 custom-fw-400">
                        Password
                    </label>
                    <input
                        type="password"
                        id="form-password"
                        class="custom-br-0 custom-fw-400 form-control p-2 border custom-fs-16 border-2 custom-bc-secondary"
                        required
                    />
                </div>
                <div class="my-3">
                    <label for="form-password" class="form-label custom-fs-16 custom-fw-400">
                        Confirm Password
                    </label>
                    <input
                        type="password"
                        id="form-password"
                        class="custom-br-0 custom-fw-400 form-control p-2 border custom-fs-16 border-2 custom-bc-secondary"
                        name="password_confirmation"
                        required
                    />
                </div>

                <div class="text-center my-5">
                    <button
                        type="submit"
                        class="btn custom-fs-25 custom-fw-400 px-5 custom-bg-secondary custom-text-white"
                    >
                        Sign up
                    </button>
                </div>
            </form>
            <hr />
            <div class="d-flex mt-5">
                <a
                    href="{{ url('auth/google') }}"
                    class="btn custom-fs-16 custom-text-secondary custom-fw-400 px-4 custom-bg-white border-2 custom-bc-secondary"
                    style="width: 100%"
                >
                    sign up with Google
                </a>
                <span class="mx-2"></span>
                <a
                    href=""
                    class="btn custom-fs-16 custom-text-secondary custom-fw-400 px-4 custom-bg-white border-2 custom-bc-secondary"
                    style="width: 100%"
                >
                    sign up with Google
                </a>
            </div>
            <div class="text-center mt-4">
                <a
                    href="{{ route('login') }}"
                    class="custom-text-secondary custom-fs-16 custom-fw-400"
                >
                    Already have an account?
                </a>
            </div>
        </div>
    </section>
@endsection
