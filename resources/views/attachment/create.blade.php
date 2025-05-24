@extends('layout.master')
@section('main-content')
    @php
        define('PAGE', 'device');
    @endphp

    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Add new Attachment</h5>
            </div>
        </div>

        <div class="card-body">
            <form
                action="{{ route('attachments.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Title</label>
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            placeholder="Title"
                            value="{{ old('title') }}"
                            required
                        />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Attachment</label>
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
