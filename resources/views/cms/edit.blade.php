@extends('layout.master')
@section('main-content')

  <div class="card">
    <div class="card-header d-flex justify-content-between bg-dark">
        <div>
            <h5 class="card-title text-white">
                Cms info
            </h5>
        </div>

    </div>
    <div class="card-body">
      <div class="container">
        <form
          action="{{ route('cms.update',$cms) }}"
          method="POST"
          enctype="multipart/form-data"
        >
          @csrf
          @method('PATCH')
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Meta Title</label>
                <input
                  type="text"
                  name="meta_title"
                  class="form-control"
                  placeholder="Meta title"
                  value="{{ $cms->meta_title }}"
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Meta Keyword</label>
                <input
                  type="text"
                  name="meta_keyword"
                  class="form-control"
                  placeholder="Meta Keyword"
                  value="{{ $cms->meta_keyword }}"
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Meta Description</label>
                <input
                  type="text"
                  name="meta_description"
                  class="form-control"
                  placeholder="Meta Description"
                  value="{{ $cms->meta_description }}"
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Url</label>
                <input
                  type="url"
                  name="url"
                  class="form-control"
                  placeholder="cms url"
                  value="{{ $cms->url }}"
                />
              </div>
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label">Logo</label>
              <div class="file-upload-wrapper" data-text="Select your file!">
                <input name="logo" type="file" class="file-upload-field" value="" />
              </div>
              <br />
              <img src="{{ getImage($cms->logo) }}" width="70" alt="" />
            </div>

            <div class="mb-3  col-md-6">
              <label class="form-label">Fevicon</label>
              <div class="file-upload-wrapper" data-text="Select your file!">
                <input name="fevicon" type="file" class="file-upload-field" value="" />
              </div>
              <br />
              <img src="{{ getImage($cms->fevicon) }}" width="70" alt="" />
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Address</label>
                <input
                  type="text"
                  name="address"
                  class="form-control"
                  value="{{ $cms->address }}"
                />
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Email Address 1</label>
                <input
                  type="email"
                  name="email1"
                  class="form-control"
                  value="{{ $cms->email1 }}"
                />
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Phone 1</label>
                <input
                  type="text"
                  name="phone1"
                  class="form-control"
                  value="{{ $cms->phone1 }}"
                />
              </div>
            </div>


            <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Email Address 2</label>
                  <input
                    type="email"
                    name="email2"
                    class="form-control"
                    value="{{ $cms->email2 }}"
                  />
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Phone 2</label>
                  <input
                    type="text"
                    name="phone2"
                    class="form-control"
                    value="{{ $cms->phone2 }}"
                  />
                </div>
              </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Facebook</label>
                <input
                  type="text"
                  name="facebook"
                  class="form-control"
                  value="{{ $cms->facebook }}"
                />
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Twitter</label>
                <input
                  type="text"
                  name="twitter"
                  class="form-control"
                  value="{{ $cms->twitter }}"
                />
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Instagram</label>
                <input
                  type="text"
                  name="instagram"
                  class="form-control"
                  value="{{ $cms->instagram }}"
                />
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Linkedin</label>
                <input
                  type="text"
                  name="linkedin"
                  class="form-control"
                  value="{{ $cms->linkedin }}"
                />
              </div>
            </div>

            <div class="col-md-12">
              <div class="mb-3">
                <label class="d-flex align-items-center">
                  <input type="hidden" name="show_palika" value="0">
                  <input type="checkbox" name="show_palika" value="1" style="transform: scale(1.5)"
                    {{ $cms->show_palika ? 'checked' : '' }}>
                  <span class="mx-3">
                    Show Palika section in the app
                    <small class="text-info d-block">
                      When off, the Palika list is hidden from the mobile app. When on, it appears
                      on the app's Settings screen.
                    </small>
                  </span>
                </label>
              </div>

                            <input type="submit" value="update" class="btn btn-block btn-info" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
