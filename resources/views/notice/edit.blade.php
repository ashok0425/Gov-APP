@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Edit Notification</h5>
            </div>
            <div>
                <a href="{{ route('notices.index') }}" class="btn btn-info btn-sm">Back</a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('notices.update', $notice) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="mb-3 col-md-8">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title', $notice->title) }}" required>
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Send On <small class="text-info">(optional)</small></label>
                        <input type="datetime-local" name="published_at" class="form-control"
                               value="{{ old('published_at', $notice->published_at?->format('Y-m-d\TH:i')) }}">
                        <small class="text-muted">Leave empty to date it from when it was saved.</small>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label class="form-label">Short Description</label>
                        <input type="text" name="short_description" class="form-control"
                               value="{{ old('short_description', $notice->short_description) }}">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Link <small class="text-info">(optional)</small></label>
                        <input type="url" name="link" class="form-control"
                               value="{{ old('link', $notice->link) }}">
                    </div>

                    <div class="mb-3 col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control form-select">
                            <option value="1" {{ old('status', (int) $notice->status) == 1 ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ old('status', (int) $notice->status) == 0 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="mb-3 col-md-3">
                        <label class="form-label">Image <small class="text-info">(optional)</small></label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="thumbnail" type="file" class="file-upload-field">
                        </div>
                        @if ($notice->thumbnail)
                            <img src="{{ getImage($notice->thumbnail) }}" alt="" width="100" class="mt-2">
                        @endif
                    </div>

                    <div class="mb-3 col-md-12 px-5">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="summernote"
                                  class="form-control">{{ old('description', $notice->description) }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
