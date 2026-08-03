@extends('mobile.layout')

@section('title', 'My Setting')

@section('appbar')
    <header class="appbar">
        @include('mobile.partials.back-button')
        <span class="appbar-title">My Setting</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    <div style="padding:10px 15px">
        <a class="tile" href="{{ route('m.page', 'contact-us') }}">
            <span class="material-symbols-rounded">contact_emergency</span>
            <span>
                <span class="tile-title" style="display:block">Contact Us</span>
                <span class="tile-sub">View Contact Us</span>
            </span>
        </a>

        <div style="height:10px"></div>

        <a class="tile" href="{{ route('m.page', 'term-condition') }}">
            <span class="material-symbols-rounded">privacy_tip</span>
            <span>
                <span class="tile-title" style="display:block">Term &amp; Conditions</span>
                <span class="tile-sub">View Term &amp; Conditions</span>
            </span>
        </a>

        <div style="height:10px"></div>

        <a class="tile" href="{{ route('m.page', 'privacy-policy') }}">
            <span class="material-symbols-rounded">security</span>
            <span>
                <span class="tile-title" style="display:block">Privacy Policy</span>
                <span class="tile-sub">View Privacy Policy</span>
            </span>
        </a>

        <div style="height:10px"></div>

        <a class="tile" href="{{ route('m.page', 'about-us') }}">
            <span class="material-symbols-rounded">details</span>
            <span>
                <span class="tile-title" style="display:block">About Us</span>
                <span class="tile-sub">View About Us</span>
            </span>
        </a>

        <div style="height:10px"></div>

        <button type="button"
                class="tile"
                id="share-app"
                style="width:100%;text-align:left"
                data-url="https://play.google.com/store/apps/details?id=com.yaldmoon.barbardiya">
            <span class="material-symbols-rounded">share</span>
            <span>
                <span class="tile-title" style="display:block">Share App</span>
                <span class="tile-sub">View Share App</span>
            </span>
        </button>

        <div style="height:30px"></div>
    </div>
@endsection
