@extends('mobile.layout')

@section('title', $category->name)

@section('appbar')
    <header class="appbar">
        @include('mobile.partials.back-button', ['fallback' => route('m.categories', $palika->id)])
        <span class="appbar-title">{{ $category->name }}</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    <div class="grid grid-categories">
        @foreach ($subcategories as $subcategory)
            @include('mobile.partials.category-tile', [
                'category' => $subcategory,
                'href' => route('m.subcategory.news', [$palika->id, $category->id, $subcategory->id]),
            ])
        @endforeach
    </div>
@endsection
