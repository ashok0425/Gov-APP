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
                        <a href="{{ route('access.create') }}" class="btn btn-info btn-sm">
                            <o class="fas fa-plus"></o>
                            Add User
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table" id="kt_datatable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Ward</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->business?->name??'Gaupalika' }}</td>

                                    <td>
                                        <div class="actions-div">
                                            <a href="{{ route('access.edit', ['id' => $user->id]) }}" class="btn btn-info btn-sm mx-3">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a data-src="{{ route('access.destroy', $user) }}" data-target="#deleteModal" data-toggle="modal" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>

                                            </a>
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
    <script>
        $("#kt_datatable").KTDatatable({
            data: { saveState: false },
            search: { input: $("#kt_datatable_search_query"), key: "generalSearch" },
        });
    </script>
@endpush
