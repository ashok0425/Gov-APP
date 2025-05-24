@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Edit Attachment</h5>
            </div>
        </div>

        <div class="card-body">
            <form
                action="{{ route('attachments.update', $attachment) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Attachment</label>
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            placeholder="Title"
                            value="{{ $attachment->title }}"
                        />
                    </div>

                    {{-- <div class="mb-3 col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" id="" class="form-control form-select" required>
                            <option value="">select status</option>
                            <option value="1" {{ $attachment->status ? 'selected' : '' }}>
                                Publish
                            </option>
                            <option value="0" {{ ! $attachment->status ? 'selected' : '' }}>
                                Draft
                            </option>
                        </select>
                    </div> --}}
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Attachment</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input
                                name="thumbnail"
                                type="file"
                                class="file-upload-field"
                                value=""
                            />
                        </div>
                        <br />
                        <img
                            src="{{ getImage($attachment->thumbnail) }}"
                            alt="{{ $attachment->name }}"
                            width="100"
                        />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">update</button>
            </form>
        </div>
    </div>
@endsection
