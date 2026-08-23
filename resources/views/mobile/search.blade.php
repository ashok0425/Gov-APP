@extends('mobile.layout')

@section('title', 'Search')
@section('shell-class', 'has-nav')

@section('appbar')
    <header class="appbar appbar-search">
        <form class="search-box" id="search-form" action="{{ route('m.search') }}" method="GET" role="search">
            <span class="material-symbols-rounded">search</span>

            <input type="search"
                   id="search-input"
                   name="q"
                   value="{{ $term }}"
                   placeholder="Search organizations, categories, news…"
                   autocomplete="off"
                   autofocus
                   aria-label="Search">

            @if ($term !== '')
                <a class="search-clear" href="{{ route('m.search') }}" aria-label="Clear search">
                    <span class="material-symbols-rounded">close</span>
                </a>
            @endif
        </form>
    </header>
@endsection

@section('content')
    @php
        $menuHits = ($organizations ?? collect())->count() + ($categories ?? collect())->count();
    @endphp

    @if ($blogs === null)
        <div class="state">
            <p>Type at least two letters to search.</p>
            <p class="state-hint">Search organizations, categories, news and notices.</p>
        </div>
    @elseif ($blogs->isEmpty() && $menuHits === 0)
        <div class="state">
            <p>No results for “{{ $term }}”.</p>
            <p class="state-hint">Try a shorter word or a different spelling.</p>
        </div>
    @else
        @if ($organizations->isNotEmpty())
            <p class="search-count">{{ $organizations->count() }} {{ Str::plural('organization', $organizations->count()) }}</p>
            <div class="search-menu">
                @foreach ($organizations as $organization)
                    @include('mobile.partials.search-menu-row', [
                        'href' => route('m.organization', $organization->id),
                        'thumbnail' => $organization->thumbnail,
                        'icon' => 'apartment',
                        'name' => $organization->name,
                        'sub' => 'Organization',
                    ])
                @endforeach
            </div>
        @endif

        @if ($categories->isNotEmpty())
            <p class="search-count">{{ $categories->count() }} {{ Str::plural('category', $categories->count()) }}</p>
            <div class="search-menu">
                @foreach ($categories as $category)
                    @include('mobile.partials.search-menu-row', [
                        'href' => route('m.category', $category->id),
                        'thumbnail' => $category->thumbnail,
                        'icon' => 'category',
                        'name' => $category->name,
                        'sub' => $category->parent?->pathName() ?: $category->organization?->name,
                    ])
                @endforeach
            </div>
        @endif

        @if ($blogs->isNotEmpty())
            <p class="search-count">
                {{ $blogs->total() }} news {{ Str::plural('result', $blogs->total()) }} for “{{ $term }}”
            </p>

            @include('mobile.partials.infinite-list', [
                'blogs' => $blogs,
                'url' => route('m.search', ['q' => $term]),
            ])
        @endif
    @endif

@endsection

@section('bottom')
    @include('mobile.partials.bottom-nav')
@endsection
