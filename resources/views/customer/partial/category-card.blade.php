<a href="{{route('store',$category->slug)}}" class="text-decoration-none text-center d-inline-block">
    <div class="d-flex flex-column align-items-center">
        <img
            lsrc="{{ getImage($category->thumbnail) }}"
            alt="{{ $category->name }}"
            class="rounded mb-2"
            height="50"
            width="50"
        />
        <p class="small text-dark m-0 px-2">{{ $category->name }}</p>
    </div>
</a>
