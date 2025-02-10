@extends('admin.layout.master')
@section('main-content')
    @php
        define('PAGE', 'blog');
    @endphp

    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Add New Blog</h5>
            </div>
        </div>
        <div class="card-body">
            <form
                action="{{ route('admin.blogs.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Title</label>
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            placeholder="Blog title"
                            value="{{ old('title') }}"
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

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Short Description</label>
                        <textarea
                            type="text"
                            name="short_description"
                            class="form-control"
                            placeholder="Blog Detail"
                            required
                        >
                          {{ old('short_description') }}
                      </textarea
                        >
                    </div>

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Long Description</label>
                        <textarea
                            type="text"
                            name="long_description"
                            id="summernote"
                            class="form-control"
                            placeholder="Blog Description"
                            required
                        >
{{ old('long_description') }}
                      </textarea
                        >
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
