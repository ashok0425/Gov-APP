@extends('layout.master')
@section('main-content')
    <div class="container">
        <form action="" class="mb-3 card">
            <div class="row card-body">
                <div class="col-md-5 mb-2">
                    <input type="search" name="keyword" class="form-control" placeholder="search by name"
                           value="{{ request()->query('keyword') }}">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-header d-flex justify-content-between bg-dark">
                <div>
                    <h5 class="card-title text-white">Organization List</h5>
                </div>
                <div class="btn-group" role="group">
                    @can('organization:edit')
                        <a href="{{ route('organizations.reorder.page') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-sort"></i>
                            Reorder
                        </a>
                    @endcan
                    @can('organization:create')
                        <a href="{{ route('organizations.create') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-plus"></i>
                            Add Organization
                        </a>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Categories</th>
                            <th>Thumbnail</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($organizations as $organization)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $organization->name }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $organization->main_categories_count }}</span>
                                </td>
                                <td>
                                    <img src="{{ getImage($organization->thumbnail) }}" width="70" alt="">
                                </td>
                                <td>
                                    @if ($organization->status == 1)
                                        <a class="badge bg-success">Publish</a>
                                    @else
                                        <a class="badge bg-danger">Draft</a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('organization:edit')
                                            <a href="{{ route('organizations.edit', $organization) }}" class="btn btn-primary">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('organization:delete')
                                            <a href="{{ route('organizations.destroy', $organization->id) }}"
                                               class="btn btn-danger delete_btn">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    No organization yet — use <b>Add Organization</b> to create one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $organizations->links() }}
        </div>
    </div>
@endsection
