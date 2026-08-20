{{-- The menu, one select per level: pick a category and the subcategory list
     fills itself, and so on down to child category. Every level below the
     first is optional — a post filed at a category simply stops there.

     $selected is the trail to preselect, deepest last. $required marks the top
     level on the post form; the filter leaves it off. $requiredDepth makes the
     first N levels mandatory — the category form uses it when the level being
     created is already decided. --}}
@php
    $selected = collect($selected ?? [])->values();
    $requiredDepth = $requiredDepth ?? (($required ?? false) ? 1 : 0);
    $columns = $columns ?? 3;
    $names = $names ?? array_slice(['category', 'subcategory', 'child', 'grandchild'], 0, \App\Models\Category::MAX_DEPTH);
@endphp

<div class="row category-cascade" data-tree='@json($categoryTree)'>
    @foreach ($names as $index => $name)
        <div class="mb-3 col-md-{{ $columns }}">
            <label class="form-label">
                {{ \App\Models\Category::LEVEL_NAMES[$index + 1] }}
                @if ($index >= $requiredDepth)
                    <small class="text-info">(optional)</small>
                @endif
            </label>

            <select name="{{ $name }}"
                    class="form-control form-select cascade-level"
                    data-level="{{ $index }}"
                    data-selected="{{ old($name, $selected->get($index)) }}"
                    data-placeholder="select {{ Str::lower(\App\Models\Category::LEVEL_NAMES[$index + 1]) }}"
                    {{ $index < $requiredDepth ? 'required' : '' }}>
                <option value="">select {{ Str::lower(\App\Models\Category::LEVEL_NAMES[$index + 1]) }}</option>
            </select>
        </div>
    @endforeach
</div>
