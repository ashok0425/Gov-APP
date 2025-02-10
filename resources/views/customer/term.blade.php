@extends('layouts.minimal')
@section('content')
@include('customer.layout.mini-header', [
        'title' => 'Term & Condition',
        'subtitle' => 'Term & Condition to use Drebba'
    ])
    <div class="py-5">
        <section class="container">
            <div class=" mt-5">
                @php
        $term = App\Models\Page::where('slug','term-condition')->first();
    @endphp
    {!!$term?->description!!}
            </div>
        </section>
    </div>

@endsection

