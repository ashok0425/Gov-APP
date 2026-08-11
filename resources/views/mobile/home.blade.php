@extends('mobile.layout')

@section('title', 'बारबर्दिया नगरपालिका')
@section('shell-class', 'has-nav')

@section('splash')
    <div class="splash">
        <img src="{{ asset('mobile/img/app-logo.png') }}" alt="">
    </div>
@endsection

@section('appbar')
    @include('mobile.partials.app-banner')
@endsection

@section('content')
    <div class="section">
        @include('mobile.partials.carousel', ['banners' => $banners, 'autoplay' => true])
    </div>

    @if ($breaking->isNotEmpty())
        <h2 class="section-title">Breaking News</h2>

        <div class="section" style="padding-top:8px">
            @include('mobile.partials.news-carousel', ['posts' => $breaking])
        </div>
    @endif

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
