@extends('mobile.layout')

@section('title', 'Notifications')
@section('shell-class', 'has-nav')

@section('appbar')
    <header class="appbar-banner">
        <img src="{{ asset('mobile/img/mainbanner.gif') }}" alt="">
    </header>
@endsection

@section('content')
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
