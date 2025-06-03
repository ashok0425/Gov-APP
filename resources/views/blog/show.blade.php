@extends('layout.master')
@section('main-content')
    <div class="container mt-5">
        <div>
            <a href="{{url()->previous()}}" class="btn btn-info mb-4"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
      <img src="{{getImage($post->thumbnail)}}" alt="" class="img-fluid" style="height: 500px">
      <h2 class="mt-3">{{$post->title}}</h2>
      <div class="mt-4">
        {!! $post->short_description !!}
      </div>
      <div class="mt-4">
        {!! $post->long_description !!}
      </div>
    </div>
@endsection
