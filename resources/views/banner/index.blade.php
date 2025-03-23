@extends('layout.master')
@section('main-content')
    @php
        define('PAGE', 'setting');
    @endphp

    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between bg-dark">
                <div>
                    <h5 class="card-title text-white">Banner List</h5>
                </div>
                <div>
                    <a href="{{ route('banners.create') }}" class="btn btn-info btn-sm">
                        <o class="fas fa-plus"></o>
                        Add Banner
                    </a>
                </div>
            </div>

            <table id="myTable" class="table table-responsive-sm">
                <thead>
                    <tr>
                        <th>#</th>

                        <th>Banner Image</th>
                        <th>Title</th>
                        {{-- <th>Detail</th> --}}

                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banners as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ getImage($item->thumbnail) }}" alt="" width="70" /></td>
                            <td>{{ $item->title }}</td>

                            <td>
                                @if ($item->status == 1)
                                    <a class="btn btn-success">Active</a>
                                @else
                                    <a class="btn btn-danger">Deactive</a>
                                @endif
                            </td>
                            <td>

                                <a
                                    href="{{ route('banners.edit', $item) }}"
                                    class="btn btn-primary"
                                >
                                    <i class="far fa-edit"></i>
                                </a>
                                <a
                                    href="{{ route('banners.destroy',$item) }}"
                                    class="btn btn-danger delete_btn"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>

                                {{-- @if ($item->status == 1)
                                    <a
                                        href="{{ route('banners.deactive', ['id' => $item->id, 'table' => 'banners']) }}"
                                        class="btn btn-primary"
                                    >
                                        <i class="fas fa-thumbs-down"></i>
                                    </a>
                                @else
                                    <a
                                        href="{{ route('banners.active', ['id' => $item->id, 'table' => 'banners']) }}"
                                        class="btn btn-primary"
                                    >
                                        <i class="fas fa-thumbs-up"></i>
                                    </a>
                                @endif --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
