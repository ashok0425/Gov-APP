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

        <div class="blog-list"
             id="infinite-list"
             data-url="{{ $listUrl }}"
             data-page="{{ $blogs->currentPage() }}"
             data-has-more="{{ $blogs->hasMorePages() ? 'true' : 'false' }}">
            @include('mobile.partials.blog-rows', ['blogs' => $blogs])
        </div>

        @if ($blogs->hasMorePages())
            <div id="infinite-sentinel"><div class="spinner"></div></div>
        @endif
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
