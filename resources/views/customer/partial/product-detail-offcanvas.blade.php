@php
    $defaultValue = $product->getPrice();
    $defaultPrice = $defaultValue['price'];
    $defaultunit = $defaultValue['unit'];

@endphp
<form action="{{ route('cart.store') }}" method="post" id="addTocart">
    @csrf
    <input name="product_id" type="hidden" value="{{ $product->id }}" />
    <div class="card bg-transparent border-0 overflow-hidden h-100" style="padding-bottom: 80px">
        <div class="card-body">
            <div class="mb-3">
                <div class="position-relative product-box rounded p-2" style="height: 200px !important">
                    <img src="{{ getImage($product->thumbnail) }}" alt="{{ $product->name }}"
                        class="img-fluid h-100 d-block mx-auto" />


                    @if ($product->discount)
                        <div class="bg-info position-absolute top-0 text-white osahan-badge text-center mx-3">
                            <b>{{ $product->discount }}%</b>
                            <br />
                            OFF
                        </div>
                    @endif

                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted">{{ $product->brand }}</div>
                <h4 class="card-title fw-bold">{{ $product->name }}</h4>
            </div>

            {{-- //production variation --}}
            <div class="mb-3">
                <h6 class="card-title fw-bold">Select Product Size</h6>
                <div class="row row-cols-4 g-2 custom-checkbox mb-3">
                    @foreach ($product->prices()->where('location_id', session()->get('userLocationDetail')['store_id'])->get() as $key => $item)
                        <div class="col">
                            <input type="radio" class="btn-check weight-radio" name="weight"
                                id="dayradio{{ $key }}" autocomplete="off" {{ $key == 1 ? 'checked' : '' }}
                                value="{{ $item->unit }}" data-price="{{ $item->price }}" />
                            <label class="btn btn-outline-danger px-2 btn-sm w-100" for="dayradio{{ $key }}">
                                {{ $item->unit }}
                                <span class="d-block text-muted">
                                    <sub>Rs</sub>{{ $product->getPrice($item->unit)['price'], 2 }}
                                </span>
                            </label>
                        </div>
                    @endforeach

                </div>

                <h6 class="card-title fw-bold">Select Product Quantity</h6>
                <div style="width: 130px" class="mt-2">
                    <div
                        class="osahan-count d-flex align-items-center justify-content-between border border-dark-subtle rounded-pill h6 m-0 p-1">
                        <span class="text-muted minus d-flex fs-2" data-mp="{{ $defaultPrice }}"
                            data-sp="{{ $defaultPrice }}">
                            <i class="icofont-minus-circle"></i>
                        </span>
                        <input type="text" class="lh-sm small text-black text-center box border-0" value="1"
                            readonly min="1" name="qty" />
                        <span class="text-muted plus d-flex fs-2" {{-- data-mp="120" --}} data-sp="{{ $defaultPrice }}">
                            <i class="icofont-plus-circle"></i>
                        </span>
                    </div>
                </div>
            </div>

            {{--
                <hr />
                <div>{{ $product->long_description }}</div>
            --}}
        </div>

        <div class="position-fixed bottom-0 w-100 border-top bg-white">
            <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-3">
                        <strong>
                            <span class="text-primary fs-1">
                                <span>Rs</span>
                                <span id="sp">{{ $defaultPrice }}</span>
                            </span>
                        </strong>
                        {{--
                            <span class="text-danger">
                            <strong>
                            <del><span id="mp">120</span></del>
                            </strong>
                            </span>
                        --}}
                    </div>
                </div>
                <div class="text-right">
                    <button data-bs-toggle="offcanvas" data-bs-target="#productcanvas"
                        aria-controls="productcanvasLabel"
                        class="btn btn-outline-success fw-bold rounded-3 shadow-sm btn-sm">
                        ADD TO CART
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
