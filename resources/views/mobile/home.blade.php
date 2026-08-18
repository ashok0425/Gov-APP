@extends('mobile.layout')

@section('title', 'बारबर्दिया नगरपालिका')
@section('shell-class', 'has-nav')

@section('appbar')
    @include('mobile.partials.app-banner')
@endsection

@section('content')
    {{-- Where this build of the app is standing. Set in admin under Cms;
         blank hides the bar rather than leaving an empty strip. Whatever the
         admin separates with commas is shown as a trail, broad to narrow. --}}
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
