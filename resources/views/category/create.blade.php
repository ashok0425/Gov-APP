@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Add new category</h5>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Category"
                               value="{{ old('name') }}" required>
                    </div>

                    {{-- Whichever parent is picked decides the level: none makes a
                         main category, a category makes a subcategory, and a
                         subcategory makes a child category. --}}
                    <div class="mb-3 col-md-4">
                        <label class="form-label">
                            Parent
                            <small class="text-info">(leave empty to create a main category)</small>
                        </label>
                        <select name="parent_id" class="form-control form-select">
                            <option value="">— None (main category) —</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}"
                                    {{ (string) old('parent_id', $parentId) === (string) $parent->id ? 'selected' : '' }}>
                                    {{ $parent->pathName() }} → {{ \App\Models\Category::LEVEL_NAMES[$parent->level() + 1] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control form-select">
                            <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Publish</option>
                            <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Thumbnail</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="thumbnail" type="file" class="file-upload-field">
                        </div>
                    </div>
                </div>

                @include('category.partials.contact-fields', ['category' => null])

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
@endsection
