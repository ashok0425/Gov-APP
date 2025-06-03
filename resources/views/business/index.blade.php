@extends('layout.master')
@section('main-content')
    <div class="card">
        <div class="card-header d-flex justify-content-between bg-dark">
            <div>
                  @if (request()->query('id'))
                <h5 class="card-title text-white">Palika List</h5>
                @else
                <h5 class="card-title text-white">Ward List</h5>

                @endif
            </div>
            <div>
                @if (!request()->query('id'))

                <a href="{{ route('business.create') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-plus"></i>
                    Add Ward
                </a>

                <a href="{{ route('business.reorder') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-sync"></i>
                    Reorder Ward
                </a>
                @endif

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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($wards as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->business_order }}</td>
                        <td><img src="{{getImage($user->thumbnail )}}" alt="" width="100"></td>
                        <td>
                            @if ($user->status == 1)
                                <a class="badge bg-success">Publish</a>
                            @else
                                <a class="badge bg-danger">Draft</a>
                            @endif
                        </td>

                        <td>{{ Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>

                        <td>
<div class="d-flex">
     <a
        class="btn btn-info mx-1"
        href="{{ route('business.categories.edit', $user->id) }}"
    >
        Category
    </a>
    <a
        class="btn btn-success"
        href="{{ route('business.edit', $user->id) }}"
    >
        <i class="fas fa-edit"></i>
    </a>
@if ($user->id!==22)

    <a
    href="{{ route('business.destroy',$user->id) }}"
    class="btn btn-danger delete_btn"
>
    <i class="fas fa-trash"></i>
</a>
@endif

</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$wards->links()}}
    </div>
@endsection
