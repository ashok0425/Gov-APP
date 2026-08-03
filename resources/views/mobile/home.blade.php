@extends('mobile.layout')

@section('title', 'बारबर्दिया नगरपालिका')
@section('shell-class', 'has-nav')

@section('splash')
    <div class="splash">
        <img src="{{ asset('mobile/img/app-logo.png') }}" alt="">
    </div>
@endsection

@section('appbar')
    <header class="appbar-banner">
        <img src="{{ asset('mobile/img/mainbanner.gif') }}" alt="">
    </header>
@endsection

@section('content')
    <div class="section">
        @include('mobile.partials.carousel', ['banners' => $banners, 'autoplay' => true])
    </div>

    <div class="ward-strip">
        @foreach ($wards as $ward)
            <a class="ward-circle" href="{{ route('m.ward', $ward->id) }}" aria-label="{{ $ward->name }}">
                @if (filled($ward->thumbnail))
                    <img src="{{ asset('storage/' . $ward->thumbnail) }}"
                         alt=""
                         loading="lazy"
                         data-fallback="{{ asset('mobile/img/placeholder-thumb.jpeg') }}">
                @else
                    <span class="material-symbols-rounded">location_city</span>
                @endif
            </a>
        @endforeach
    </div>

    <h2 class="section-title">सूचना तथा जनकारी</h2>

    <div class="blog-list">
        @if ($blogs->isNotEmpty())
            @include('mobile.partials.blog-rows', ['blogs' => $blogs])
        @else
            <div class="state"><p>No Data Found</p></div>
        @endif
    </div>
@endsection

@section('bottom')
    @include('mobile.partials.bottom-nav')
@endsection
