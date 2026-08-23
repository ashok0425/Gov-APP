@extends('layout.master')
@section('main-content')
    @php
        define('PAGE', 'setting');
    @endphp

    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Add Banner</h5>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="{{ request()->query('type') }}">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Banner Title</label>
                        <input name="title" class="form-control" value="{{ old('title') }}">
                    </div>

                    @can('do:anything')
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Is Homepage Banner</label>
                            <select name="is_homepage_banner" id="is_homepage_banner" class="form-control form-select">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    @endcan

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control form-select">
                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Publish</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    @can('do:anything')
                        <div class="mb-3 col-md-6" id="palika-dropdown">
                            <label class="form-label">Select Palika</label>
                            <select name="business_id" class="form-control form-select" >
                                <option value="">Select Palika</option>
                                @foreach ($businesses as $business)
                                    <option value="{{ $business->id }}">{{ $business->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endcan

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Banner image <small class="text-info">(1080&times;400 works best — keep every banner the same size)</small></label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="thumbnail" type="file" class="file-upload-field" required />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function togglePalikaDropdown() {
                const isHomepage = document.getElementById('is_homepage_banner').value;
                const palikaDropdown = document.getElementById('palika-dropdown');
                if (isHomepage === "1") {
                    palikaDropdown.style.display = 'none';
                } else {
                    palikaDropdown.style.display = 'block';
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const isHomepageField = document.getElementById('is_homepage_banner');
                if (isHomepageField) {
                    togglePalikaDropdown(); // Initial check
                    isHomepageField.addEventListener('change', togglePalikaDropdown);
                }
            });
        </script>
    @endpush
@endsection
