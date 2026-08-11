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
                   placeholder="Search news, notices, forms…"
                   autocomplete="off"
                   autofocus
                   aria-label="Search">

            @if ($term !== '')
                <a class="search-clear" href="{{ route('m.search') }}" aria-label="Clear search">
                    <span class="material-symbols-rounded">close</span>
                </a>
            @endif

            {{-- Opens the on-screen Devanagari keyboard for phones with no Nepali layout. --}}
            <button type="button"
                    class="kb-toggle"
                    id="nep-kb-toggle"
                    aria-controls="nep-kb"
                    aria-pressed="false"
                    aria-label="नेपाली किबोर्ड">ने</button>
        </form>
    </header>
@endsection

@section('content')
    @if ($blogs === null)
        <div class="state">
            <p>Type at least two letters to search.</p>
            <p class="state-hint">
                Nepali and English both work — typing <b>sifaris</b> also finds <b>सिफारिस</b>.
                Tap <b>ने</b> to type in Devanagari.
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
    {{-- Sits above the nav inside the shell's flex column, so it shortens the
         results list instead of covering it. --}}
    @include('mobile.partials.nepali-keyboard')
    @include('mobile.partials.bottom-nav')
@endsection
