@extends('mobile.layout')

@section('title', $palika->name)

@section('appbar')
    <header class="appbar-cover">
        @include('mobile.partials.back-button', ['fallback' => route('m.palikas')])

        @if (filled($palika->cover_image))
            <img src="{{ asset('storage/' . $palika->cover_image) }}"
                 alt=""
                 data-fallback="{{ asset('mobile/img/placeholder.jpeg') }}">
        @endif
    </header>
@endsection

@section('content')
    <div class="section">
        @include('mobile.partials.carousel', ['banners' => $bannersOne, 'autoplay' => true])
    </div>

    @if ($bannersTwo->isNotEmpty())
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
        <a class="btn-primary" href="{{ route('m.categories', $palika->id) }}">See More Menu</a>
    </div>

    {{-- Room for the floating contact button so it never sits on the last row. --}}
    <div style="height:90px"></div>
@endsection

@section('bottom')
    {{-- Floating contact button — opens this palika's contact details. --}}
    <button type="button" class="fab-contact" id="contact-open" aria-label="Contact {{ $palika->name }}">
        <span class="material-symbols-rounded">call</span>
    </button>

    <div class="sheet-scrim" id="contact-scrim"></div>

    <div class="sheet sheet-contact" id="contact-sheet">
        <div class="sheet-handle"></div>

        <div class="sheet-scroll">
            @include('mobile.partials.contact-card', [
                'entity' => $palika,
                'ownerLabel' => 'नगर प्रमुख',
            ])
        </div>
    </div>
@endsection
