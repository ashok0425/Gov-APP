@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Add new organization</h5>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('organizations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Organization name"
                               value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control form-select">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Publish</option>
                            <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Thumbnail <small class="text-info">(60&times;60 — the icon on the app's home grid)</small></label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="thumbnail" type="file" class="file-upload-field">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
@endsection
