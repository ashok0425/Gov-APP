@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Edit organization</h5>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('organizations.update', $organization) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Organization name"
                               value="{{ old('name', $organization->name) }}" required>
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control form-select">
                            <option value="1" {{ old('status', (int) $organization->status) == 1 ? 'selected' : '' }}>Publish</option>
                            <option value="0" {{ old('status', (int) $organization->status) == 0 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Thumbnail <small class="text-info">(60&times;60 — the icon on the app's home grid)</small></label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="thumbnail" type="file" class="file-upload-field">
                        </div>

                        @if (filled($organization->thumbnail))
                            <br>
                            <img src="{{ getImage($organization->thumbnail) }}" alt="{{ $organization->name }}" width="100">
                            <label class="d-flex align-items-center small mb-0 mt-1">
                                <input type="checkbox" name="remove_thumbnail" value="1">
                                <span class="mx-2 text-danger">remove</span>
                            </label>
                        @endif
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">
                            Top image
                            <small class="text-info">(960&times;210 — the strip at the top of this organization's screen, back arrow over it; empty keeps the plain title bar)</small>
                        </label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="top_image" type="file" class="file-upload-field" accept="image/*">
                        </div>

                        @if (filled($organization->top_image))
                            <br>
                            <img src="{{ getImage($organization->top_image) }}" alt="" width="200">
                            <label class="d-flex align-items-center small mb-0 mt-1">
                                <input type="checkbox" name="remove_top_image" value="1">
                                <span class="mx-2 text-danger">remove</span>
                            </label>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
