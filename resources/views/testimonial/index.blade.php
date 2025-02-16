@extends('layout.master')
@section('main-content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between bg-dark">
                <div>
                    <h5 class="card-title text-white">Testimonial List</h5>
                </div>
                <div>
                    <a href="{{ route('testimonials.create') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-plus"></i>
                        Add New
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="myTable" class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Logo</th>
                            <th>Thumbnail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonials as $testimonial)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $testimonial->name }}</td>

                                <td><img src="{{ getImage($testimonial->logo) }}" width="80" alt="" /></td>
                                <td><img src="{{ getImage($testimonial->thumbnail) }}" width="80" alt="" /></td>

                                <td>
                                    <a
                                        href="{{ route('testimonials.edit', $testimonial) }}"
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
