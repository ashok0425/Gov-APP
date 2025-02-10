@extends('layouts.minimal')
@section('content')
@include('customer.layout.mini-header', [
        'title' => 'Privacy Policy',
        'subtitle' => 'App privacy policy to use'
    ])
    <div class="py-5">
        <section class="container">
            <div class=" mt-5">
                @php
        $privacyPolicy = App\Models\Page::where('slug','privacy-policy')->first();
    @endphp
    {!!$privacyPolicy?->description!!}
            </div>
        </section>
    </div>

@endsection

