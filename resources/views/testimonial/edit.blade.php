@extends('layout.master')
@section('main-content')


    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Edit Testimonial</h5>
            </div>
        </div>
        <div class="card-body">
            <form
                action="{{ route('testimonials.update',$testimonial) }}"
                method="POST"
                enctype="multipart/form-data"
            >
            @method('PATCH')
                @csrf

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name',$testimonial->name) }}"
                            required
                        />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Company</label>
                        <input
                            type="text"
                            name="position"
                            class="form-control"
                            value="{{ old('position',$testimonial->position) }}"
                            required
                        />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Logo</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input
                                name="logo"
                                type="file"
                                class="file-upload-field"
                                value=""
                            />
                        </div>
                        <img src="{{getImage($testimonial->logo)}}" alt="" width="50">
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
                        <img src="{{getImage($testimonial->thumbnail)}}" alt="" width="50">

                    </div>

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Feedback</label>
                        <textarea
                            type="text"
                            name="feedback"
                            class="form-control"
                            required
                        >
                          {{ old('feedback',$testimonial->feedback) }}
                      </textarea
                        >
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
