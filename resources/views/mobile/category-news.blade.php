@extends('mobile.layout')

@section('title', $title)

@section('appbar')
    <header class="appbar appbar-white">
        @include('mobile.partials.back-button', ['fallback' => $backRoute])
        <span class="appbar-title">{{ $title }}</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    {{-- Where in the menu this screen sits, once there is a level above it. --}}
    @if ($category->parent_id)
        <div class="breadcrumb">{{ $category->pathName() }}</div>
    @endif

    {{-- The category's own cover carousel, when the admin switched it on.
         The rows carry a thumbnail column, so the banner partial serves. --}}
    @if ($category->show_cover && $category->covers->isNotEmpty())
        <div class="section">
            @include('mobile.partials.carousel', ['banners' => $category->covers])
        </div>
    @endif

    {{-- What sits under this category, if anything does. --}}
    @if (($subcategories ?? collect())->isNotEmpty())
        <div class="grid grid-categories">
            @foreach ($subcategories as $subcategory)
                @include('mobile.partials.category-tile', [
                    'category' => $subcategory,
                    'href' => route('m.category', $subcategory->id),
                ])
            @endforeach
        </div>
    @endif

    {{-- Then the posts, which for a parent means everything filed below it. --}}
    @if ($blogs->isNotEmpty())
        @if (($subcategories ?? collect())->isNotEmpty())
            <h2 class="section-title">सूचना तथा समाचार</h2>
        @endif

        @include('mobile.partials.infinite-list', [
            'blogs' => $blogs,
            'url' => $listUrl,
        ])
    @elseif (($subcategories ?? collect())->isEmpty())
        <div class="state"><p>कुनै विवरण भेटिएन</p></div>
    @endif

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
