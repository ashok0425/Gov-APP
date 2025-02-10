<?php

use Illuminate\Support\Facades\Route;

// frontend route

Route::get('/home', [App\Http\Controllers\Customer\HomeController::class, 'index'])->name('home');
Route::redirect('/', '/login', 301);
Route::get('/login', [App\Http\Controllers\Customer\AuthController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\Customer\AuthController::class, 'handleLogin']);

Route::middleware('auth')->group(function () {
    Route::middleware('kyc')->group(function () {
        Route::get('/store/{category_slug?}', [App\Http\Controllers\Customer\HomeController::class, 'store'])->name('store');
        Route::get('/search', [App\Http\Controllers\Customer\HomeController::class, 'search'])->name('search');
        Route::get('/product-detail/{product}', [App\Http\Controllers\Customer\HomeController::class, 'productDetail'])->name('product-detail');

        Route::resource('/payments', App\Http\Controllers\Customer\PaymentController::class)->only(['index', 'store']);

        Route::get('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'update']);

        Route::get('/cart', [App\Http\Controllers\Customer\CheckoutController::class, 'cart'])->name('cart');
        Route::post('/cart', [App\Http\Controllers\Customer\CheckoutController::class, 'store'])->name('cart.store');
        Route::post('/cart/update', [App\Http\Controllers\Customer\CheckoutController::class, 'update'])->name('cart.update');
        Route::delete('/cart/remove', [App\Http\Controllers\Customer\CheckoutController::class, 'destroy'])->name('cart.remove');

        Route::post('/checkout', [App\Http\Controllers\Customer\CheckoutController::class, 'checkout'])->name('checkout');
        Route::get('/order-success', [App\Http\Controllers\Customer\CheckoutController::class, 'success'])->name('order.success');
        Route::post('/requisition/store', [App\Http\Controllers\Customer\CheckoutController::class, 'requisition'])->name('requisition.store');
        Route::get('/order', [App\Http\Controllers\Customer\OrderController::class, 'index'])->name('order');
        Route::get('/requisition', [App\Http\Controllers\Customer\OrderController::class, 'requisition'])->name('requisition');
        Route::get('/order-detail/{order}', [App\Http\Controllers\Customer\OrderController::class, 'show'])->name('order.detail');
        Route::get('/order/invoice/{order}', [App\Http\Controllers\Customer\OrderController::class, 'invoice'])->name('order.invoice');
        Route::post('/location/change', [App\Http\Controllers\Customer\HomeController::class, 'location'])->name('location.change');



        Route::resource('address', \App\Http\Controllers\Customer\AddressController::class)->only(['store', 'destroy']);
        Route::post('/addresses-select/{address}', [\App\Http\Controllers\Customer\AddressController::class, 'switchAddress'])->name('address.switch');
    });

    Route::get('/kyc', [App\Http\Controllers\Customer\KycController::class, 'kyc'])->name('kyc');
    Route::post('/kyc', [App\Http\Controllers\Customer\KycController::class, 'handleKyc']);
    Route::get('/coupon/apply', [App\Http\Controllers\Customer\CheckoutController::class, 'applyCoupon'])->name('coupon.apply');


    Route::post('/logout', [App\Http\Controllers\Customer\AuthController::class, 'logout'])->name('logout');
});
Route::get('/otp', [App\Http\Controllers\Customer\AuthController::class, 'otp'])->name('otp');
Route::post('otp/send', [App\Http\Controllers\Customer\AuthController::class, 'sendOtp'])->name('otp.send');
Route::post('/otp/verify', [App\Http\Controllers\Customer\AuthController::class, 'verify'])->name('otp.verify');
Route::view('privacy-policy','customer.privacy-policy');

