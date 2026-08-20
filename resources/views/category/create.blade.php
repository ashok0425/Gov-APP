@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Add new {{ Str::lower(\App\Models\Category::LEVEL_NAMES[$level]) }}</h5>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Where the list said we came from, so saving lands back on
                     that page with its filters rather than at the top. --}}
                <input type="hidden" name="redirect_to" value="{{ request('back', url()->previous()) }}">
                {{-- Which level is being created — decides which parents are required. --}}
                <input type="hidden" name="level" value="{{ $level }}">

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control"
                               placeholder="{{ \App\Models\Category::LEVEL_NAMES[$level] }} name"
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
                        <label class="form-label">Thumbnail</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="thumbnail" type="file" class="file-upload-field">
                        </div>
                    </div>
                </div>

                {{-- A main category has no parent to pick, so no cascade at all.
                     A subcategory asks for its category; a child category asks
                     for both — and they are required, not optional. --}}
                @if ($level > 1)
                    @include('category.partials.parent-cascade', [
                        'levels' => $level - 1,
                        'requiredDepth' => $level - 1,
                    ])
                @endif

                @include('category.partials.cover-fields', ['category' => null])

                @if ($level > 1)
                    @include('category.partials.contact-fields', ['category' => null])
                @endif

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>

    @push('scripts')
        @include('partials.select2-assets')
        @include('partials.category-cascade-script')
    @endpush
@endsection
