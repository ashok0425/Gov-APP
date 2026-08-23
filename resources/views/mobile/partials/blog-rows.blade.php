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

        @if ($orgIcon && blank($rowImage))
            {{-- No icon uploaded for this organization: hold the slot open,
                 no grey placeholder. --}}
            <span class="blog-row-icon-spacer" aria-hidden="true"></span>
        @else
            {{-- A post with no picture of its own shows the app's icon. --}}
            <img src="{{ filled($rowImage) ? asset('storage/' . $rowImage) : asset('mobile/img/post-fallback.png') }}"
                 alt=""
                 loading="lazy"
                 data-fallback="{{ asset('mobile/img/post-fallback.png') }}">
        @endif

        <span class="blog-row-body">
            <span class="blog-row-title">{{ $blog->title }}</span>

            @unless ($orgIcon)
                <span class="blog-row-desc">{{ $blog->short_description }}</span>
            @endunless
        </span>
    </a>
@endforeach
