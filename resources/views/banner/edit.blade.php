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
                action="{{ route("banners.update",$banner) }}"
                method="POST"
                enctype="multipart/form-data"
            >
            @method('PATCH')
                @csrf
                <div class="row">
                <div class="mb-3 col-md-4">
                    <label class="form-label">Banner Title</label>
                    <input name="title" class="form-control" cols="30" rows="10" value="{!! $banner->title !!}"/>
                </div>
                <div class="mb-3 col-md-4">
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
                        <option
                        value="3"
                        @if ($banner->type == 3)
                            selected
                        @endif
                    > Slider 3
                    </option>
                    </select>
                </div>
                @can ('do:anything')
                <div class="mb-3 col-md-4">
                    <label class="form-label">Is Homepage Banner</label>
                    <select name="is_homepage_banner" id="" class="form-control">
                        <option value="1" {{$banner->is_homepage_banner?'selected':''}}>Yes</option>
                        <option value="0" {{!$banner->is_homepage_banner?'selected':''}}>No</option>
                    </select>
                </div>
                @endif

                <div class="mb-3 col-md-4">
                    <label class="form-label">Banner image</label>
                    <div class="file-upload-wrapper" data-text="Select your file!">
                        <input name="thumbnail" type="file" class="file-upload-field" value="" />
                    </div>
                    <br />
                    <img src="{{ getImage($banner->thumbnail) }}" alt="" width="100" />
                </div>

                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
