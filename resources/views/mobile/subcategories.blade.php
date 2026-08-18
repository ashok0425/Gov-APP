@extends('mobile.layout')

@section('title', $category->name)

@section('appbar')
    <header class="appbar">
        @include('mobile.partials.back-button', ['fallback' => $backRoute])
        <span class="appbar-title">{{ $category->name }}</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    {{-- Where in the menu this screen sits, once there is a level above it. --}}
    @if ($category->parent_id)
        <div class="breadcrumb">{{ $category->pathName() }}</div>
    @endif

    <div class="grid grid-categories">
        @foreach ($subcategories as $subcategory)
            @include('mobile.partials.category-tile', [
                'category' => $subcategory,
                'href' => route('m.category', $subcategory->id),
            ])
        @endforeach
    </div>

    @if ($category->hasContact())
        {{-- Room for the floating contact button so it never sits on the last row. --}}
        <div style="height:90px"></div>
    @endif
@endsection

@section('bottom')
    @if ($category->hasContact())
        @include('mobile.partials.contact-fab', [
            'entity' => $category,
            'ownerLabel' => 'सम्पर्क व्यक्ति',
        ])
    @endif
@endsection
