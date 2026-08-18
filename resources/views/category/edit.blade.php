@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Edit {{ $category->levelName() }} — {{ $category->pathName() }}</h5>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Where the list said we came from, so saving lands back on
                     that page with its filters rather than at the top. --}}
                <input type="hidden" name="redirect_to" value="{{ request('back', url()->previous()) }}">
                @method('PATCH')

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Category"
                               value="{{ old('name', $category->name) }}" required>
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Parent</label>
                        <select name="parent_id" class="form-control form-select">
                            <option value="">— None (main category) —</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}"
                                    {{ (string) old('parent_id', $category->parent_id) === (string) $parent->id ? 'selected' : '' }}>
                                    {{ $parent->pathName() }} → {{ \App\Models\Category::LEVEL_NAMES[$parent->level() + 1] }}
                                </option>
                            @endforeach
                        </select>
                        {{-- Anything deep enough already has nowhere left to move to. --}}
                        @if ($parents->isEmpty())
                            <small class="text-info">
                                Nothing can hold this one without pushing the menu past
                                {{ \App\Models\Category::MAX_DEPTH }} levels, so it stays where it is.
                            </small>
                        @endif
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control form-select" required>
                            <option value="1" {{ old('status', (int) $category->status) == 1 ? 'selected' : '' }}>Publish</option>
                            <option value="0" {{ old('status', (int) $category->status) == 0 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Thumbnail</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="thumbnail" type="file" class="file-upload-field">
                        </div>
                        <br>
                        <img src="{{ getImage($category->thumbnail) }}" alt="{{ $category->name }}" width="100">
                    </div>
                </div>

                @include('category.partials.contact-fields', ['category' => $category])

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
