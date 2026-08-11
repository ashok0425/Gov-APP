@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Add new category</h5>
            </div>
        </div>

        <div class="card-body">
            <form
                action="{{ route('categories.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Category</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Category"
                            value="{{ old('name') }}"
                            required
                        />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">
                            Parent Category
                            <small class="text-info">(leave empty to create a main category)</small>
                        </label>
                        <select name="parent_id" class="form-control form-select">
                            <option value="">— None (main category) —</option>
                            @foreach ($parents as $parent)
                                <option
                                    value="{{ $parent->id }}"
                                    {{ (string) old('parent_id', $parentId) === (string) $parent->id ? 'selected' : '' }}
                                >
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
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
                </div>

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
@endsection
