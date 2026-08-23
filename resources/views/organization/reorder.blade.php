{{-- Every organization on one page, for dragging into the order the app's
     home grid shows them in. Saves on every drop. --}}
@extends('layout.master')
@section('main-content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between bg-dark">
                <div>
                    <h5 class="card-title text-white">Reorder Organizations</h5>
                </div>
                <div>
                    <a href="{{ route('organizations.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i>
                        Back to list
                    </a>
                </div>
            </div>

            <div class="card-body">
                <p class="text-muted">
                    Drag the <i class="fas fa-grip-vertical"></i> handle to move a row. The order is saved
                    as soon as you drop it.
                </p>

                <table class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th></th>
                            <th>#</th>
                            <th>Name</th>
                            <th>Thumbnail</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody data-sortable-list>
                        @forelse ($organizations as $organization)
                            <tr data-id="{{ $organization->id }}">
                                <td class="drag-handle" style="cursor: grab" title="drag to reorder">
                                    <i class="fas fa-grip-vertical text-muted"></i>
                                </td>
                                <td class="row-number">{{ $loop->iteration }}</td>
                                <td>{{ $organization->name }}</td>
                                <td>
                                    <img src="{{ getImage($organization->thumbnail) }}" width="50" alt="">
                                </td>
                                <td>
                                    @if ($organization->status == 1)
                                        <span class="badge bg-success">Publish</span>
                                    @else
                                        <span class="badge bg-danger">Draft</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Nothing to order yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        @include('partials.sortable-lists', ['reorderUrl' => route('organizations.reorder')])
    @endpush
@endsection
