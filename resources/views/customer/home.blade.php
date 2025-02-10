@extends('customer.layout.master')

@section('content')
    <!-- navbar -->
    <div class="homepage d-flex flex-column vh-100">
        @include('customer.layout.header')
        <!-- body -->

        <div class="my-auto overflow-auto vh-100">
            <!-- shop by category -->
            <div class="bg-light pb-3">
                <div class="d-flex align-items-center justify-content-between p-3">
                    <h5 class="fw-bold text-black mb-0">Shop By Category</h5>
                    <a
                        class="text-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#categories"
                        href="#"
                    >
                        View all
                        <i class="icofont-rounded-right"></i>
                    </a>
                </div>
                <div class="all-cate">
                    @foreach (getCategory() as $category)
                        @include('customer.partial.category-card', $category)
                    @endforeach
                </div>
            </div>
            <!-- Top Picks -->

                <div class="pt-3">
                <div class="d-flex align-items-center justify-content-between px-3 pb-3">
                <h5 class="fw-bold text-black mb-0">Today's Great deals</h5>
                <a class="text-primary" href="{{route('store',['is_great_deal'=>1])}}">
                View all
                <i class="icofont-rounded-right"></i>
                </a>
                </div>
                <div class="top-picks">
                <!-- 1st item -->

                @foreach (App\Models\Product::WhereHas('prices',function($query){
                    $query->where('location_id',session()->get('userLocationDetail')['store_id']);
                  })->where('is_bestseller',1)->where('status',1)->limit(10)->get();
           as $product)
                <div class="top-picks-item">
                @include('customer.partial.product-card', $product)
                </div>
                @endforeach
                </div>
                {{-- <div class="p-3">
                <a
                href="#"
                class="bg-success shadow text-white rounded-4 d-flex align-items-center px-3 py-2"
                >
                Explore
                <span
                class="bg-primary px-2 py-1 rounded-2 small text-uppercase fw-bold text-white m-2"
                >
                Mega Savings
                </span>
                Store
                <i class="bi bi-arrow-right text-warning fs-5 ms-auto"></i>
                </a>
                </div> --}}
                </div>


            <!-- coupons -->
            <div class="bg-warning mt-2">
                <h5 class="fw-bold text-black mb-0 p-3">Save more with coupons</h5>
                <div>
                    <div class="coupons">
                        @foreach (App\Models\Coupon::where('status',1)->latest()->limit(2)->get() as $coupon)
                        <div class="coupons-item">
                            <div class="link-dark pb-3 ps-3">
                                <div
                                    class="d-flex align-items-center gap-3 shadow-sm rounded-4 p-3 bg-white"
                                >
                                    <i class="icofont-sale-discount icofont-2x text-success"></i>
                                    <div>
                                        <h6 class="fw-bold osahan-mb-1">{{$coupon->description}}</h6>
                                        <p class="small text-muted text-uppercase mb-0">
                                            Use <strong>{{$coupon->name}}</strong> | on orders above {{$coupon->min_price}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </div>
                </div>
            </div>

            <!-- must have items -->
            <div class="py-3">
                <h5 class="fw-bold text-black mb-0 px-3 pb-3">Must Have Items</h5>
                <div class="top-picks">
                    @foreach ($products as $product)
                        <div class="top-picks-item">
                            @include('customer.partial.product-card', $product)
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- banner -->
            @php
                $coupon=App\Models\Coupon::latest()->first();
            @endphp
          @if ($coupon)
          <div class="p-3 bg-light">
            <div
                class="rounded-4 ps-4 pt-4 shadow-sm d-flex gap-1 align-items-center bg-warning bg-gradient justify-content-between"
            >
                <div class="pb-4">
                    <h1 class="fw-bolder text-black display-5 mb-1">{{ $coupon->percentage}}% OFF</h1>
                    <p class="text-dark">
                       {{ $coupon->description}}
                        <span class="text-success">
                            <i class="bi bi-basket"></i>
                            Free Delivery
                        </span>

                    </p>
                    <a
                        href="{{route('store')}}"
                        class="btn btn-light text-success fw-bold rounded-3 shadow-sm btn-sm border-0"
                    >
                        SHOP NOW
                    </a>
                </div>
                <img
                    src="img/banner1.png"
                    alt=""
                    class="img-fluid mt-auto osahan-offer-banner"
                />
            </div>
        </div>
          @endif
        </div>
        <!-- category button -->
        <div class="btn-category">
            <a
                href="#"
                class="btn btn-primary rounded-circle shadow-sm icon-lg"
                data-bs-toggle="modal"
                data-bs-target="#categories"
            >
                <i class="icofont-food-basket icofont-3x text-white"></i>
            </a>
        </div>

        <!-- footer -->
        @include('customer.layout.footer')
    </div>

    <!-- Categories Modal -->
    <div
        class="modal fade"
        id="categories"
        tabindex="-1"
        aria-labelledby="categoriesLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
            <div class="modal-content border-0 rounded-4 h-75">
                <div class="modal-header border-0 px-4">
                    <div class="modal-title" id="categoriesLabel">
                        <h5 class="fw-bold text-black mb-1">Shop by categories</h5>
                        <p class="mb-0">{{count(getCategory())}}</p>
                    </div>
                </div>
                <div class="modal-body border-top p-4">
                    <div class="row row-cols-3 gy-3">
                        @foreach (getCategory() as $category)
                        @include('customer.partial.category-card', $category)
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
