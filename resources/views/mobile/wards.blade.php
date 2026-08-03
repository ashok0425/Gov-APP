@extends('mobile.layout')

@section('title', 'My Ward')

@section('appbar')
    <header class="appbar">
        @include('mobile.partials.back-button')
        <span class="appbar-title">My Ward</span>
        <span class="icon-btn"></span>
    </header>
@endsection

@section('content')
    @if ($wards->isNotEmpty())
        <div class="grid grid-wards">
            @foreach ($wards as $ward)
                @if (filled($ward->thumbnail))
                    <a href="{{ route('m.ward', $ward->id) }}" aria-label="{{ $ward->name }}">
                        <img src="{{ asset('storage/' . $ward->thumbnail) }}"
                             alt=""
                             loading="lazy"
                             data-fallback="{{ asset('mobile/img/placeholder-thumb.jpeg') }}">
                    </a>
                @endif
            @endforeach
        </div>
    @else
        <div class="state"><p>No Data Found</p></div>
    @endif
@endsection
