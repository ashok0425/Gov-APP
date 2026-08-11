@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Add New Post</h5>
            </div>
        </div>
        <div class="card-body">
            <form
                action="{{ route('blogs.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Title</label>
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            placeholder="Post title"
                            value="{{ old('title') }}"
                            required
                        />
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Select Category</label>
                        <select name="category" id="category-select" class="form-control form-select" required>
                           <option value="">select category</option>
                           @foreach ($categories as $category)
                           <option value="{{$category->id}}" {{ old('category') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                           @endforeach
                        </select>
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Select Subcategory <small class="text-info">(optional)</small></label>
                        <select name="subcategory" id="subcategory-select" class="form-control form-select" data-selected="{{ old('subcategory') }}">
                           <option value="">select subcategory</option>
                        </select>
                    </div>

                    @if(!auth()->user()->business_id)
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Select Palika</label>
                        <select name="business_id" id="" class="form-control form-select" >
                           <option value="">select Palika</option>
                           @foreach ($businesses as $business)
                           <option value="{{$business->id}}" {{ old('business_id') == $business->id ? 'selected' : '' }}>{{$business->name}}</option>
                           @endforeach
                        </select>
                    </div>
                     @endif

                    <div class="form-group col-md-4 mb-3">
                        <label for="status">Post Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{old('status') == 1 ? 'selected' : '' }}>Publish</option>
                            <option value="0" {{ old('status')  == 0 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4 mb-3 d-flex align-items-end">
                        <label class="d-flex align-items-center">
                            <input type="hidden" name="is_breaking" value="0">
                            <input type="checkbox" name="is_breaking" value="1" style="transform: scale(1.5)"
                                {{ old('is_breaking') ? 'checked' : '' }}>
                            <span class="mx-3">
                                Breaking news
                                <small class="text-info d-block">(show in the home page carousel)</small>
                            </span>
                        </label>
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
                    </div> --}}

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Short Description</label>
                        <textarea
                            type="text"
                            name="short_description"
                            class="form-control"
                            placeholder="Post Detail"
                            style="padding: 0;margin:0"
                            required

                        >
                          {{ old('short_description') }}
                      </textarea
                        >
                    </div>

                    <div class="mb-3 col-md-12  px-5">
                        <label class="form-label">Long Description</label>
                        <textarea
                            type="text"
                            name="long_description"
                            id="summernote"
                            class="form-control"
                            placeholder="Post Description"
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

@push('scripts')
    @include('blog.partials.subcategory-script', ['subcategoryMap' => $subcategoryMap])
@endpush
