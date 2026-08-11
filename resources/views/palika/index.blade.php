@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                <h5 class="card-title text-white">Palika List</h5>
            </div>
            <div>
                @can ('palika:create')
                <a href="{{ route('palika.create') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-plus"></i>
                    Add Palika
                </a>
                @endcan

                @can ('palika:reorder')
                <a href="{{ route('palika.reorder') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-sync"></i>
                    Reorder Palika
                </a>
                @endcan
            </div>
        </div>
        <table id="myTable" class="table table-responsive-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Order</th>
                    <th>Thumbnail</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($palikas as $palika)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $palika->name }}</td>
                        <td>{{ $palika->phone }}</td>
                        <td>{{ $palika->address }}</td>
                        <td>{{ $palika->business_order }}</td>
                        <td><img src="{{getImage($palika->thumbnail )}}" alt="" width="100"></td>
                        <td>
                            @if ($palika->status == 1)
                                <a class="badge bg-success">Publish</a>
                            @else
                                <a class="badge bg-danger">Draft</a>
                            @endif
                        </td>

                        <td>{{ Carbon\Carbon::parse($palika->created_at)->format('d/m/Y') }}</td>

                        <td>
                            <div class="d-flex">
                                @can ('palika:category')
                                <a
                                    class="btn btn-info mx-1"
                                    href="{{ route('palika.categories.edit', $palika->id) }}"
                                >
                                    Category
                                </a>
                                @endcan

                                @can ('palika:edit')
                                <a
                                    class="btn btn-success"
                                    href="{{ route('palika.edit', $palika->id) }}"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can ('palika:delete')
                                <a
                                    href="{{ route('palika.destroy',$palika->id) }}"
                                    class="btn btn-danger delete_btn mx-1"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No palika added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{$palikas->links()}}
    </div>
@endsection
