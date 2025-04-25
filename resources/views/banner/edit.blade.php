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
                <div class="mb-3 col-md-6">
                    <label class="form-label">Banner Title</label>
                    <input name="title" class="form-control" cols="30" rows="10" value="{!! $banner->title !!}"/>
                </div>

                @can ('do:anything')
                <div class="mb-3 col-md-6">
                    <label class="form-label">Is Homepage Banner</label>
                    <select name="is_homepage_banner" id="" class="form-control form-select">
                        <option value="1" {{$banner->is_homepage_banner?'selected':''}}>Yes</option>
                        <option value="0" {{!$banner->is_homepage_banner?'selected':''}}>No</option>
                    </select>
                </div>
                @endif

                <div class="mb-3 col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" id="" class="form-control form-select">
                        <option value="1" {{old('status',$banner->status)==1?'selected':''}}>Publish</option>
                        <option value="0" {{old('status',$banner->status)==0?'selected':''}}>Draft</option>
                    </select>
                </div>
                @can('do:anything')
                <div class="mb-3 col-md-6">
                    <label class="form-label">Select Ward</label>
                    <select name="business_id" id="" class="form-control form-select" required>
                       <option value="">select Ward</option>
                       @foreach ($businesses as $business)
                       <option value="{{$business->id}}" {{$business->id==$blog->business_id?'selected':''}}>{{$business->name}}</option>
                       @endforeach
                    </select>
                </div>
                @endif
                <div class="mb-3 col-md-6">
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
