{{-- One list for every level below the top: subcategories and child
     categories differ only in what they hang off and what they can hold,
     so they share a screen. --}}
@extends('layout.master')
@section('main-content')
    @php
        $levelName = \App\Models\Category::LEVEL_NAMES[$level];
        $parentName = \App\Models\Category::LEVEL_NAMES[$level - 1];
        $childName = \App\Models\Category::LEVEL_NAMES[$level + 1] ?? null;
    @endphp

    <div class="container">
        <form action="" class="mb-3 card">
            <div class="row card-body">
                <div class="col-md-5 mb-2">
                    <select name="parent" class="form-control form-select searchable"
                            data-placeholder="All {{ Str::lower($parentName) }}s"
                            onchange="this.form.submit()">
                        <option value="">All {{ Str::lower($parentName) }}s</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}"
                                {{ request()->query('parent') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->pathName() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-2">
                    <input type="text" name="keyword" class="form-control" placeholder="search by name"
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
                    <h5 class="card-title text-white">{{ $levelName }} List</h5>
                </div>
                <div class="btn-group" role="group">
                    @can('subcategory:edit')
                        <a href="{{ route('categories.reorder.page', ['level' => $level, 'parent' => request()->query('parent')]) }}"
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-sort"></i>
                            Reorder
                        </a>
                    @endcan
                    @can('subcategory:create')
                        <a href="{{ route('categories.create', ['level' => $level, 'parent' => request()->query('parent'), 'back' => request()->fullUrl()]) }}"
                           class="btn btn-info btn-sm">
                            <i class="fas fa-plus"></i>
                            Add {{ $levelName }}
                        </a>
                    @endcan
                </div>
            </div>

            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ $levelName }}</th>
                            <th>Sits under</th>
                            @if ($childName)
                                <th>{{ $childName }}</th>
                            @endif
                            <th>Thumbnail</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->parent?->pathName() }}</td>

                                @if ($childName)
                                    <td>
                                        <a href="{{ route($childRoute, ['parent' => $row->id]) }}"
                                           class="badge bg-secondary text-decoration-none">
                                            {{ $row->children_count }}
                                        </a>
                                        @can('subcategory:create')
                                            <a href="{{ route('categories.create', ['parent' => $row->id, 'back' => request()->fullUrl()]) }}"
                                               class="badge bg-info text-decoration-none"
                                               title="Add a {{ Str::lower($childName) }} under {{ $row->name }}">+ add</a>
                                        @endcan
                                    </td>
                                @endif

                                <td>
                                    <img src="{{ getImage($row->thumbnail) }}" width="70" alt="">
                                </td>
                                <td>
                                    @if ($row->hasContact())
                                        <span class="badge bg-success">{{ $row->phone ?: 'on' }}</span>
                                    @else
                                        <span class="badge bg-secondary">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->status == 1)
                                        <a class="badge bg-success">Publish</a>
                                    @else
                                        <a class="badge bg-danger">Draft</a>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @can('subcategory:edit')
                                            <a href="{{ route('categories.edit', ['category' => $row, 'back' => request()->fullUrl()]) }}" class="btn btn-primary">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('subcategory:delete')
                                            <a href="{{ route('categories.destroy', $row->id) }}"
                                               class="btn btn-danger delete_btn">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $childName ? 8 : 7 }}" class="text-center">
                                    No {{ Str::lower($levelName) }} yet — use
                                    <b>Add {{ $levelName }}</b> to create one.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ $rows->links() }}
    </div>

    @push('scripts')
        @include('partials.select2-assets')
        <script>
            $(function () {
                $('.searchable').select2({ width: '100%' });
            });
        </script>
    @endpush
@endsection
