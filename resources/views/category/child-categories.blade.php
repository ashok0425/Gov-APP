@extends('layout.master')
@section('main-content')
    <div class="container">
        <form action="" class="mb-3 card">
            <div class="row card-body">
                <div class="col-md-5 mb-2">
                    <select name="parent" class="form-control form-select" onchange="this.form.submit()">
                        <option value="">All subcategories</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}"
                                {{ request()->query('parent') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->pathName() }}
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
                    <h5 class="card-title text-white">Child Category List</h5>
                </div>
                <div>
                    <a href="{{ route('categories.create', ['parent' => request()->query('parent')]) }}"
                       class="btn btn-info btn-sm">
                        <i class="fas fa-plus"></i>
                        Add Child Category
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="myTable" class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Child Category</th>
                            <th>Sits under</th>
                            <th>Thumbnail</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($childCategories as $child)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $child->name }}</td>
                                <td>{{ $child->parent?->pathName() }}</td>
                                <td>
                                    <img src="{{ getImage($child->thumbnail) }}" width="80" alt="">
                                </td>
                                <td>
                                    @if ($child->hasContact())
                                        <span class="badge bg-success">{{ $child->phone ?: 'on' }}</span>
                                    @else
                                        <span class="badge bg-secondary">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($child->status == 1)
                                        <a class="badge bg-success">Publish</a>
                                    @else
                                        <a class="badge bg-danger">Draft</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('categories.edit', $child) }}" class="btn btn-primary">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="{{ route('categories.destroy', $child->id) }}"
                                       class="btn btn-danger delete_btn">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    No child category yet — use <b>Add Child Category</b> to create one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ $childCategories->links() }}
    </div>
@endsection
