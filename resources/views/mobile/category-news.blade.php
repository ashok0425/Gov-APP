@extends('mobile.layout')

@section('title', $category->name)

@section('appbar')
    <header class="appbar appbar-white">
        @include('mobile.partials.back-button', ['fallback' => route('m.categories', $ward->id)])
        <span class="appbar-title">{{ $category->name }}</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    @if ($blogs->isNotEmpty())
        <div class="blog-list"
             id="infinite-list"
             data-url="{{ route('m.category.news', [$ward->id, $category->id]) }}"
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
