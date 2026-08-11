@extends('mobile.layout')

@section('title', $title)

@section('appbar')
    <header class="appbar appbar-white">
        @include('mobile.partials.back-button', ['fallback' => $backRoute])
        <span class="appbar-title">{{ $title }}</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    @if ($blogs->isNotEmpty())
        <div class="blog-list"
             id="infinite-list"
             data-url="{{ $listUrl }}"
             data-page="{{ $blogs->currentPage() }}"
             data-has-more="{{ $blogs->hasMorePages() ? 'true' : 'false' }}">
            @include('mobile.partials.blog-rows', ['blogs' => $blogs])
        </div>

        @if ($blogs->hasMorePages())
            <div id="infinite-sentinel"><div class="spinner"></div></div>
        @endif
    @else
        <div class="state"><p>Data Not Found!</p></div>
    @endif
@endsection
