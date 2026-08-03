{{-- The elevation-1 news row used by every list in the app. --}}
@foreach ($blogs as $blog)
    <a class="blog-row" href="{{ route('m.blog', $blog->id) }}">
        <img src="{{ asset('storage/' . $blog->thumbnail) }}"
             alt=""
             loading="lazy"
             data-fallback="{{ asset('mobile/img/placeholder-thumb.jpeg') }}">

        <span class="blog-row-body">
            <span class="blog-row-title">{{ $blog->title }}</span>
            <span class="blog-row-desc">{{ $blog->short_description }}</span>
        </span>
    </a>
@endforeach
