@extends("layout.master")
@section("main-content")
    @php
        define("PAGE", "setting");
    @endphp

    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Edit Banner</h5>
            </div>
        </div>

        <div class="card-body">
            <form
                action="{{ route("banners.update", $banner) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @method('PATCH')
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Banner Title</label>
                        <input name="title" class="form-control" value="{!! $banner->title !!}"/>
                    </div>

                    @can('do:anything')
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Is Homepage Banner</label>
                        <select name="is_homepage_banner" id="is_homepage_banner" class="form-control form-select">
                            <option value="1" {{ $banner->is_homepage_banner ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$banner->is_homepage_banner ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    @endcan

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control form-select">
                            <option value="1" {{ old('status', $banner->status) == 1 ? 'selected' : '' }}>Publish</option>
                            <option value="0" {{ old('status', $banner->status) == 0 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    @can('do:anything')
                    <div class="mb-3 col-md-6" id="palika_selection_wrapper">
                        <label class="form-label">Select Palika</label>
                        <select name="business_id" class="form-control form-select" id="business_id">
                            <option value="">select Palika</option>
                            @foreach ($businesses as $business)
                                <option value="{{ $business->id }}" {{ $business->id == $banner->business_id ? 'selected' : '' }}>
                                    {{ $business->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endcan

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Banner image <small class="text-info">(1080&times;400 works best — keep every banner the same size)</small></label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="thumbnail" type="file" class="file-upload-field" />
                        </div>

                        @if (filled($banner->thumbnail))
                            <br />
                            <img src="{{ getImage($banner->thumbnail) }}" alt="" width="100" />
                            <label class="d-flex align-items-center small mb-0 mt-1">
                                <input type="checkbox" name="remove_thumbnail" value="1">
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

@push('scripts')
<script>
    function togglePalikaDropdown() {
        const isHomepage = document.getElementById('is_homepage_banner').value;
        const palikaWrapper = document.getElementById('palika_selection_wrapper');

        if (isHomepage === '1') {
            palikaWrapper.style.display = 'none';
        } else {
            palikaWrapper.style.display = 'block';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const isHomepageSelect = document.getElementById('is_homepage_banner');
        if (isHomepageSelect) {
            isHomepageSelect.addEventListener('change', togglePalikaDropdown);
            togglePalikaDropdown(); // run once on load
        }
    });
</script>
@endpush
