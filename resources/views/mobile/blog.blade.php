@extends('mobile.layout')

@section('title', $blog->title)

@section('appbar')
    <header class="appbar">
        <span class="icon-btn"></span>
        <span class="appbar-title">{{ $blog->title }}</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    <div class="rich">
        {!! $body !!}
    </div>

    <div style="height:10px"></div>
@endsection
