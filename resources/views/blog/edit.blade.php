@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Edit Blog</h5>
            </div>
        </div>
        <div class="card-body">
            <form
                action="{{ route('blogs.update',$blog) }}"
                method="POST"
                enctype="multipart/form-data"
            >
            @method('PATCH')
                @csrf

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Title</label>
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            placeholder="Blog title"
                            value="{{ old('title',$blog->title) }}"
                            required
                        />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Select Category</label>
                        <select name="category" id="" class="form-control form-select" required>
                           <option value="">select category</option>
                           @foreach (App\Models\Category::all() as $category)
                           <option value="{{$category->id}}" {{$category->id==$blog->category_id?'selected':''}}>{{$category->name}}</option>
                           @endforeach
                        </select>
                    </div>

                    @can('do:anything')
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Select Ward</label>
                        <select name="business_id" id="" class="form-control form-select" required>
                           <option value="">select Ward</option>
                           @foreach (App\Models\Business::all() as $business)
                           <option value="{{$business->id}}" {{$business->id==$blog->business_id?'selected':''}}>{{$business->name}}</option>
                           @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Thumbnail</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input
                                name="thumbnail"
                                type="file"
                                class="file-upload-field"
                                value=""
                            />
                        </div>
                        <img src="{{getImage($blog->thumbnail)}}" alt="" width="100">
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Cover Photo (optional)</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input
                                name="cover"
                                type="file"
                                class="file-upload-field"
                                value=""
                            />
                        </div>
                        <img src="{{getImage($blog->cover)}}" alt="" width="100">

                    </div>

                    <div class="form-group col-md-4 mb-3 mb-3">
                        <label><input name="status" type="checkbox" style="transform: scale(2)" {{$user->status?'checked':''}} >  Hide Post</label>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Short Description</label>
                        <textarea
                            type="text"
                            name="short_description"
                            class="form-control"
                            placeholder="Blog Detail"
                            required
                            rows="2"
                        >
                          {{ old('short_description',$blog->short_description) }}
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
{{ old('long_description',$blog->long_description) }}
                      </textarea
                        >
                    </div>


                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
