@extends('admin.layout.master')
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
                    <form action="{{ route('admin.access.update', ['id' => $user->id]) }}" method="POST" id="form"
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
                                    <div class="form-group col-md-4 mb-3">
                                        <label class="form-label">Location</label>
                                        <select name="location" id="" class="form-control form-select" required>
                                            <option value="">Select Location</option>
                                            @foreach(App\Models\Location::all() as $location)
                                            <option value="{{$location->id}}" {{$location->id==$user->location_id?'selected':''}}>{{$location->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>

                                <div class="form-group">
                                    <label class="col-form-label"><h3>Permissions <span class="text-danger">*</span></h3></label>
                                        @foreach ($permissionMap as $key => $permission)
                                        <h5 class="my-3">{{Str::headline(Str::replace('_',' ',$key)) }}</h5>

                                        <div class="row mt-5">
                                            @foreach ($permission as $item)
                                            <div class="col-md-4">
                                                <label class="d-flex align-items-center">
                                                    <input type="checkbox" value="{{ $item }}" name="permissions[]"
                                                    @if (in_array($item, $user->permissions->pluck('name')->toArray())) checked @endif
                                                    >
                                                    <span class="pl-1">
                                                        @if (str_contains($item,'others:'))
                                                        {{Str::headline(Str::replace('others:',' ',$item)) }}

                                                        @else
                                                        {{Str::headline(Str::replace(':',' ',$item)) }}

                                                        @endif

                                                    </span></label>
                                                    @if ($item == 'others:miscellaneous')
                                                    (Contributions, Subscriptions)
                                                @endif

                                                @if ($item == 'others:content_management')
                                                    (Pages, News, Faqs, Blog)
                                                @endif
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
