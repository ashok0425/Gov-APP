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
                    <th>Register on</th>
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

                        <td>{{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>

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
                                        href="{{ route('business.edit', $user->id) }}"
                                    >
                                        Edit
                                    </a>


                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$business->links()}}
    </div>
@endsection
