<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\SummernoteController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
// Admin sign-in. The public face of the site lives at "/" — see the group below.
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'store']);
//admin guard middleware
Route::middleware('auth')->group(function () {

    // Admin profile
    Route::get('/dashboard', [\App\Http\Controllers\AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [\App\Http\Controllers\AuthController::class, 'update'])->name('profile.update');
    Route::post('/password/update', [\App\Http\Controllers\AuthController::class, 'changePassword'])->name('password');
    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::resource('categories', \App\Http\Controllers\CategoryController::class)->middleware('can:do anything');

    Route::resource('posts', \App\Http\Controllers\BlogController::class)->names('blogs');
    Route::resource('banners', \App\Http\Controllers\BannerController::class);
    Route::resource('attachments', \App\Http\Controllers\AttachmentController::class);
    Route::resource('wards', \App\Http\Controllers\BusinessController::class)->names('business');
    Route::get('business-reorder', [\App\Http\Controllers\BusinessController::class,'reorder'])->name('business.reorder')->middleware('can:do anything');
    Route::post('business-reorder', [\App\Http\Controllers\BusinessController::class,'reorderStore'])->name('business.reorder.store')->middleware('can:do anything');

Route::get('/business/{id}/categories', [BusinessController::class, 'editCategories'])->name('business.categories.edit');
Route::post('/business/{id}/categories', [BusinessController::class, 'updateCategories'])->name('business.categories.update');

    Route::resource('pages', \App\Http\Controllers\PageController::class)->middleware('can:do anything');
    Route::resource('cms', \App\Http\Controllers\CmsController::class)->middleware('can:do anything');
    Route::get('users/index', [\App\Http\Controllers\ManageAccessController::class,'users'])->middleware('can:do anything')->name('users');


    Route::group(['prefix' => 'manage-access'], function () {
        Route::get('/', [App\Http\Controllers\ManageAccessController::class, 'index'])->name('access.index');
        Route::get('/create', [App\Http\Controllers\ManageAccessController::class, 'create'])->name('access.create');
        Route::post('/store', [App\Http\Controllers\ManageAccessController::class, 'store'])->name('access.store');
        Route::get('{id}/edit', [App\Http\Controllers\ManageAccessController::class, 'edit'])->name('access.edit');
        Route::post('{id}/update', [App\Http\Controllers\ManageAccessController::class, 'update'])->name('access.update');
        Route::delete('{id}/delete', [App\Http\Controllers\ManageAccessController::class, 'destroy'])->name('access.destroy');
    });

});

Route::get('storages', function () {
    Artisan::call('migrate');
    return 'Storage link created';
});

Route::post('/summernote/upload', [SummernoteController::class, 'upload'])->name('summernote.upload');

// Public mobile web app — the browser version of the Nagarpalika Flutter app.
// Registered last so it never shadows an admin route. "/my-ward" rather than
// "/wards", which the admin business resource already owns.
Route::name('m.')->group(function () {
    Route::get('/', [\App\Http\Controllers\MobileAppController::class, 'home'])->name('home');
    Route::get('/notifications', [\App\Http\Controllers\MobileAppController::class, 'notifications'])->name('notifications');
    Route::get('/my-ward', [\App\Http\Controllers\MobileAppController::class, 'wards'])->name('wards');
    Route::get('/palika', [\App\Http\Controllers\MobileAppController::class, 'palika'])->name('palika');
    Route::get('/hello', [\App\Http\Controllers\MobileAppController::class, 'hello'])->name('hello');
    Route::get('/settings', [\App\Http\Controllers\MobileAppController::class, 'settings'])->name('settings');
    Route::get('/ward/{id}', [\App\Http\Controllers\MobileAppController::class, 'ward'])->name('ward');
    Route::get('/ward/{id}/categories', [\App\Http\Controllers\MobileAppController::class, 'categories'])->name('categories');
    Route::get('/ward/{id}/category/{category}', [\App\Http\Controllers\MobileAppController::class, 'categoryNews'])->name('category.news');
    Route::get('/blog/{id}', [\App\Http\Controllers\MobileAppController::class, 'blog'])->name('blog');
    Route::get('/page/{slug}', [\App\Http\Controllers\MobileAppController::class, 'page'])->name('page');
});
