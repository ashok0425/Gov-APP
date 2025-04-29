@extends('layout.master')
@section('main-content')
    <div class="container mt-5">
      <img src="{{getImage($blog->thumbnail)}}" alt="" class="img-fluid" style="height: 500px">
      <h2 class="mt-3">{{$blog->title}}</h2>
      <div class="mt-4">
        {!! $blog->short_description !!}
      </div>
      <div class="mt-4">
        {!! $blog->long_description !!}
      </div>
    </div>
@endsection
