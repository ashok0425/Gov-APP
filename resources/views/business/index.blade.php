@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Ward List</h5>
            </div>
            <div>
                <a href="{{ route('business.create') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-plus"></i>
                    Add Ward
                </a>
            </div>
        </div>
        <table id="myTable" class="table table-responsive-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Order</th>
                    <th>Thumbnail</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($business as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->business_order }}</td>
                        <td><img src="{{getImage($user->thumbnail )}}" alt="" width="100"></td>


                        <td>{{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>

                        <td>

                                <div class="d-flex">
                                    <a
                                        class="btn btn-success delete_btn"
                                        href="{{ route('business.edit', $user->id) }}"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a
                                    href="{{ route('business.destroy',$user->id) }}"
                                    class="btn btn-danger delete_btn"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>

                                </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$business->links()}}
    </div>
@endsection
