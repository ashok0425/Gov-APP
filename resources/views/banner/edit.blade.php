@extends("layout.master")
@section("main-content")
    @php
        define("PAGE", "setting");
    @endphp

    <div class="card">
        <h3 class="card-title">Edit Banner</h3>

        <div class="card-body">
            <form
                action="{{ route("banners.update",$banner) }}"
                method="POST"
                enctype="multipart/form-data"
            >
            @method('PATCH')
                @csrf
                <div class="mb-3">
                    <label class="form-label">Banner Title</label>
                    <input name="title" class="form-control" cols="30" rows="10" value="{!! $banner->title !!}"/>
                </div>
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" id="" class="form-control">
                        <option
                            value="2"
                            @if ($banner->type == 1)
                                selected
                            @endif
                        >
                            Slider 1
                        </option>
                        <option
                            value="2"
                            @if ($banner->type == 2)
                                selected
                            @endif
                        > Slider 2
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Banner image</label>
                    <div class="file-upload-wrapper" data-text="Select your file!">
                        <input name="thumbnail" type="file" class="file-upload-field" value="" />
                    </div>
                    <br />
                    <img src="{{ getImage($banner->thumbnail) }}" alt="" width="100" />
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
