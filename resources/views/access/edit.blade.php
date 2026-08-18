@extends('layout.master')
@section('main-content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header d-flex justify-content-between bg-dark">
                    <div>
                        <h5 class="card-title text-white">Edit User</h5>
                    </div>
                    <div>

                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('access.update', ['id' => $user->id]) }}" method="POST" id="form"
                        data-parsley-validate="">
                        @csrf

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="col-form-label">Enter name <span class="text-danger">*</span></label>
                                    <div class="">
                                        <input type="text" value="{{ old('name', $user->name) }}" class="form-control"
                                            name="name">

                                        @error('name')
                                            <span class="error-msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label class="col-form-label">Enter email <span class="text-danger">*</span></label>
                                    <div class="">
                                        <input type="text" value="{{ old('email', $user->email) }}" class="form-control"
                                            name="email">

                                        @error('email')
                                            <span class="error-msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label">Enter Phone <span class="text-danger">*</span></label>
                                    <div class="">
                                        <input type="number" value="{{ old('phone', $user->phone) }}" class="form-control"
                                            name="phone">

                                        @error('phone')
                                            <span class="error-msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @can('do:anything')
                                <div class="form-group col-md-4 mb-3">
                                    <label class="col-form-label">Enter password </label>
                                    <div class="">
                                        <input type="text" value="{{ old('password') }}" class="form-control"
                                            name="password">

                                        @error('password')
                                            <span class="error-msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control form-select">
                                        <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Publish</option>
                                        <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 mb-3 mb-3">
                                    <label><input {{ $user->role == 1 ? 'checked' : '' }} name="role" type="radio"
                                            style="transform: scale(2)" value="1"><span class="mx-3">Super
                                            Admin</span></label>
                                </div>

                                <div class="form-group col-md-3 mb-3 mb-3">
                                    <label><input {{ $user->role == 2 ? 'checked' : '' }} name="role" type="radio"
                                            style="transform: scale(2)" value="2"><span class="mx-3">Admin</span></label>
                                </div>
                            </div>
                        @endcan


                        <div class="form-group">
                            <label class="col-form-label">
                                <h3>Permissions <span class="text-danger">*</span></h3>
                            </label>
                            @foreach ($permissionMap as $key => $permission)
                                <h5 class="mt-3">{{ Str::headline(Str::replace('_', ' ', $key)) }}</h5>

                                <div class="row">
                                    @foreach ($permission as $item)
                                        <div class="col-md-4">
                                            <label class="d-flex align-items-center">
                                                <input type="checkbox" value="{{ $item }}" name="permissions[]"
                                                    @if (in_array($item, $user->permissions->pluck('name')->toArray())) checked @endif>
                                                <span class="pl-1">
                                                    @if (str_contains($item, 'others:'))
                                                        {{ Str::headline(Str::replace('others:', ' ', $item)) }}
                                                    @else
                                                        {{ Str::headline(Str::replace(':', ' ', $item)) }}
                                                    @endif

                                                </span></label>

                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                        </div>
                        <div>
                            <button class="btn btn-primary mt-3">save</button>
                        </div>


                </div>
            </div>


            </form>
        </div>
    </div>
    </div>
    </div>
@endsection
