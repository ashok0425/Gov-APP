@extends('layout.master')
@section('main-content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between bg-dark">
                <div>
                    <h5 class="card-title text-white">Notifications</h5>
                </div>
                <div>
                    @can('notice:create')
                        <a href="{{ route('notices.create') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-plus"></i>
                            Add Notification
                        </a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Sent</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notices as $notice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($notice->thumbnail)
                                        <img src="{{ getImage($notice->thumbnail) }}" alt="" width="60">
                                    @endif
                                </td>
                                <td>
                                    {{ $notice->title }}
                                    <br>
                                    <small class="text-muted">{{ $notice->short_description }}</small>
                                </td>
                                <td>
                                    {{ $notice->sent_at?->format('Y-m-d H:i') }}
                                    {{-- The app's badge only counts the last day. --}}
                                    @if ($notice->sent_at && $notice->sent_at->gt(now()->subDay()))
                                        <span class="badge bg-info">new</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($notice->status)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    @can('notice:edit')
                                        <a href="{{ route('notices.edit', ['notice' => $notice, 'back' => request()->fullUrl()]) }}" class="btn btn-primary">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('notice:delete')
                                        <a href="{{ route('notices.destroy', $notice) }}" class="btn btn-danger delete_btn">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No notification yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ $notices->links() }}
    </div>
@endsection
