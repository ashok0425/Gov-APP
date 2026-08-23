@extends('mobile.layout')

@section('title', $page->name ?: $page->title)

@section('appbar')
    <header class="appbar">
        <span class="icon-btn"></span>
        <span class="appbar-title">{{ $page->name ?: $page->title }}</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    <div class="rich" style="padding:16px">
        {!! $body !!}
    </div>
@endsection
