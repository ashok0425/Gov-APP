@extends('layout.master')
@section('main-content')
    @php
        define('PAGE', 'device');
    @endphp

    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between bg-dark">
                <div>
                    <h5 class="card-title text-white">Attachment List</h5>
                </div>
                <div>
                    <a href="{{ route('attachments.create') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-plus"></i>
                        Add Attachment
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="myTable" class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Attachment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attachments as $attachment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attachment->title }}</td>
                                <td>
                                    <a href="{{ getImage($attachment->attachment) }}" target="_blank">View</a>
                                </td>
                                <td>
                                    <a href="{{ route('attachments.edit', $attachment) }}" class="btn btn-primary" title="Edit">
                                        <i class="far fa-edit"></i>
                                    </a>

                                    <button
                                        class="btn btn-secondary copy-btn"
                                        data-link="{{ getImage($attachment->attachment) }}"
                                        title="Copy Link"
                                    >
                                        <i class="far fa-copy"></i>
                                    </button>

                                    <a href="{{ route('attachments.destroy', $attachment->id) }}" class="btn btn-danger delete_btn" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const copyButtons = document.querySelectorAll('.copy-btn');

        copyButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const link = this.getAttribute('data-link');

                navigator.clipboard.writeText(link)
                    .then(() => {
                        alert('Link copied to clipboard!');
                    })
                    .catch(err => {
                        console.error('Failed to copy:', err);
                        alert('Failed to copy link.');
                    });
            });
        });
    });
</script>
@endpush
