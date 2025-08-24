@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Edit Post</h5>
            </div>
        </div>
        <div class="card-body">
            <form
                action="{{ route('blogs.update',$post) }}"
                method="POST"
                enctype="multipart/form-data"
            >
            @method('PATCH')
                @csrf

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Title</label>
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            placeholder="Post title"
                            value="{{ old('title',$post->title) }}"
                            required
                        />
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Select Category</label>
                        <select name="category" id="" class="form-control form-select" required>
                           <option value="">select category</option>
                           @foreach ($categories as $category)
                           <option value="{{$category->id}}" {{$category->id==$post->category_id?'selected':''}}>{{$category->name}}</option>
                           @endforeach
                        </select>
                    </div>

                   @if(!auth()->user()->business_id)
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Select Ward  <small class="text-info">(Not selecting ward will be consider as Gaupalika Post)</small></label>
                        <select name="business_id" id="" class="form-control form-select">
                           <option value="">select Ward</option>
                           @foreach ($businesses as $business)
                           <option value="{{$business->id}}" {{$business->id==$post->business_id?'selected':''}}>{{$business->name}}</option>
                           @endforeach
                        </select>
                    </div>
                    @endif

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
                        <img src="{{getImage($post->thumbnail)}}" alt="" width="100">
                    </div>

                    {{--<div class="mb-3 col-md-6">
                        <label class="form-label">Cover Photo (optional)</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input
                                name="cover"
                                type="file"
                                class="file-upload-field"
                                value=""
                            />
                        </div>
                        <img src="{{getImage($post->cover)}}" alt="" width="100">

                    </div> --}}

                    <div class="col-md-6 mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control form-select">
                            <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Publish</option>
                            <option value="0" {{ $post->status == 0 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>


                    <div class="mb-3 col-md-12">
                        <label class="form-label">Short Description</label>
                        <textarea
                            type="text"
                            name="short_description"
                            class="form-control"
                            placeholder="Post Detail"
                            required
                            rows="2"
                        >
                          {{ old('short_description',$post->short_description) }}
                      </textarea
                        >
                    </div>

                    <div class="mb-3 col-md-12 px-5" >
                        <label class="form-label">Long Description</label>
                        <textarea
                            type="text"
                            name="long_description"
                            id="summernote"
                            class="form-control"
                            placeholder="Post Description"
                            required
                        >
{{ old('long_description',$post->long_description) }}
                      </textarea
                        >
                    </div>


                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
