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
            <form
                action="{{ route('banners.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="row">
                <div class="mb-3 col-md-4">
                    <label class="form-label">Banner Title</label>
                    <input name="title" class="form-control" value="{{ old('title') }}">
                </div>

                <div class="mb-3 col-md-4">
                    <label class="form-label">Type</label>
                    <select name="type" id="" class="form-control">
                        <option value="1">Slider 1</option>
                        <option value="2">Slider 2</option>
                        <option value="3">Slider 3</option>
                    </select>
                </div>
                @can ('do:anything')
                <div class="mb-3 col-md-4">
                    <label class="form-label">Is Homepage Banner</label>
                    <select name="is_homepage_banner" id="" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                @endif

                <div class="mb-3 col-md-4">
                    <label class="form-label">Banner image</label>
                    <div class="file-upload-wrapper" data-text="Select your file!">
                        <input
                            name="thumbnail"
                            type="file"
                            class="file-upload-field"
                            value=""
                            required
                        />
                    </div>
                </div>
            </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
@endsection
