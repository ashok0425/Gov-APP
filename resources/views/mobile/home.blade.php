@extends('mobile.layout')

@section('title', 'बारबर्दिया नगरपालिका')
@section('shell-class', 'has-nav')

@section('appbar')
    @include('mobile.partials.app-banner')
@endsection

@section('content')
    {{--
        The location bar is switched off for now. It reads whatever Cms holds
        in location text and shows the comma-separated parts as a trail,
        broad to narrow. Uncomment this block to bring it back; the
        .location-bar styles and the locationText the controller passes are
        both still in place.

        @php
            $placeTrail = collect(preg_split('/[,→›>]+/u', (string) $locationText))
                ->map(fn ($part) => trim($part))
                ->filter()
                ->values();
        @endphp

        @if ($placeTrail->isNotEmpty())
            <div class="location-bar">
                <span class="material-symbols-rounded">location_on</span>

                <span class="location-trail">
                    @foreach ($placeTrail as $place)
                        <span>{{ $place }}</span>
                        @if (! $loop->last)
                            <span class="location-arrow" aria-hidden="true">→</span>
                        @endif
                    @endforeach
                </span>
            </div>
        @endif
    --}}

    <div class="section">
        @include('mobile.partials.carousel', ['banners' => $banners])
    </div>

    {{-- सूचना runs as one scrolling line here rather than as a second picture
         slider, and stays stuck under the banner while you scroll. --}}
    @include('mobile.partials.news-ticker', ['posts' => $breaking])

    {{-- A taste of the menu: the first five entries in the admin's order,
         and a sixth tile that opens the full menu — a tidy 3x2 grid. --}}
    @if ($categories->isNotEmpty())
        <div class="grid grid-categories">
            @foreach ($categories->take(5) as $category)
                @include('mobile.partials.category-tile', [
                    'category' => $category,
                    'href' => route('m.category', $category->id),
                ])
            @endforeach

            <a href="{{ route('m.categories') }}" class="cat-tile">
                <span class="cat-icon">
                    <span class="material-symbols-rounded">apps</span>
                </span>

                <span class="cat-name">सबै हेर्नुहोस्</span>
            </a>
        </div>
    @endif

    <h2 class="section-title">सूचना तथा जनकारी</h2>

    @if ($blogs->isNotEmpty())
        {{-- Just a taste — the four newest. The rest is a category tap away. --}}
        <div class="blog-list">
            @include('mobile.partials.blog-rows', ['blogs' => $blogs])
        </div>
    @else
        <div class="blog-list">
            <div class="state"><p>कुनै विवरण भेटिएन</p></div>
        </div>
    @endif

@endsection

@section('bottom')
    @include('mobile.partials.bottom-nav')
@endsection
