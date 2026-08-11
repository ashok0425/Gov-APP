{{-- One square tile in a category or subcategory grid. --}}
<a href="{{ $href }}" aria-label="{{ $category->name }}">
    @if (filled($category->thumbnail))
        <img src="{{ asset('storage/' . $category->thumbnail) }}"
             alt=""
             loading="lazy"
             data-fallback="{{ asset('mobile/img/placeholder-thumb.jpeg') }}">
    @else
        {{-- Without artwork the icon alone says nothing, so name the tile. --}}
        <span class="tile-fallback">
            <span class="material-symbols-rounded">category</span>
            <span class="tile-fallback-name">{{ $category->name }}</span>
        </span>
    @endif
</a>
