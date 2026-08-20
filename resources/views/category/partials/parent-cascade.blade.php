{{-- Where this record sits in the menu. On the create form the level is
     already decided, so every select shown is required; on the edit form the
     selects stay optional so a record can be moved — or left where it is.
     $levels is how many levels are still available — a record that is itself
     several levels tall has fewer places it can go. --}}
@php
    $requiredDepth = $requiredDepth ?? 0;
    $organizations = $organizations ?? null;
    $selectedOrganization = $selectedOrganization ?? null;
@endphp

<div class="row">
    <div class="col-md-12">
        <label class="form-label mb-0"><b>Parent</b></label>

        @if ($requiredDepth > 0)
            <p class="text-muted small mb-2">
                Pick which branch of the menu this sits under.
            </p>
        @elseif ($levels > 0)
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
        'requiredDepth' => $requiredDepth,
        'organizations' => $organizations,
        'selectedOrganization' => $selectedOrganization,
    ])
@endif
