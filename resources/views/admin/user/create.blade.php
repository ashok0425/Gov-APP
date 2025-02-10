@extends('admin.layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Add new user</h5>
            </div>
        </div>

        <div class="card-body">
            <form
                action="{{ route('admin.users.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Enter name"
                            value="{{ old('name') }}"
                            required
                        />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Phone</label>
                        <input
                            type="number"
                            name="phone"
                            class="form-control"
                            placeholder="Enter phone number"
                            value="{{ old('phone') }}"
                            required
                        />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter Email Address"
                            value="{{ old('email') }}"
                            required
                        />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Thumbnail</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input
                                name="thumbnail"
                                type="file"
                                class="file-upload-field"
                                value=""
                            />
                        </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter password"
                            value="{{ old('password') }}"
                            required
                        />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Re-type password</label>
                        <input
                            type="password"
                            name="confirm_password"
                            class="form-control"
                            placeholder="Confirm password"
                            value="{{ old('confirm_password') }}"
                            required
                        />
                    </div>

                    <div class="form-group col-md-6 mb-3">
                        <label class="form-label">Location</label>
                        <select name="location" id="" class="form-control" required>
                            <option value="">Select Location</option>
                            @foreach(App\Models\Location::all() as $location)
                            <option value="{{$location->id}}" >{{$location->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
@endsection
