@extends('layout.master')
@section('main-content')
    @php
        define('PAGE', 'setting');
    @endphp

    <div class="card">
        <h3>Add Banner</h3>

        <div class="card-body">
            <form
                action="{{ route('banner.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="mb-3">
                    <label class="form-label">Banner Title</label>
                    <textarea name="title" id="summernote1" class="form-control">
                 {{ old('title') }}
             </textarea
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" id="" class="form-control">
                        <option value="0">Large banner</option>
                        <option value="1">Shop banner</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Banner image</label>
                    <div class="file-upload-wrapper" data-text="Select your file!">
                        <input
                            name="file"
                            type="file"
                            class="file-upload-field"
                            value=""
                            required
                        />
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
@endsection
