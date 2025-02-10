<div class="bg-white px-3">
    <div class="border-bottom py-3">
        @foreach ($order->orderItem as $item)
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="icofont-check-alt fs-5 text-success"></i>
                <p class="m-0">{{ $item->qty }} x {{ $item->product->name }} ({{ $item->weight }})</p>
                <p class="ms-auto m-0">Rs {{ $item->unit_price * $item->qty }}</p>
            </div>
        @endforeach

    </div>
    <div class="py-3">
        <div class="d-flex align-items-center justify-content-between text-muted small mb-2">
            <p class="m-0">Item Bill</p>
            <p class="m-0">Rs {{ $order->subtotal }}</p>
        </div>
        <div class="d-flex align-items-center justify-content-between text-muted small mb-2">
            <p class="m-0">Handling Fee</p>
            <p class="m-0">Rs {{ $order->handling_charge }}</p>
        </div>
        <div class="d-flex align-items-center justify-content-between text-muted small mb-2">
            <p class="m-0">Delivery fee</p>
            <p class="m-0">Rs {{ $order->delivery_charge }}</p>
        </div>
        <div class="d-flex align-items-center justify-content-between text-muted small mb-0">
            <h6 class="m-0 text-black">Grand Total</h6>
            <h6 class="m-0 text-primary">Rs {{ $order->final_total }}</h6>
        </div>
    </div>
</div>
