@extends('mobile.layout')

@section('title', 'Palika')
@section('shell-class', 'has-nav')

@section('appbar')
    <header class="appbar">
        @include('mobile.partials.back-button')
        <span class="appbar-title">Palika</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    @if ($palikas->isNotEmpty())
        <div class="grid grid-palikas">
            @foreach ($palikas as $palika)
                <a href="{{ route('m.palika', $palika->id) }}" aria-label="{{ $palika->name }}">
                    @if (filled($palika->thumbnail))
                        <img src="{{ asset('storage/' . $palika->thumbnail) }}"
                             alt=""
                             loading="lazy"
                             data-fallback="{{ asset('mobile/img/placeholder-thumb.jpeg') }}">
                    @else
                        <span class="material-symbols-rounded">location_city</span>
                    @endif
                </a>
            @endforeach
        </div>
    @else
        <div class="state"><p>No Data Found</p></div>
    @endif
@endsection

@section('bottom')
    @include('mobile.partials.bottom-nav')
@endsection
