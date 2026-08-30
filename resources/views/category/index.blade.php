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
                <div class="btn-group" role="group">
                    @can('category:edit')
                        <a href="{{ route('categories.reorder.page') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-sort"></i>
                            Reorder
                        </a>
                    @endcan
                    @can('category:create')
                        <a href="{{ route('categories.create') }}" class="btn btn-info btn-sm">
                            <o class="fas fa-plus"></o>
                            Add Category
                        </a>
                    @endcan
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
                            <th>Contact</th>
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
                                    @can('subcategory:create')
                                        <a href="{{ route('categories.create', ['parent' => $category->id, 'back' => request()->fullUrl()]) }}"
                                           class="badge bg-info text-decoration-none"
                                           title="Add a subcategory under {{ $category->name }}">+ add</a>
                                    @endcan
                                </td>

                                <td>
                                    <img
                                        src="{{ getImage($category->thumbnail) }}"
                                        width="80"
                                        alt=""
                                    />
                                </td>
                                <td>
                                    @if ($category->hasContact())
                                        <span class="badge bg-success">{{ $category->phone ?: 'on' }}</span>
                                    @else
                                        <span class="badge bg-secondary">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($category->status == 1)
                                        <a class="badge bg-success">Publish</a>
                                    @else
                                        <a class="badge bg-danger">Draft</a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('category:edit')
                                            <a
                                                href="{{ route('categories.edit', ['category' => $category, 'back' => request()->fullUrl()]) }}"
                                                class="btn btn-primary"
                                            >
                                                <i class="far fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('category:delete')
                                            <a
                                                href="{{ route('categories.destroy',$category->id) }}"
                                                class="btn btn-danger delete_btn"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endcan
                                    </div>
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
