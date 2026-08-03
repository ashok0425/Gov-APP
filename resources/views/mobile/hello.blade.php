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
        @if ($palika)
            @include('mobile.partials.contact-card', [
                'entity' => $palika,
                'ownerLabel' => 'नगर प्रमुख',
            ])
        @endif

        @foreach ($wards as $ward)
            @include('mobile.partials.contact-card', [
                'entity' => $ward,
                'ownerLabel' => 'वडा अध्यक्ष',
            ])
        @endforeach
    </div>
@endsection

@section('bottom')
    @include('mobile.partials.bottom-nav')
@endsection
