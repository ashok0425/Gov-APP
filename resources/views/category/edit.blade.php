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
                {{-- The record keeps its level — decides which parents are required. --}}
                <input type="hidden" name="level" value="{{ $level }}">
                @method('PATCH')

                <div class="row">
                    @if ($level === 1)
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Organization</label>
                            <select name="organization" class="form-control form-select" required>
                                <option value="">select organization</option>
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}"
                                        {{ old('organization', $category->organization_id) == $organization->id ? 'selected' : '' }}>
                                        {{ $organization->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Category"
                               value="{{ old('name', $category->name) }}" required>
                    </div>

                    <div class="mb-3 col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control form-select" required>
                            <option value="1" {{ old('status', (int) $category->status) == 1 ? 'selected' : '' }}>Publish</option>
                            <option value="0" {{ old('status', (int) $category->status) == 0 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Thumbnail <small class="text-info">(60&times;60 — the icon on the menu grid)</small></label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="thumbnail" type="file" class="file-upload-field">
                        </div>
                        <br>
                        <img src="{{ getImage($category->thumbnail) }}" alt="{{ $category->name }}" width="100">
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">
                            Top image
                            <small class="text-info">(960&times;210 — the strip at the top of this category's screen, back arrow over it; empty keeps the plain title bar)</small>
                        </label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="top_image" type="file" class="file-upload-field" accept="image/*">
                        </div>

                        @if (filled($category->top_image))
                            <br>
                            <img src="{{ getImage($category->top_image) }}" alt="" width="200">
                            <label class="d-flex align-items-center small mb-0 mt-1">
                                <input type="checkbox" name="remove_top_image" value="1">
                                <span class="mx-2 text-danger">remove</span>
                            </label>
                        @endif
                    </div>
                </div>

                {{-- Only the levels above this record, and they are required —
                     editing a subcategory asks for its category, nothing more. --}}
                @if ($level > 1)
                    @include('category.partials.parent-cascade', [
                        'levels' => $level - 1,
                        'requiredDepth' => $level - 1,
                        'organizations' => $organizations,
                        'selectedOrganization' => $parentOrganization,
                    ])
                @endif

                @include('category.partials.cover-fields', ['category' => $category])

                @include('category.partials.contact-fields', ['category' => $category])

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    @push('scripts')
        @include('partials.select2-assets')
        @include('partials.category-cascade-script')
    @endpush
@endsection
