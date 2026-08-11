@extends('mobile.layout')

@section('title', 'Categories')

@section('appbar')
    <header class="appbar">
        @include('mobile.partials.back-button', ['fallback' => route('m.palika', $palika->id)])
        <span class="appbar-title">Categories</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    @if ($categories->isNotEmpty())
        <div class="grid grid-categories">
            @foreach ($categories as $category)
                @include('mobile.partials.category-tile', [
                    'category' => $category,
                    'href' => route('m.category.news', [$palika->id, $category->id]),
                ])
            @endforeach
        </div>
    @else
        <div class="state"><p>No Data Found</p></div>
    @endif
@endsection
