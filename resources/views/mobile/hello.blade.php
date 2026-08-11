@extends('mobile.layout')

@section('title', 'Hello')
@section('shell-class', 'has-nav')

@section('appbar')
    <header class="appbar-banner">
        <img src="{{ asset('mobile/img/mainbanner.gif') }}" alt="">
    </header>
@endsection

@section('content')
    <div style="padding:8px">
        @forelse ($palikas as $palika)
            @include('mobile.partials.contact-card', [
                'entity' => $palika,
                'ownerLabel' => 'नगर प्रमुख',
            ])
        @empty
            <div class="state"><p>No Data Found</p></div>
        @endforelse
    </div>
@endsection

@section('bottom')
    @include('mobile.partials.bottom-nav')
@endsection
