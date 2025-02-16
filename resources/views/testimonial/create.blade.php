@extends('layout.master')
@section('main-content')
    @php
        define('PAGE', 'blog');
    @endphp

    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Add Testimonial</h5>
            </div>
        </div>
        <div class="card-body">
            <form
                action="{{ route('testimonials.store') }}"
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
                            value="{{ old('name') }}"
                            required
                        />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Company</label>
                        <input
                            type="text"
                            name="position"
                            class="form-control"
                            value="{{ old('position') }}"
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

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Feedback</label>
                        <textarea
                            type="text"
                            name="feedback"
                            class="form-control"
                            required
                        >
                          {{ old('feedback') }}
                      </textarea
                        >
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
