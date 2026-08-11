@extends('layout.master')
@php
$totalBlog=App\Models\Blog::when(!Auth::user()->can('do:anything'),function($query){
                $query= $query->where('business_id',Auth::user()->business_id);
                if (!Auth::user()->is_owner) {
                    $query->where('user_id',Auth::user()->id);
                }

            })
->count();
$blogs=App\Models\Blog::when(!Auth::user()->can('do:anything'),function($query){
                $query= $query->where('business_id',Auth::user()->business_id);
                if (!Auth::user()->is_owner) {
                    $query->where('user_id',Auth::user()->id);
                }

            })
->limit(5)->latest()->get();
$users=App\Models\User::when(!Auth::user()->can('do:anything'),function($query){
    $query->where('business_id',Auth::user()->business_id);
})
->limit(5)->latest()->get();
$draftBlog=App\Models\Blog::when(!Auth::user()->can('do:anything'),function($query){
                $query= $query->where('business_id',Auth::user()->business_id);
                if (!Auth::user()->is_owner) {
                    $query->where('user_id',Auth::user()->id);
                }

            })->where('status',0)
->count();

$publishBlog=App\Models\Blog::when(!Auth::user()->can('do:anything'),function($query){
                $query= $query->where('business_id',Auth::user()->business_id);
                if (!Auth::user()->is_owner) {
                    $query->where('user_id',Auth::user()->id);
                }

            })->where('status',1)
->count();
$totalPalika=App\Models\Business::query()->count();
$totalBanner=App\Models\Banner::when(!Auth::user()->can('do:anything'),function($query){
    $query->where('business_id',Auth::user()->business_id);
})->count();
$totalUser=App\Models\User::when(!Auth::user()->can('do:anything'),function($query){
    $query->where('business_id',Auth::user()->business_id);
})->count();

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


    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm stat-card border-0 rounded text-center">
                <a href="{{route('blogs.index')}}" class="text-decoration-none text-dark">
                    <div class="card-body py-4">
                        <div class="icon-circle mx-auto mb-3">
                            <i class="fas fa-copy fa-2x"></i>
                        </div>
                        <small class="text-muted h5">Total Posts</small>
                        <h4 class="fw-bold mt-1 h3">{{$totalBlog}}</h4>
                    </div>
                </a>
            </div>
        </div>
        @if (!Auth::user()->can('do:anything'))
        <div class="col-md-3">
            <div class="card shadow-sm stat-card border-0 rounded text-center">
                <a href="{{route('blogs.index',['status'=>0])}}" class="text-decoration-none text-dark">
                <div class="card-body py-4">
                    <div class="icon-circle mx-auto mb-3">
                        <i class="fas fa-toolbox fa-2x"></i>
                    </div>
                    <small class="text-muted h5">Draft Posts</small>
                    <h4 class="fw-bold mt-1 h3">{{$draftBlog}}</h4>
                </div>
                </a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm stat-card border-0 rounded text-center">
                <a href="{{route('blogs.index',['status'=>1])}}" class="text-decoration-none text-dark">
                <div class="card-body py-4">
                    <div class="icon-circle mx-auto mb-3">
                        <i class="fas fa-cogs fa-2x"></i>
                    </div>
                    <small class="text-muted h5">Publish Posts</small>
                    <h4 class="fw-bold mt-1 h3">{{$publishBlog}}</h4>
                </div>
                </a>
            </div>
        </div>


        @endif

        @if (Auth::user()->can('do:anything'))
        <div class="col-md-3">
            <div class="card shadow-sm stat-card border-0 rounded text-center">
                <a href="{{route('banners.index',['type'=>1])}}" class="text-decoration-none text-dark">
                <div class="card-body py-4">
                    <div class="icon-circle mx-auto mb-3">
                        <i class="fas fa-image fa-2x"></i>
                    </div>
                    <small class="text-muted h5">Total Banner</small>
                    <h4 class="fw-bold mt-1 h3">{{$totalBanner}}</h4>
                </div>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm stat-card border-0 rounded text-center">
                <a href="{{route('palika.index')}}" class="text-decoration-none text-dark">
                <div class="card-body py-4">
                    <div class="icon-circle mx-auto mb-3">
                        <i class="fas fa-home fa-2x"></i>
                    </div>
                    <small class="text-muted h5">Total Palika</small>
                    <h4 class="fw-bold mt-1 h3">{{$totalPalika}}</h4>
                </div>
                </a>
            </div>
        </div>


        @endif

        <div class="col-md-3">
            <div class="card shadow-sm stat-card border-0 rounded text-center">
                <a href="{{route('access.index')}}" class="text-decoration-none text-dark">
                <div class="card-body py-4">
                    <div class="icon-circle mx-auto mb-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <small class="text-muted h5">Total User</small>
                    <h4 class="fw-bold mt-1 h3">{{$totalUser}}</h4>
                </div>
                </a>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Recent Post
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>
                                #
                            </th>
                            <th>Title</th>
                            <th>Thumbnail</th>

                        </thead>
                        <tbody>
                            @foreach ($blogs as $blog)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$blog->title}}</td>
                                <td><img src="{{getImage($blog->thumbnail)}}" alt="" width="30" class="rounded-circle" height="30"></td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Employee List
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>
                                #
                            </th>
                            <th>Name</th>
                            <th>Phone</th>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->phone}}</td>


                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
    </div>



</div>


@endsection

