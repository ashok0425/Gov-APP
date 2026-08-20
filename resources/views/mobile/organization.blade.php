@extends('mobile.layout')

@section('title', $organization->name)

@section('appbar')
    <header class="appbar appbar-white">
        @include('mobile.partials.back-button', ['fallback' => route('m.home')])
        <span class="appbar-title">{{ $organization->name }}</span>
        <span class="icon-btn"></span>
    </header>
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
