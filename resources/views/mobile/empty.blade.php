@extends('mobile.layout')

@section('title', $title)

@section('appbar')
    <header class="appbar">
        <span class="icon-btn"></span>
        <span class="appbar-title">{{ $title }}</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    <div class="state"><p>{{ $message }}</p></div>
@endsection
