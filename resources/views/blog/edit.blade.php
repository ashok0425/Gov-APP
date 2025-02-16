@extends('layout.master')
@section('main-content')

  <div class="card">
    <div class="card-header">
      <h5 class="card-title">Edit Blog</h5>
    </div>
    <div class="card-body">
      <form
        action="{{ route('blogs.update', $blog) }}"
        method="POST"
        enctype="multipart/form-data"
      >
        @csrf
          @method('PATCH')
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input
            type="text"
            name="title"
            class="form-control"
            placeholder="Blog title"
            value="{{ $blog->title }}"
            required
          />
        </div>
        <div class="card-body">
            <form
                action="{{ route('blogs.update', $blog) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

        <div class="mb-3">
          <label class="form-label">Short Description</label>
          <textarea
            type="text"
            name="short_description"
            class="form-control"
            placeholder="Blog Detail"
            required
          >
                    {{ $blog->short_description }}
                </textarea
          >
        </div>
        <div class="mb-3">
          <label class="form-label">Long Description</label>
          <textarea
            type="text"
            name="long_description"
            id="summernote"
            class="form-control"
            placeholder="Blog Detail"
            required
          >
                    {!! $blog->long_description !!}
                </textarea
                    >
                </div>
                <div class="mb-3">
                    <label class="form-label">Thumbnail</label>
                        <input name="thumbnail" type="file" class="file-upload-field" class="form-control" />
                    <br />
                    <img
                        src="{{ getImage($blog->thumbnail) }}"
                        alt=""
                        class="img-fluid"
                        width="100"
                    />
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
