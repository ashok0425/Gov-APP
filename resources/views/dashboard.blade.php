@extends('layout.master')
@php
$totalBlog=App\Models\Blog::query()->count();
$totalWard=App\Models\Business::query()->count();
$totalCategory=App\Models\Category::query()->count();
$totalUser=App\Models\User::query()->count();

@endphp

@section('main-content')
    <style>
        .card {
            border: 0;
            border-radius: 0;
            font-size: 14px;
        }

        .fa {
            font-size: 2.8rem;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<div class="container-fluid p-0">
    @php
    $hour = now()->hour;
    if ($hour < 12) {
        $greeting = 'Good Morning';
    } elseif ($hour < 17) {
        $greeting = 'Good Afternoon';
    } else {
        $greeting = 'Good Evening';
    }
@endphp

<div class="alert alert-success bg-success text-white p-2">
    {{ $greeting }}  &nbsp;<strong>{{Auth::user()->name}} </strong>, Welcome Back!
</div>
@if (Auth::user()->can('do:anything'))

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-info shadow-sm">
                <div class="card-body  text-white">
                    <p style="font-size: 25px">Total Blog</p>
                    <p style="font-size:20px">{{ $totalBlog }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-secondary shadow-sm">
                <div class="card-body  text-white">
                    <p style="font-size: 25px">Total Ward</p>
                    <p style="font-size:20px">{{ $totalWard }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success shadow-sm">
                <div class="card-body  text-white">
                    <p style="font-size: 25px">Total Category</p>
                    <p style="font-size:20px">{{ $totalCategory }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning shadow-sm">
                <div class="card-body  text-white">
                    <p style="font-size: 25px">Total Team</p>
                    <p style="font-size:20px">{{ $totalUser }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif


</div>


@endsection

