@extends('mobile.layout')

@section('title', $page->name ?: $page->title)

@section('appbar')
    @include('mobile.partials.app-banner')
@endsection

@section('content')
    <h2 class="section-title">{{ $page->name ?: $page->title }}</h2>

    <div class="rich" style="padding:16px">
        {!! $body !!}
    </div>
@endsection
