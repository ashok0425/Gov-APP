@extends("layout.master")
@section("main-content")
    @php
        define("PAGE", "setting");
    @endphp

    <div class="card">
        <h3 class="card-title">Edit Banner</h3>

        <div class="card-body">
            <form
                action="{{ route("banner.update") }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                <input name="id" value="{{ $banner->id }}" type="hidden" />
                <div class="mb-3">
                    <label class="form-label">Banner Title</label>
                    <textarea name="title" cols="30" rows="10" id="summernote1">
         {!! $banner->title !!}
     </textarea
                    >
                </div>
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" id="" class="form-control">
                        <option
                            value="0"
                            @if ($banner->type == 0)
                                selected
                            @endif
                        >
                            Large banner
                        </option>
                        <option
                            value="1"
                            @if ($banner->type == 1)
                                selected
                            @endif
                        >
                            Shop banner
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Banner image</label>
                    <div class="file-upload-wrapper" data-text="Select your file!">
                        <input name="file" type="file" class="file-upload-field" value="" />
                    </div>
                    <br />
                    <img src="{{ getImage($banner->image) }}" alt="" width="100" />
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
