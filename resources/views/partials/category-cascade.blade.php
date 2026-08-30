{{-- The menu, one select per level: pick a category and the subcategory list
     fills itself, and so on down to child category. Every level below the
     first is optional — a post filed at a category simply stops there.

     $selected is the trail to preselect, deepest last. $required marks the top
     level on the post form; the filter leaves it off. $requiredDepth makes the
     first N levels mandatory — the category form uses it when the level being
     created is already decided. $labels renames the levels (keyed 1..4 like
     Category::LEVEL_NAMES) — the post pages pass Category::POST_LEVEL_NAMES. --}}
@php
    $selected = collect($selected ?? [])->values();
    $requiredDepth = $requiredDepth ?? (($required ?? false) ? 1 : 0);
    $columns = $columns ?? 3;
    $labels = $labels ?? \App\Models\Category::LEVEL_NAMES;
    // Unless the caller names the levels itself, only go as deep as the tree
    // does: an employee given no child or grandchild categories should not
    // see a child or grandchild select at all.
    if (! isset($names)) {
        $depthOf = function ($nodes) use (&$depthOf) {
            return collect($nodes)->max(fn ($node) => 1 + $depthOf($node['children'] ?? [])) ?? 0;
        };
        $depth = max($depthOf($categoryTree), $requiredDepth, 1);
        $names = array_slice(['category', 'subcategory', 'child', 'grandchild'], 0, min($depth, \App\Models\Category::MAX_DEPTH));
    }
    // Pass $organizations to lead the cascade with an organization select
    // that narrows the category list to that organization's menu — the
    // category form does; post forms and filters go straight to the category.
    $organizations = $organizations ?? null;
    $selectedOrganization = old('organization', $selectedOrganization ?? null);
@endphp

<div class="row category-cascade" data-tree='@json($categoryTree)'
     data-pinned="{{ auth()->user()?->isPinned() ? 1 : 0 }}">
    @if ($organizations)
        <div class="mb-3 col-md-{{ $columns }}">
            <label class="form-label">
                Organization
                @if ($requiredDepth === 0)
                    <small class="text-info">(optional)</small>
                @endif
            </label>

            <select name="organization"
                    class="form-control form-select cascade-organization"
                    data-placeholder="select organization"
                    {{ $requiredDepth > 0 ? 'required' : '' }}>
                <option value="">select organization</option>
                @foreach ($organizations as $cascadeOrganization)
                    <option value="{{ $cascadeOrganization->id }}"
                        {{ (string) $selectedOrganization === (string) $cascadeOrganization->id ? 'selected' : '' }}>
                        {{ $cascadeOrganization->name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif
    @foreach ($names as $index => $name)
        <div class="mb-3 col-md-{{ $columns }}">
            <label class="form-label">
                {{ $labels[$index + 1] }}
                @if ($index >= $requiredDepth)
                    <small class="text-info">(optional)</small>
                @endif
            </label>

            <select name="{{ $name }}"
                    class="form-control form-select cascade-level"
                    data-level="{{ $index }}"
                    data-selected="{{ old($name, $selected->get($index)) }}"
                    data-placeholder="select {{ $labels[$index + 1] }}"
                    {{ $index < $requiredDepth ? 'required' : '' }}>
                <option value="">select {{ $labels[$index + 1] }}</option>
            </select>
        </div>
    @endforeach
</div>
