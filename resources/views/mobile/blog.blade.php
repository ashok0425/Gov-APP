@extends('mobile.layout')

@section('title', $blog->title)

@section('appbar')
    {{-- The post wears the strip of the category it was filed under, the same
         way that category's own screen does; without one the plain bar stays. --}}
    @if (filled($topImage))
        <header class="appbar-cover">
            <img src="{{ asset('storage/' . $topImage) }}"
                 alt=""
                 data-fallback-hide>
        </header>
    @else
        <header class="appbar appbar-white">
            <span class="icon-btn"></span>
            <span class="appbar-title">{{ $blog->title }}</span>
            <span class="icon-btn"></span>
        </header>
    @endif
@endsection

@section('content')
    @if ($category)
        <div class="breadcrumb">{{ $category->pathName() }}</div>
    @endif

    {{-- With the picture in the bar there is nowhere else the title is shown. --}}
    @if (filled($topImage))
        <h1 class="post-title">{{ $blog->title }}</h1>
    @endif

    <div class="rich">
        {!! $body !!}
    </div>

    <div style="height:10px"></div>
@endsection
