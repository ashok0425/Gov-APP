@extends('layout.master')
@section('main-content')
    <div class="container">
        <form action="" class="mb-3 card">
            <div class="row card-body">
                <div class="col-md-3 mb-2">
                    <input type="search" name="keyword" value="{{request()->query('keyword')}}" class="form-control" placeholder="search...">
                </div>
                @include('blog.partials.category-cascade', [
                    'categoryTree' => $categoryTree,
                    'selected' => $selectedTrail,
                    'columns' => 3,
                ])
                <div class="col-md-2 mb-2">
                        <select name="status" id="status" class="form-control form-select">
                            <option value="" selected>All</option>
                            <option value="1" {{ request()->query('status')? 'selected' : '' }}>Publish</option>
                            <option value="0" {{ request()->query('status')!=''&&request()->query('status')==0 ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    {{-- <div class="col-md-2 mb-2">
                        <input type="text" name="dates" id="" class="form-control" value="{{request()->query('dates')}}">
                    </div> --}}
                    <div class="col-md-1">
                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
            </div>
        </form>
        <div class="card">
            <div class="card-header d-flex justify-content-between bg-dark">
                <div>
                    <h5 class="card-title text-white">Post List</h5>
                </div>
                <div>
                    <a href="{{ route('blogs.create') }}" class="btn btn-info btn-sm">
                        <o class="fas fa-plus"></o>
                        Add Post
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table id="myTable" class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Thumbnail</th>
                            <th>Created At</th>
                            <th>Status</th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $post->title }}</td>

                                <td><img src="{{ getImage($post->thumbnail) }}" width="80" alt="" /></td>
                                <td>{{ Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</td>

                                <td>
                                    @if ($post->status == 1)
                                        <a class="badge bg-success">Publish</a>
                                    @else
                                        <a class="badge bg-danger">Draft</a>
                                    @endif

                                    @if ($post->is_breaking)
                                        <a class="badge bg-warning text-dark">Breaking</a>
                                    @endif
                                </td>
                                <td>
                                    <a
                                        href="{{ route('blogs.edit', ['post' => $post, 'back' => request()->fullUrl()]) }}"
                                        class="btn btn-primary"
                                    >
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a
                                    href="{{ route('blogs.show', $post) }}"
                                    class="btn btn-primary"
                                    target="_blank"
                                >
                                    <i class="far fa-eye"></i>
                                </a>
                                  @can('post:delete')
  <a
                                    href="{{ route('blogs.destroy',$post) }}"
                                    class="btn btn-danger delete_btn"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>
                                  @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $posts->withQueryString()->links() }}

    </div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@include('blog.partials.category-cascade-script')

<script>
    $('input[name="dates"]').daterangepicker();
</script>
@endpush
