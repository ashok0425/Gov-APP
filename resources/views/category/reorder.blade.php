{{-- Every row of one menu level on a page, for dragging into order. Below
     the top level the rows sit in one table per parent, since the app only
     ever shows siblings together; each table saves on its own drop. --}}
@extends('layout.master')
@section('main-content')
    @php
        $levelName = \App\Models\Category::LEVEL_NAMES[$level];
        $parentName = \App\Models\Category::LEVEL_NAMES[$level - 1] ?? null;
    @endphp

    <div class="container">
        @if ($level > 1)
            <form action="" class="mb-3 card">
                <input type="hidden" name="level" value="{{ $level }}">
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
                </div>
            </form>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between bg-dark">
                <div>
                    <h5 class="card-title text-white">Reorder {{ $levelName }}</h5>
                </div>
                <div>
                    <a href="{{ route($listRoute, ['parent' => request()->query('parent')]) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i>
                        Back to list
                    </a>
                </div>
            </div>

            <div class="card-body">
                <p class="text-muted">
                    Drag the <i class="fas fa-grip-vertical"></i> handle to move a row. The order is saved
                    as soon as you drop it.
                    @if ($level > 1)
                        Rows can only be moved within the same {{ Str::lower($parentName) }}.
                    @endif
                </p>

                @forelse ($groups as $parentId => $rows)
                    @if ($level > 1)
                        <h6 class="mt-4 mb-2">
                            <i class="fas fa-folder-open text-muted"></i>
                            {{ $rows->first()->parent?->pathName() ?? '—' }}
                        </h6>
                    @endif

                    <table class="table table-responsive-sm">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>{{ $levelName }}</th>
                                <th>Thumbnail</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody data-sortable-list>
                            @foreach ($rows as $row)
                                <tr data-id="{{ $row->id }}">
                                    <td class="drag-handle" style="cursor: grab" title="drag to reorder">
                                        <i class="fas fa-grip-vertical text-muted"></i>
                                    </td>
                                    <td class="row-number">{{ $loop->iteration }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>
                                        <img src="{{ getImage($row->thumbnail) }}" width="50" alt="">
                                    </td>
                                    <td>
                                        @if ($row->status == 1)
                                            <span class="badge bg-success">Publish</span>
                                        @else
                                            <span class="badge bg-danger">Draft</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @empty
                    <p class="text-center mb-0">Nothing to order yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
        @include('partials.select2-assets')
        <script>
            $(function () {
                $('.searchable').select2({ width: '100%' });
            });
        </script>

        @include('partials.sortable-lists', ['reorderUrl' => route('categories.reorder')])
    @endpush
@endsection
