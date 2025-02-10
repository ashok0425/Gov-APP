<?php

use Illuminate\Support\Facades\Route;

// Admin Auth
Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'index'])->name('admin.login');
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'store']);
});

//admin guard middleware
Route::middleware('auth:admin')->name('admin.')->group(function () {

    // Admin profile
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\Admin\AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [\App\Http\Controllers\Admin\AuthController::class, 'update'])->name('profile.update');
    Route::post('/password/update', [\App\Http\Controllers\Admin\AuthController::class, 'changePassword'])->name('password');
    Route::get('/logout/admin', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('subcategories', \App\Http\Controllers\Admin\SubcategoryController::class);

    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::get('product/sales/{product}', [\App\Http\Controllers\Admin\ProductController::class,'sales'])->name('product.sales');

    Route::get('pricing', [\App\Http\Controllers\Admin\ProductController::class,'pricing'])->name('product.pricing');
    Route::post('pricing/store/{id}', [\App\Http\Controllers\Admin\ProductController::class,'storePrice'])->name('product.pricing.store');
    Route::get('pricing/list', [\App\Http\Controllers\Admin\ProductController::class,'pricingList'])->name('product.pricing.list');


    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class)->middleware('can:do anything');
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    Route::get('/status/{id}/{status}', [\App\Http\Controllers\Admin\OrderController::class, 'changeOrderStatus'])->name('order.status');
    Route::post('/order/cp/update', [\App\Http\Controllers\Admin\OrderController::class, 'updateCp'])->name('order.cp.update');

    Route::get('/show/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('order.show');
    Route::get('/label/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'label'])->name('order.label');


    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::get('user/status', [\App\Http\Controllers\Admin\UserController::class,'changeStatus'])->name('user.status');
    Route::get('user/discount/{id}', [\App\Http\Controllers\Admin\UserController::class,'handleDiscount'])->name('user.discount');
    Route::post('user/discount/{id}', [\App\Http\Controllers\Admin\UserController::class,'updateDiscount']);

    Route::get('user/portal', [\App\Http\Controllers\Admin\UserController::class,'userlogin'])->name('user.portal');
    Route::get('user/password/{user_id}', [\App\Http\Controllers\Admin\UserController::class, 'password'])->name('user.password');
    Route::post('user/password/{user_id}', [\App\Http\Controllers\Admin\UserController::class, 'updatePassword']);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class)->middleware('can:do anything');
    Route::resource('cms', \App\Http\Controllers\Admin\CmsController::class)->middleware('can:do anything');
    Route::resource('kycs', \App\Http\Controllers\Admin\KycController::class);
    Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class)->middleware('can:do anything');
    Route::get('payment/{id}/{status}', [\App\Http\Controllers\Admin\PaymentController::class,'status'])->name('payment.status')->middleware('can:do anything');

    Route::get('kyc/status',[ \App\Http\Controllers\Admin\KycController::class,'status'])->name('kyc.status');
    Route::resource('times', \App\Http\Controllers\Admin\DeliveryTimeController::class)->middleware('can:do anything');
    Route::resource('locations', \App\Http\Controllers\Admin\LocationController::class)->middleware('can:do anything');
    Route::resource('units', \App\Http\Controllers\Admin\UnitController::class);


    Route::group(['prefix' => 'manage-access','middleware'=>'can:do anything'], function () {
        Route::get('/', [App\Http\Controllers\Admin\ManageAccessController::class, 'index'])->name('access.index');
        Route::get('/create', [App\Http\Controllers\Admin\ManageAccessController::class, 'create'])->name('access.create');
        Route::post('/store', [App\Http\Controllers\Admin\ManageAccessController::class, 'store'])->name('access.store');
        Route::get('{id}/edit', [App\Http\Controllers\Admin\ManageAccessController::class, 'edit'])->name('access.edit');
        Route::post('{id}/update', [App\Http\Controllers\Admin\ManageAccessController::class, 'update'])->name('access.update');
        Route::post('{id}/delete', [App\Http\Controllers\Admin\ManageAccessController::class, 'destroy'])->name('access.destroy');
    });

    Route::get('get/subcategories',[\App\Http\Controllers\Admin\ProductController::class,'getsubcategory'])->name('get_sub_category');
});
