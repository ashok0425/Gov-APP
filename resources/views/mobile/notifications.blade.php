@extends('mobile.layout')

@section('title', 'सूचना')
@section('shell-class', 'has-nav')

@section('appbar')
    @include('mobile.partials.app-banner')
@endsection

@section('content')
    <div class="blog-list">
        @if ($notices->isNotEmpty())
            @include('mobile.partials.notice-rows', ['notices' => $notices])
        @else
            <div class="state"><p>कुनै नयाँ सूचना छैन</p></div>
        @endif
    </div>
@endsection

@section('bottom')
    @include('mobile.partials.bottom-nav')
@endsection
