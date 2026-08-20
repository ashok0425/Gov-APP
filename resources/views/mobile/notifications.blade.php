@extends('mobile.layout')

@section('title', 'सूचना')
@section('shell-class', 'has-nav')

@section('appbar')
    @include('mobile.partials.app-banner')
@endsection

@section('content')
    {{-- The same posts the nav badge counts: published in the last 24 hours. --}}
    <div class="blog-list">
        @if ($blogs->isNotEmpty())
            @include('mobile.partials.blog-rows', ['blogs' => $blogs])
        @else
            <div class="state"><p>कुनै नयाँ सूचना छैन</p></div>
        @endif
    </div>

@endsection

@section('bottom')
    @include('mobile.partials.bottom-nav')
@endsection
