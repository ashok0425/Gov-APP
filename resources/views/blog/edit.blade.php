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
                {{-- Where the list said we came from, so saving lands back on
                     that page with its filters rather than at the top. --}}
                <input type="hidden" name="redirect_to" value="{{ request('back', url()->previous()) }}">

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

                    @include('partials.category-cascade', [
                        'categoryTree' => $categoryTree,
                        'selected' => $selectedTrail,
                        'required' => true,
                        'columns' => 3,
                    ])

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

                    <div class="col-md-3 mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control form-select">
                            <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Publish</option>
                            <option value="0" {{ $post->status == 0 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <label class="d-flex align-items-center">
                            <input type="hidden" name="is_breaking" value="0">
                            <input type="checkbox" name="is_breaking" value="1" style="transform: scale(1.5)"
                                {{ old('is_breaking', $post->is_breaking) ? 'checked' : '' }}>
                            <span class="mx-3">
                                Breaking news
                                <small class="text-info d-block">(show in the home page carousel)</small>
                            </span>
                        </label>
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

@push('scripts')
    @include('partials.select2-assets')
    @include('partials.category-cascade-script')
@endpush
