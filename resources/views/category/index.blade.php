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
                    <h5 class="card-title text-white">Category List</h5>
                </div>
                <div>
                    <a href="{{ route('categories.create') }}" class="btn btn-info btn-sm">
                        <o class="fas fa-plus"></o>
                        Add Category
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="myTable" class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Subcategories</th>
                            <th>Thumbnail</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>

                                <td>
                                    <a href="{{ route('subcategories.index', ['parent' => $category->id]) }}"
                                       class="badge bg-secondary text-decoration-none">
                                        {{ $category->children_count }}
                                    </a>
                                    <a href="{{ route('categories.create', ['parent' => $category->id]) }}"
                                       class="badge bg-info text-decoration-none"
                                       title="Add a subcategory under {{ $category->name }}">+ add</a>
                                </td>

                                <td>
                                    <img
                                        src="{{ getImage($category->thumbnail) }}"
                                        width="80"
                                        alt=""
                                    />
                                </td>
                                <td>
                                    @if ($category->status == 1)
                                        <a class="badge bg-success">Publish</a>
                                    @else
                                        <a class="badge bg-danger">Draft</a>
                                    @endif
                                </td>
                                <td>
                                    <a
                                        href="{{ route('categories.edit', $category) }}"
                                        class="btn btn-primary"
                                    >
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a
                                    href="{{ route('categories.destroy',$category->id) }}"
                                    class="btn btn-danger delete_btn"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
            {{$categories->links()}}
        </div>
    </div>
@endsection
