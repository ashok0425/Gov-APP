@extends('admin.layout.master')
@section('main-content')
    @php
        define('PAGE', 'setting');
    @endphp

    <div class="container">
        <div class="card py-3 px-4">
            <div class="d-flex justify-content-between">
                <h3>Banner Data</h3>
                <a href="{{ route('admin.banner.create') }}" class="btn btn-info btn-lg">
                    Add Banner
                </a>
            </div>
            <br />

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
                    @foreach ($banner as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ getImage($item->image) }}" alt="" width="70" /></td>
                            <td>{{ $item->title }}</td>
                            {{-- <td>{!!$item->text!!}</td> --}}

                            <td>
                                @if ($item->status == 1)
                                    <a class="btn btn-success">Active</a>
                                @else
                                    <a class="btn btn-danger">Deactive</a>
                                @endif
                            </td>
                            <td>
                                <a
                                    href="{{ route('admin.banner.show', ['id' => $item->id]) }}"
                                    class="btn btn-info"
                                >
                                    <i class="far fa-eye"></i>
                                </a>

                                <a
                                    href="{{ route('admin.banner.edit', ['id' => $item->id]) }}"
                                    class="btn btn-primary"
                                >
                                    <i class="far fa-edit"></i>
                                </a>
                                <a
                                    id="delete"
                                    href="{{ route('admin.banner.delete', ['id' => $item->id, 'table' => 'banners']) }}"
                                    class="btn btn-danger"
                                >
                                    <i class="fas fa-times"></i>
                                </a>

                                @if ($item->status == 1)
                                    <a
                                        href="{{ route('admin.banner.deactive', ['id' => $item->id, 'table' => 'banners']) }}"
                                        class="btn btn-primary"
                                    >
                                        <i class="fas fa-thumbs-down"></i>
                                    </a>
                                @else
                                    <a
                                        href="{{ route('admin.banner.active', ['id' => $item->id, 'table' => 'banners']) }}"
                                        class="btn btn-primary"
                                    >
                                        <i class="fas fa-thumbs-up"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
