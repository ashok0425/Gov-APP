@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Add Palika</h5>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('palika.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name"
                            value="{{ old('name') }}" required />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Enter Address"
                            value="{{ old('address') }}" required />
                    </div>

                     <div class="mb-3 col-md-6">
                        <label class="form-label">Jan Prathinidhi</label>
                        <input
                            type="text"
                            name="owner_name"
                            class="form-control"
                            placeholder="Jan Prathinidhi name"
                            value="{{ old('owner_name') }}"
                            required
                        />
                    </div>

                      <div class="mb-3 col-md-6">
                        <label class="form-label">Google Map Link</label>
                        <input
                            type="text"
                            name="google_map_link"
                            class="form-control"
                            placeholder="Enter Map Link"
                            value="{{ old('google_map_link') }}"
                            required
                        />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Thumbnail</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="thumbnail" type="file" class="file-upload-field" value="" />
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Cover Image</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input name="cover_image" type="file" class="file-upload-field" value="" />
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <input type="hidden" name="category[]" id="cat">

                        <label for="">Category</label>
                        <select  id="" class="form-control from-select select2"
                            multiple="multiple">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{in_array($category->id,old('category')??[])?'selected':''}}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="number" name="phone" class="form-control" placeholder="Enter phone number"
                            value="{{ old('phone') }}" required />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Enter Email address"
                            value="{{ old('email') }}" />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Facebook</label>
                        <input type="text" name="facebook" class="form-control" placeholder="facebook"
                            value="{{ old('facebook') }}" />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">WhatsApp</label>
                        <input type="text" name="whatsapp" class="form-control" placeholder="whatsapp"
                            value="{{ old('whatsapp') }}" />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Messanger</label>
                        <input type="text" name="messanger" class="form-control" placeholder="Messanger"
                            value="{{ old('messanger') }}" />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Any other link</label>
                        <input type="text" name="other" class="form-control" placeholder="other link"
                            value="{{ old('other') }}" />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" id="" class="form-control form-select">
                            <option value="1" {{old('status')==1?'selected':''}}>Publish</option>
                            <option value="0" {{old('status')==0?'selected':''}}>Draft</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

<script>
    $(document).ready(function() {
    const $select = $('.select2').select2();
  let orderedSelections = [];

  $select.on('select2:select', function (e) {
    const value = e.params.data.id;
    if (!orderedSelections.includes(value)) {
      orderedSelections.push(value);
    }
    $('#cat').val(orderedSelections)
  });

  $select.on('select2:unselect', function (e) {
    const value = e.params.data.id;
    orderedSelections = orderedSelections.filter(v => v !== value);
    $('#cat').val(orderedSelections)

  });
});
</script>
@endpush
