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
                <div>
                    <a href="{{ route('organizations.create') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-plus"></i>
                        Add Organization
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Name</th>
                            <th>Categories</th>
                            <th>Thumbnail</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-body">
                        @forelse ($organizations as $organization)
                            <tr data-id="{{ $organization->id }}">
                                <td class="drag-handle" style="cursor: grab" title="drag to reorder">
                                    <i class="fas fa-grip-vertical text-muted"></i>
                                </td>
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
                                    <a href="{{ route('organizations.edit', $organization) }}" class="btn btn-primary">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="{{ route('organizations.destroy', $organization->id) }}"
                                       class="btn btn-danger delete_btn">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
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

    @push('scripts')
        @include('partials.sortable-rows', [
            'reorderUrl' => route('organizations.reorder'),
            'start' => ($organizations->firstItem() ?? 1) - 1,
        ])
    @endpush
@endsection
