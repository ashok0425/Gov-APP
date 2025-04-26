@extends('layout.master')
@section('main-content')
    @php
        define('PAGE', 'subscriber');
    @endphp

    <div class="card">
        <h3>Send Email</h3>

        <div class="card-body">
            <form
                action=" {{ route('subscriber.store') }} "
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @foreach ($email as $item)
                    <input type="hidden" value="{{ $item }}" name="email[]" />
                @endforeach

                <div class="mb-3">
                    <label class="form-label">Mail Subject</label>
                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        placeholder="Mail title"
                        value="{{ old('title') }}"
                        required
                    />
                </div>
                <div class="mb-3">
                    <label class="form-label">Mail Body</label>
                    <textarea
                        type="text"
                        name="detail"
                        id="summernote"
                        class="form-control"
                        placeholder="Post Detail"
                        required
                    >
                    {{ old('detail') }}
                </textarea
                    >
                </div>

                {{--
                    <div class="mb-3">
                    <label class="form-label">Attachement</label>
                    <div class="file-upload-wrapper" data-text="Select your file!">
                    <input name="file" type="file" class="file-upload-field" value="">
                    </div>
                    <br>
                    </div>
                --}}

                <button type="submit" class="btn btn-primary">Send Mail</button>
            </form>
        </div>
    </div>
@endsection
