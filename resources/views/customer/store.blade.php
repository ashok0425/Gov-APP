@extends('customer.layout.master')

@section('content')
    <div class="homepage d-flex flex-column vh-100">
        @include('customer.layout.header')
        <div class="my-auto overflow-auto vh-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3">
                        <div class="bg-white rounded shadow-sm sticky-top overflow-hidden p-2">
                            <div
                                class="nav flex-column osahan-item-sidebar nav-pills"
                            >
                                @foreach ($categories as $category)
                                    <a
                                        class="nav-link {{$category->slug==$category_slug?'active':''}}"
                                        href="{{route('store',$category->slug)}}"
                                    >
                                        <div>
                                            <img
                                                src="{{ getImage($category->thumbnail) }}"
                                                alt="{{ $category->name }}"
                                                class="img-fluid bg-light rounded mx-auto"
                                            />
                                            <p class="pt-2 m-0 small ">{{ $category->name }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-9 mx-0 px-0">

                        <div class="bg-white rounded shadow-sm">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div
                                    class="tab-pane fade show active"
                                    id="v-pills-home"
                                    role="tabpanel"
                                    aria-labelledby="v-pills-home-tab"
                                    tabindex="0"
                                >
                               <div class="mt-3 d-flex flex-wrap">
                                @foreach (App\Models\Subcategory::where('category_id',$category_id)->get() as $subcategory)
                             <div class="mx-1 my-1">
                                <a href="{{route('store',[$category_slug,'subcategory'=>$subcategory->id])}}" class="rounded  border-0 p-1 px-2 {{request()->query('subcategory')&&request()->query('subcategory')==$subcategory->id? 'bg-success text-white':'border border-success text-success border-2'}}">{{$subcategory->name}}</a>
                             </div>
                              @endforeach
                               </div>

                                    <div class="p-2">
                                        <div class="row g-1 w-100" id="productsearchresult">
                                            @foreach ($products as $product)
                                                <div class="col-6 mb-3">
                                                    @include('customer.partial.product-card', $product)
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('customer.layout.footer')
    </div>
@endsection
