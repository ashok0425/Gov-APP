@extends('mobile.layout')

@section('title', 'Categories')

@section('appbar')
    <header class="appbar">
        @include('mobile.partials.back-button', ['fallback' => route('m.ward', $ward->id)])
        <span class="appbar-title">Categories</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    @if ($categories->isNotEmpty())
        <div class="grid grid-categories">
            @foreach ($categories as $category)
                <a href="{{ route('m.category.news', [$ward->id, $category->id]) }}"
                   aria-label="{{ $category->name }}">
                    @if (filled($category->thumbnail))
                        <img src="{{ asset('storage/' . $category->thumbnail) }}"
                             alt=""
                             loading="lazy"
                             data-fallback="{{ asset('mobile/img/placeholder-thumb.jpeg') }}">
                    @else
                        <span class="material-symbols-rounded">category</span>
                    @endif
                </a>
            @endforeach
        </div>
    @else
        <div class="state"><p>No Data Found</p></div>
    @endif
@endsection
