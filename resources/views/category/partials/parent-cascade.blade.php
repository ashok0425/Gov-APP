{{-- Where this record sits in the menu. Pick as far down as you want and it
     is filed under the deepest level chosen; leave them all empty and it is a
     main category. $levels is how many levels are still available — a record
     that is itself several levels tall has fewer places it can go. --}}
<div class="row">
    <div class="col-md-12">
        <label class="form-label mb-0"><b>Parent</b></label>

        @if ($levels > 0)
            <p class="text-muted small mb-2">
                Filed under the deepest level you choose — leave them all empty to create a
                main category.
            </p>
        @else
            <p class="text-info small mb-2">
                Nothing can hold this one without pushing the menu past
                {{ \App\Models\Category::MAX_DEPTH }} levels, so it stays where it is.
            </p>
        @endif
    </div>
</div>

@if ($levels > 0)
    @include('partials.category-cascade', [
        'categoryTree' => $categoryTree,
        'selected' => $parentTrail,
        'names' => array_slice(['category', 'subcategory', 'child', 'grandchild'], 0, $levels),
        'columns' => 4,
    ])
@endif
