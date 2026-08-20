@extends('mobile.layout')

@section('title', $notice->title)

@section('appbar')
    <header class="appbar">
        @include('mobile.partials.back-button', ['fallback' => route('m.notifications')])
        <span class="appbar-title">सूचना</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    <div class="rich">
        <h2>{{ $notice->title }}</h2>

        <p class="notice-date">{{ $notice->sent_at?->format('Y-m-d H:i') }}</p>

        @if (filled($notice->thumbnail))
            <img src="{{ asset('storage/' . $notice->thumbnail) }}" alt="">
        @endif

        @if (filled($notice->description))
            {!! $body !!}
        @elseif (filled($notice->short_description))
            <p>{{ $notice->short_description }}</p>
        @endif

        @if (filled($notice->link))
            <p><a href="{{ $notice->link }}" target="_blank" rel="noopener">{{ $notice->link }}</a></p>
        @endif
    </div>

    <div style="height:10px"></div>
@endsection
