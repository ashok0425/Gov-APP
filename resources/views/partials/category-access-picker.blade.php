{{-- The employee form's category picker: the menu cascade again, but every
     level takes several picks. Choose some categories and the subcategory
     list fills with all of their subcategories, grouped by parent, and so on
     down. The deepest picks on each branch are what the employee is pinned
     to; anything picked above them is just the way down.

     $selectedLevels holds the ids to preselect, one array per level. --}}
@php
    $columns = $columns ?? 3;
    $names = array_slice(['category', 'subcategory', 'child', 'grandchild'], 0, \App\Models\Category::MAX_DEPTH);
    $selectedLevels = collect($selectedLevels ?? []);
@endphp

<div class="row category-access-picker" data-tree='@json($categoryTree)'>
    @foreach ($names as $index => $name)
        <div class="mb-3 col-md-{{ $columns }}">
            <label class="form-label">
                {{ \App\Models\Category::LEVEL_NAMES[$index + 1] }}
                <small class="text-info">(optional)</small>
            </label>

            <select name="{{ $name }}[]"
                    multiple
                    class="form-control form-select access-level"
                    data-level="{{ $index }}"
                    data-selected="{{ implode(',', (array) old($name, $selectedLevels->get($index, []))) }}"
                    data-placeholder="select {{ Str::lower(\App\Models\Category::LEVEL_NAMES[$index + 1]) }}">
            </select>
        </div>
    @endforeach
</div>
