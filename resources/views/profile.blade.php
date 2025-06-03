@extends('layout.master')
@section('main-content')
    @php
        define('PAGE', 'profile');
    @endphp

    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Profile</h1>

        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card mb-3">
                    <div class="card-header bg-dark text-light">
                        <h5 class="card-title mb-0 text-light">Profile Details</h5>
                    </div>
                    <div class="card-body text-center">
                        <img
                            src="{{ getImage(Auth::user()->profile_photo_path) }}"
                            alt="{{Auth::user()->name}}"
                            class="img-fluid rounded-circle mb-2"
                            style="height: 100px;width:100px;border-radius:50%"
                        />
                        <h5 class="card-title mb-0">{{ Auth::user()->name }}</h5>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <input
                                type="submit"
                                class="btn btn-danger"
                                value="logout"
                                style="width: 200px"
                            />
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-xl-9">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-header bg-dark text-light">
                        <h3 class="mb-0 card-title text-light">Edit profile</h3>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('profile.update') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf

                            <div class="form-group">
                                <div class="file-upload-wrapper" data-text="Select your file!">
                                    <input
                                        name="file"
                                        type="file"
                                        class="file-upload-field"
                                        value=""
                                    />
                                </div>
                            </div>
                            <div class="form- mt-2">
                                <input
                                    type="text"
                                    value="{{ Auth::user()->name }}"
                                    class="form-control"
                                    name="name"
                                    required
                                />
                            </div>
                            <div class="form-group mt-2">
                                <input
                                    type="email"
                                    value="{{ Auth::user()->email }}"
                                    class="form-control"
                                    name="email"
                                    required
                                />
                            </div>
                            <div class="form-group mt-2">
                                <input
                                    type="text"
                                    value="updated at: {{ carbon\carbon::parse(Auth::user()->updated_at)->diffForHumans() }}"
                                    class="form-control"
                                    readonly
                                />
                            </div>
                            <div class="form-group mt-2">
                                <input
                                    type="submit"
                                    value="save"
                                    class="form-control btn btn-primary"
                                />
                            </div>
                        </form>
                    </div>
                    <hr />

                    <div class="card-header bg-dark text-light">
                        <h3 class="card-title text-light">Change Password</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('password') }}" method="POST">
                            @csrf
                            <div class="form-group mt-2">
                                <label for="">Current password</label>
                                <input
                                    type="password"
                                    value=""
                                    class="form-control"
                                    name="currentpassword"
                                    required
                                />
                            </div>
                            <div class="form-group mt-2">
                                <label for="">New password</label>
                                <input
                                    type="password"
                                    value=""
                                    class="form-control"
                                    name="newpassword"
                                    required
                                />
                            </div>
                            <div class="form-group mt-2">
                                <label for="">Confirm password</label>
                                <input
                                    type="password"
                                    value=""
                                    class="form-control"
                                    name="confirmpassword"
                                    required
                                />
                            </div>
                            <div class="form-group mt-2">
                                <input
                                    type="submit"
                                    value="save"
                                    class="form-control btn btn-primary"
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
