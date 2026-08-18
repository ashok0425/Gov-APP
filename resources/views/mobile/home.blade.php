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
        @include('mobile.partials.carousel', ['banners' => $banners, 'autoplay' => true])
    </div>

    {{-- The breaking headlines run as one scrolling line here rather than as a
         second picture slider — they are the same posts either way. --}}
    @include('mobile.partials.news-ticker', ['posts' => $breaking])

    {{-- The menu itself, in the order the admin arranged it. --}}
    @if ($categories->isNotEmpty())
        <div class="grid grid-categories">
            @foreach ($categories as $category)
                @include('mobile.partials.category-tile', [
                    'category' => $category,
                    'href' => route('m.category', $category->id),
                ])
            @endforeach
        </div>
    @endif

    <h2 class="section-title">सूचना तथा जनकारी</h2>

    <div class="blog-list">
        @if ($blogs->isNotEmpty())
            @include('mobile.partials.blog-rows', ['blogs' => $blogs])
        @else
            <div class="state"><p>कुनै विवरण भेटिएन</p></div>
        @endif
    </div>
@endsection

@section('bottom')
    @include('mobile.partials.bottom-nav')
@endsection
