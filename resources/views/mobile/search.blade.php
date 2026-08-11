@extends('mobile.layout')

@section('title', 'Search')
@section('shell-class', 'has-nav')

@section('appbar')
    <header class="appbar appbar-search">
        <form class="search-box" action="{{ route('m.search') }}" method="GET" role="search">
            <span class="material-symbols-rounded">search</span>

            <input type="search"
                   name="q"
                   value="{{ $term }}"
                   placeholder="Search news, notices, forms…"
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
    @if ($blogs === null)
        <div class="state">
            <p>Type at least two letters to search.</p>
            <p class="state-hint">
                Nepali and English both work — typing <b>sifaris</b> also finds <b>सिफारिस</b>.
            </p>
        </div>
    @elseif ($blogs->isEmpty())
        <div class="state">
            <p>No results for “{{ $term }}”.</p>
            <p class="state-hint">Try a shorter word or a different spelling.</p>
        </div>
    @else
        <p class="search-count">
            {{ $blogs->total() }} {{ Str::plural('result', $blogs->total()) }} for “{{ $term }}”
            @if ($matchedNepali)
                <span class="search-hint">· including Nepali spellings</span>
            @endif
        </p>

        <div class="blog-list"
             id="infinite-list"
             data-url="{{ route('m.search', ['q' => $term]) }}"
             data-page="{{ $blogs->currentPage() }}"
             data-has-more="{{ $blogs->hasMorePages() ? 'true' : 'false' }}">
            @include('mobile.partials.blog-rows', ['blogs' => $blogs])
        </div>

        @if ($blogs->hasMorePages())
            <div id="infinite-sentinel"><div class="spinner"></div></div>
        @endif
    @endif
@endsection

@section('bottom')
    @include('mobile.partials.bottom-nav')
@endsection
