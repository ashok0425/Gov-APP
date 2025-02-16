@extends('layout.master')
@section('main-content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between bg-dark">
                <div>
                    <h5 class="card-title text-white">Blog List</h5>
                </div>
                <div>
                    <a href="{{ route('blogs.create') }}" class="btn btn-info btn-sm">
                        <o class="fas fa-plus"></o>
                        Add Blog
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="myTable" class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Thumbnail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $blog)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $blog->title }}</td>

                                <td><img src="{{ getImage($blog->thumbnail) }}" width="80" alt="" /></td>
                                <td>
                                    @if ($blog->status == 1)
                                        <a class="btn btn-success">Active</a>
                                    @else
                                        <a class="btn btn-danger">Deactive</a>
                                    @endif
                                </td>
                                <td>
                                    <a
                                        href="{{ route('blogs.edit', $blog) }}"
                                        class="btn btn-primary"
                                    >
                                        <i class="far fa-edit"></i>
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
