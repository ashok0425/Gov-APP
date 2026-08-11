@extends('layout.master')
@section('main-content')
    <div class="row">
        <div class="col-md-2 offset-md-10">
              <form method="POST" action="{{ route('palika.categories.update', $palika->id) }}">
        @csrf
        <input type="hidden" name="categories" id="category_ids">
        <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
    </form>
        </div>
        <div class="col-md-12">
            <h5 class="mt-3">{{ $palika->name }} — menu categories</h5>
            <p class="text-muted mb-0">
                Drag categories across to pick what "See More Menu" shows for this palika, and drag
                within the list to order them. Subcategories follow their parent automatically.
            </p>
        </div>

        <div class="col-md-6">
            <h5>Assigned Categories</h5>
            <ul id="assigned" class="list-group connected-sortable" style="min-height:200vh ">
                @foreach ($assignedCategories as $category)
                    <li class="list-group-item" data-id="{{ $category->id }}">{{ $category->name }}</li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-6">
            <h5>All Categories</h5>
            <ul id="available" class="list-group connected-sortable">
                @foreach ($allCategories->whereNotIn('id', $assigned) as $category)
                    <li class="list-group-item" data-id="{{ $category->id }}">{{ $category->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>


@endsection

@push('scripts')
    <style>
        .connected-sortable {
            min-height: 300px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .connected-sortable .list-group-item {
            cursor: move;
        }
    </style>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(function () {
            $(".connected-sortable").sortable({
                connectWith: ".connected-sortable",
                placeholder: "ui-state-highlight"
            }).disableSelection();

            $('form').on('submit', function () {
                let selected = [];
                $('#assigned li').each(function () {
                    selected.push($(this).data('id'));
                });
                $('#category_ids').val(selected.join(','));
            });
        });
    </script>
@endpush
