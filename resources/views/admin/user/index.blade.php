@extends('admin.layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">User List</h5>
            </div>
            <div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-plus"></i>
                    Add user
                </a>
            </div>
        </div>
        <table id="myTable" class="table table-responsive-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Location</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Register on</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{$user->location?->name??null}}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                        <td>
                            @if ($user->status==1)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Blocked</span>
                            @endif

                        </td>
                        <td>
                            <div class="dropdown">
                                <a
                                    id="dropdownMenuButton"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                >
                                    <i class="fas fa-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a
                                        class="dropdown-item"
                                        href="{{ route('admin.users.edit', $user) }}"
                                    >
                                        Edit
                                    </a>
                                    <a
                                    class="dropdown-item"
                                    href="{{ route('admin.user.discount', $user->id) }}"
                                >
                                   Manage Discount
                                </a>
                                    <a
                                        class="dropdown-item"
                                        href="{{ route('admin.user.password', ['user_id' => $user->id]) }}"
                                    >
                                        Change Password
                                    </a>
                                    <a class="dropdown-item"  href="{{ route('admin.kycs.edit', $user) }}">Kyc</a>
                                    <a class="dropdown-item" href="{{route('admin.user.portal',['id'=>$user->id])}}" target="_blank">Login as customer</a>

                                    <a class="dropdown-item" href="{{route('admin.payments.index',['user_id'=>$user->id])}}">Payments</a>
                                    <a class="dropdown-item" href="{{route('admin.orders.index',['user_id'=>$user->id])}}">Orders</a>
                                    @if ($user->status)
                                    <a class="dropdown-item" href="{{route('admin.user.status',['id'=>$user->id,'status'=>0])}}">Mark as Blocked</a>
                                    @else
                                    <a class="dropdown-item" href="{{route('admin.user.status',['id'=>$user->id,'status'=>1])}}">Mark as Unblocked</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$users->links()}}
    </div>
@endsection
