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
                        <label class="form-label">Order</label>
                        <input
                            type="number"
                            name="order"
                            class="form-control"
                            placeholder="Enter Ward Order"
                            value="{{ old('order') }}"
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
                        <label class="form-label">Cover Image</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input
                                name="cover_image"
                                type="file"
                                class="file-upload-field"
                                value=""
                            />
                        </div>
                    </div>
<div class="col-12">
    <label for="">Category</label>
    <select name="category[]" id="" class="form-control from-select select2" multiple="multiple">
        @foreach ($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
    </select>
</div>


                </div>

              <div class="mt-4">
                <button type="submit" class="btn btn-primary">Add</button>
              </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
    $('.select2').select2();
});
</script>
@endpush
