@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Add new ward</h5>
            </div>
        </div>

        <div class="card-body">
            <form
                action="{{ route('business.store') }}"
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
                        <label class="form-label">Address</label>
                        <input
                            type="text"
                            name="address"
                            class="form-control"
                            placeholder="Enter Address"
                            value="{{ old('address') }}"
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



                </div>

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
@endsection
