{{-- The elevation-1 news row used by every list in the app. Pass
     orgIcon: true for home's compact rows — title only, and the icon of the
     organization the post was filed under instead of its own thumbnail. --}}
@php
    $orgIcon = $orgIcon ?? false;
@endphp

@foreach ($blogs as $blog)
    <a class="blog-row {{ $orgIcon ? 'blog-row-compact' : '' }}" href="{{ route('m.blog', $blog->id) }}">
        @php
            $rowImage = $orgIcon
                ? optional($blog->category?->organization)->thumbnail
                : $blog->thumbnail;
        @endphp

        <img src="{{ asset('storage/' . $rowImage) }}"
             alt=""
             loading="lazy"
             data-fallback="{{ asset('mobile/img/placeholder-thumb.jpeg') }}">

        <span class="blog-row-body">
            <span class="blog-row-title">{{ $blog->title }}</span>

            @unless ($orgIcon)
                <span class="blog-row-desc">{{ $blog->short_description }}</span>
            @endunless
        </span>
    </a>
@endforeach
