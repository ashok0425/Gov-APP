@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Edit ward</h5>
            </div>
        </div>

        <div class="card-body">
            <form
                action="{{ route('business.update',$business) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Enter name"
                            value="{{ old('name',$business->name) }}"
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
                            value="{{ old('phone',$business->phone) }}"
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
                            value="{{ old('address',$business->address) }}"
                            required
                        />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Order</label>
                        <input
                            type="number"
                            name="order"
                            class="form-control"
                            placeholder="Enter Ward Order"
                            value="{{ old('order',$business->business_order) }}"
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
                        <img src="{{getImage($business->thumbnail)}}" alt="" class="img-fluid" width="100">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Cover Image</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input
                                name="cover_image"
                                type="file"
                                class="file-upload-field"
                                value=""
                            />
                        </div>
                        <img src="{{getImage($business->cover_image)}}" alt="" class="img-fluid" width="100">

                    </div>



                </div>

                <button type="submit" class="btn btn-primary">save</button>
            </form>
        </div>
    </div>

@endsection

