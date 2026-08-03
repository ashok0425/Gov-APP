@extends('mobile.layout')

@section('title', $ward->name)

@section('appbar')
    <header class="appbar-cover">
        @include('mobile.partials.back-button', ['fallback' => route('m.home')])

        @if (filled($ward->cover_image))
            <img src="{{ asset('storage/' . $ward->cover_image) }}"
                 alt=""
                 data-fallback="{{ asset('mobile/img/placeholder.jpeg') }}">
        @endif
    </header>
@endsection

@section('content')
    <div class="section">
        @include('mobile.partials.carousel', ['banners' => $bannersOne, 'autoplay' => true])
    </div>

    @if ($showStaffSlider && $bannersTwo->isNotEmpty())
        <h2 class="section-title">जनप्रतिनिधि / कर्मचारी</h2>

        <div class="section" style="padding-top:0">
            @include('mobile.partials.carousel', ['banners' => $bannersTwo, 'autoplay' => false])
        </div>
    @endif

    <h2 class="section-title" style="padding-top:18px">{{ $blogsHeading }}</h2>

    <div class="blog-list">
        @if ($blogs->isNotEmpty())
            @include('mobile.partials.blog-rows', ['blogs' => $blogs])
        @else
            <div class="state"><p>No Data Found</p></div>
        @endif
    </div>

    <div style="padding:15px">
        <a class="btn-primary" href="{{ route('m.categories', $ward->id) }}">See More Menu</a>
    </div>

    <div style="height:50px"></div>
@endsection
