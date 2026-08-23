@extends('mobile.layout')

@section('title', 'मेनु')
@section('shell-class', 'has-nav')

@section('appbar')
    @include('mobile.partials.app-banner')
@endsection

@section('content')
    @if ($organizations->isNotEmpty())
        <div class="grid grid-categories">
            @foreach ($organizations as $organization)
                @include('mobile.partials.category-tile', [
                    'category' => $organization,
                    'href' => route('m.organization', $organization->id),
                ])
            @endforeach
        </div>
    @else
        <div class="state"><p>कुनै विवरण भेटिएन</p></div>
    @endif

@endsection

@section('bottom')
    @include('mobile.partials.bottom-nav')
@endsection
