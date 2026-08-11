@extends('layout.master')
@section('main-content')
    <div class="container">
        <form action="" class="mb-3 card">
            <div class="row card-body">
                <div class="col-md-4 mb-2">
                    <select name="parent" class="form-control form-select" onchange="this.form.submit()">
                        <option value="">All categories</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}"
                                {{ request()->query('parent') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-header d-flex justify-content-between bg-dark">
                <div>
                    <h5 class="card-title text-white">Subcategory List</h5>
                </div>
                <div>
                    <a href="{{ route('categories.create', ['parent' => request()->query('parent')]) }}"
                       class="btn btn-info btn-sm">
                        <o class="fas fa-plus"></o>
                        Add Subcategory
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="myTable" class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subcategory</th>
                            <th>Parent Category</th>
                            <th>Thumbnail</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subcategories as $subcategory)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $subcategory->name }}</td>
                                <td>{{ $subcategory->parent?->name }}</td>
                                <td>
                                    <img src="{{ getImage($subcategory->thumbnail) }}" width="80" alt="" />
                                </td>
                                <td>
                                    @if ($subcategory->status == 1)
                                        <a class="badge bg-success">Publish</a>
                                    @else
                                        <a class="badge bg-danger">Draft</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('categories.edit', $subcategory) }}" class="btn btn-primary">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="{{ route('categories.destroy', $subcategory->id) }}"
                                       class="btn btn-danger delete_btn">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    No subcategory yet — use <b>Add Subcategory</b> to create one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ $subcategories->links() }}
    </div>
@endsection
