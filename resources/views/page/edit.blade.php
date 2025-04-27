@extends('layout.master')
@section('main-content')

  <div class="card">
    <div class="card-header d-flex justify-content-between bg-dark">
        <div>
          <h5 class="card-title text-white">Edit Page</h5>
        </div>
    </div>
    <div class="card-body">
      <form action="{{ route('pages.update',$page) }}" method="POST" enctype="multipart/form-data">
        @csrf
          @method('PATCH')
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Name</label>
                <input
                  type="text"
                  name="name"
                  class="form-control"
                  placeholder="page name"
                  value="{{ old('name',$page->name) }}"
                  required
                />
              </div>

              <div class="mb-3 col-md-6">
                <label class="form-label">Slug</label>
                <input
                  type="text"
                  name="slug"
                  class="form-control"
                  placeholder="page slug"
                  value="{{ old('slug',$page->slug) }}"
                  required
                />
              </div>

              {{-- <div class="mb-3 col-md-6">
                <label class="form-label">Title</label>
                <input
                  type="text"
                  name="title"
                  class="form-control"
                  placeholder="Page title"
                  value="{{ old('title',$page->title) }}"
                  required
                />
              </div> --}}


              <div class="mb-3 col-md-12  px-5">
                <label class="form-label">Long Description</label>
                <textarea
                  type="text"
                  name="description"
                  id="summernote"
                  class="form-control"
                  placeholder="Post Description"
                  required
                >{{ old('description',$page->description) }}
                      </textarea
                >
              </div>

              </div>
        </div>
  </div>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
  </div>
@endsection
