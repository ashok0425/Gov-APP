@extends('layout.master')

@section('main-content')
        <div class="card">
            <div class="card-header d-flex justify-content-between bg-dark">
                <div>
                    <h5 class="card-title text-white">Add New User</h5>
                </div>
                <div>

                </div>
            </div>
                <div class="card-body">
                    <form action="{{ route('access.store') }}" method="POST" id="form" data-parsley-validate="">
                        @csrf

                        <div class="row align-items-center">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label">Enter name <span class="text-danger">*</span></label>
                                    <div class="">
                                        <input type="text" value="{{ old('name') }}" class="form-control"
                                            name="name">

                                        @error('name')
                                            <span class="error-msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label class="col-form-label">Enter email <span class="text-danger">*</span></label>
                                    <div class="">
                                        <input type="text" value="{{ old('email') }}" class="form-control"
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
                                        <input type="number" value="{{ old('phone') }}" class="form-control"
                                            name="phone">

                                        @error('phone')
                                            <span class="error-msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        <div class="form-group col-md-4 mb-3">
                            <label class="col-form-label">Enter password <span class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" value="{{ old('password') }}" class="form-control" name="password">

                                @error('password')
                                    <span class="error-msg">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @can('do:anything')
                    <div class="form-group col-md-4 mb-3 mb-3">
                        <label class="form-label">Ward</label>
                        <select name="business_id" id="" class="form-control form-select" >
                            <option value="">Select Ward</option>
                            @foreach(App\Models\Business::all() as $business)
                            <option value="{{$business->id}}">{{$business->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" id="" class="form-control form-select">
                            <option value="1" {{old('status')==1?'selected':''}}>Publish</option>
                            <option value="0" {{old('status')==0?'selected':''}}>Draft</option>
                        </select>
                    </div>

                    {{-- <div class="form-group col-md-4 mb-3 mb-3">
                        <label><input name="is_owner" type="checkbox" style="transform: scale(2)"> &nbsp; Is Admin For ward</label>
                    </div> --}}
                    @endcan

                </div>

                        <div class="form-group">
                            <label class="col-form-label">
                                <h3>Permissions <span class="text-danger">*</span></h3>
                            </label>
                                @foreach ($permissionMap as $key => $permission)
                                <h5 class="mb-0 mt-3">{{Str::headline(Str::replace('_',' ',$key)) }}</h5>

                                <div class="row">
                                    @foreach ($permission as $item)
                                    <div class="col-md-4">
                                        <label class="d-flex align-items-center">
                                            <input type="checkbox" name="permissions[]"
                                          value="{{$item}}"  >

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

                        <button class="btn btn-primary mt-4">Save</button>
                    </form>
                </div>
            </div>
@endsection
