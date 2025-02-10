<div class="card bg-transparent border-0 overflow-hidden h-100 ps-3">
    <a
        href="#"
        class="link-dark"
        data-bs-toggle="offcanvas"
        data-bs-target="#productcanvas"
        aria-controls="productcanvasLabel"
        id="productcanvasBtn"
        data-product-id="{{ $product->id }}"
    >
        <div class="bg-white rounded-4 p-2 border position-relative product-box">
            <img
                lsrc="{{ getImage($product->thumbnail) }}"
                alt="{{ $product->name }}"
                class="img-fluid h-100 d-block mx-auto"
                style="object-fit: contain"
                width="200px"
                height="200px"
            />
        </div>
    </a>

    @if ($product->discount)
    <div class="bg-info position-absolute top-0 text-white osahan-badge text-center mx-3">
        <b>{{$product->discount}}%</b>
        <br />
        OFF
        </div>
    @endif


    <div class="card-body p-0">
        <small class="text-muted">{{ $product->category->name }}</small>
        <p class="card-title fw-bold ">{{ $product->name }}</p>
    </div>
    <div
        class="card-footer bg-transparent border-0 d-flex align-items-center justify-content-between p-0"
    >

        <div>
            <p class="small text-muted my-0 mb-1"> {{ $product->getPrice()['unit']??null }}</p>
            <p class="fw-bold m-0 "><sub>Rs</sub>{{ $product->getPrice()['price']??null }}</p>
        </div>
        <button
            data-product-id="{{ $product->id }}"
            class="btn btn-outline-success fw-bold rounded-3 shadow-sm btn-sm"
            data-bs-toggle="offcanvas"
            data-bs-target="#productcanvas"
            aria-controls="productcanvasLabel"
            id="productcanvasBtn"
        >
            ADD
        </button>
    </div>
</div>
