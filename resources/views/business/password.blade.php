@extends('layout.master')
@section('main-content')
<div class="row">

    <div class="col-md-6 mx-auto">
  <div class="card">
    <div class="card-header d-flex justify-content-between bg-dark">
        <div>
            <h5 class="card-title text-white">
               Update Password
            </h5>
        </div>
      </div>

    <div class="card-body">
      <form
        method="POST"
        enctype="multipart/form-data"
      >
        @csrf


    <div class="mb-3">
        <label class="form-label">Password</label>
        <input
          type="password"
          name="password"
          class="form-control"
          placeholder="Enter password"
          value="{{ old('password') }}"
          required
        />
      </div>

      <div class="mb-3">
        <label class="form-label">Re-type password</label>
        <input
          type="password"
          name="confirm_password"
          class="form-control"
          placeholder="Confirm password"
          value="{{ old('confirm_password') }}"
          required
        />
      </div>
</div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
@endsection
