@extends('layout.master')

@section('main-content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header d-flex justify-content-between bg-dark">
                    <div>
                        <h5 class="card-title text-white">User List</h5>
                    </div>
                    <div>
                        @can('user:create')
                            <a href="{{ route('access.create') }}" class="btn btn-info btn-sm">
                                <o class="fas fa-plus"></o>
                                Add User
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="table" id="kt_datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Category access</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->categories->isEmpty() ? 'All' : $user->pinnedPaths()->implode(', ') }}</td>
                                    <td>
                                        @if ($user->status == 1)
                                            <a class="badge bg-success">Publish</a>
                                        @else
                                            <a class="badge bg-danger">Draft</a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="actions-div">
                                            @can('user:edit')
                                                <a href="{{ route('access.edit', ['id' => $user->id]) }}" class="btn btn-info btn-sm mx-3">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('user:delete')
                                                <a href="{{ route('access.destroy', $user->id) }}" class="btn btn-danger delete_btn" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endcan

                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
