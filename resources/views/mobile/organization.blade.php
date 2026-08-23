@extends('mobile.layout')

@section('title', $organization->name)

@section('appbar')
    {{-- With a top image the bar becomes the picture, the back arrow
         floating over it; without one the plain white title bar stays. --}}
    @if (filled($organization->top_image))
        <header class="appbar-cover">
            <img src="{{ asset('storage/' . $organization->top_image) }}"
                 alt=""
                 data-fallback="{{ asset('mobile/img/placeholder.jpeg') }}">
        </header>
    @else
        <header class="appbar appbar-white">
            <span class="icon-btn"></span>
            <span class="appbar-title">{{ $organization->name }}</span>
            <span class="icon-btn"></span>
        </header>
    @endif
@endsection

@section('content')
    @if ($categories->isNotEmpty())
        <div class="grid grid-categories">
            @foreach ($categories as $category)
                @include('mobile.partials.category-tile', [
                    'category' => $category,
                    'href' => route('m.category', $category->id),
                ])
            @endforeach
        </div>
    @else
        <div class="state"><p>कुनै विवरण भेटिएन</p></div>
    @endif
@endsection
