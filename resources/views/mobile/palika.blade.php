@extends('mobile.layout')

@section('title', $palika->name)

@section('appbar')
    <header class="appbar-cover">
        @if (filled($palika->cover_image))
            <img src="{{ asset('storage/' . $palika->cover_image) }}"
                 alt=""
                 data-fallback="{{ asset('mobile/img/placeholder.jpeg') }}">
        @endif
    </header>
@endsection

@section('content')
    <div class="section">
        @include('mobile.partials.carousel', ['banners' => $bannersOne])
    </div>

    @if ($bannersTwo->isNotEmpty())
        <h2 class="section-title">जनप्रतिनिधि / कर्मचारी</h2>

        <div class="section" style="padding-top:0">
            @include('mobile.partials.carousel', ['banners' => $bannersTwo])
        </div>
    @endif

    <h2 class="section-title" style="padding-top:18px">{{ $blogsHeading }}</h2>

    <div class="blog-list">
        @if ($blogs->isNotEmpty())
            @include('mobile.partials.blog-rows', ['blogs' => $blogs])
        @else
            <div class="state"><p>कुनै विवरण भेटिएन</p></div>
        @endif
    </div>

    <div style="padding:15px">
        <a class="btn-primary" href="{{ route('m.categories') }}">See More Menu</a>
    </div>

    {{-- Room for the floating contact button so it never sits on the last row. --}}
    <div style="height:90px"></div>
@endsection

@section('bottom')
    @include('mobile.partials.contact-fab', [
        'entity' => $palika,
        'ownerLabel' => 'नगर प्रमुख',
    ])
@endsection
