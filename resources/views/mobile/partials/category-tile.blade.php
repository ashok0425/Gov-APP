{{-- One tile in a category or subcategory grid: a small square icon with the
     category's name under it. The icon is deliberately 60x60 — these are menu
     entries, not photographs, and the name is what a citizen reads. --}}
<a href="{{ $href }}" class="cat-tile">
    <span class="cat-icon">
        @if (filled($category->thumbnail))
            <img src="{{ asset('storage/' . $category->thumbnail) }}"
                 alt=""
                 width="60"
                 height="60"
                 loading="lazy"
                 data-fallback-icon="category">
        @else
            <span class="material-symbols-rounded">category</span>
        @endif
    </span>

    <span class="cat-name">{{ $category->name }}</span>
</a>
