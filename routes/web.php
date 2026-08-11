<?php

use App\Http\Controllers\PalikaController;
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

    Route::get('subcategories', [\App\Http\Controllers\CategoryController::class, 'subcategories'])->name('subcategories.index')->middleware('can:do anything');
    Route::resource('categories', \App\Http\Controllers\CategoryController::class)->middleware('can:do anything');

    Route::resource('posts', \App\Http\Controllers\BlogController::class)->names('blogs');
    Route::resource('banners', \App\Http\Controllers\BannerController::class);
    Route::resource('attachments', \App\Http\Controllers\AttachmentController::class);
    Route::get('palika-reorder', [PalikaController::class,'reorder'])->name('palika.reorder');
    Route::post('palika-reorder', [PalikaController::class,'reorderStore'])->name('palika.reorder.store');
    Route::get('/palikas/{id}/categories', [PalikaController::class, 'editCategories'])->name('palika.categories.edit');
    Route::post('/palikas/{id}/categories', [PalikaController::class, 'updateCategories'])->name('palika.categories.update');
    Route::resource('palikas', PalikaController::class)->names('palika');

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
// Registered last so it never shadows an admin route. "/palika" rather than
// "/palikas", which the admin palika resource already owns.
// In production these answer only on config('app.frontend_host'); see
// App\Http\Middleware\EnsureFrontendHost.
Route::name('m.')->middleware('frontend.host')->group(function () {
    Route::get('/', [\App\Http\Controllers\MobileAppController::class, 'home'])->name('home');
    Route::get('/notifications', [\App\Http\Controllers\MobileAppController::class, 'notifications'])->name('notifications');
    Route::get('/search', [\App\Http\Controllers\MobileAppController::class, 'search'])->name('search');
    Route::get('/palika', [\App\Http\Controllers\MobileAppController::class, 'palikas'])->name('palikas');
    Route::get('/hello', [\App\Http\Controllers\MobileAppController::class, 'hello'])->name('hello');
    Route::get('/settings', [\App\Http\Controllers\MobileAppController::class, 'settings'])->name('settings');
    Route::get('/palika/{id}', [\App\Http\Controllers\MobileAppController::class, 'palika'])->name('palika');
    Route::get('/palika/{id}/categories', [\App\Http\Controllers\MobileAppController::class, 'categories'])->name('categories');
    Route::get('/palika/{id}/category/{category}', [\App\Http\Controllers\MobileAppController::class, 'categoryNews'])->name('category.news');
    Route::get('/palika/{id}/category/{category}/{subcategory}', [\App\Http\Controllers\MobileAppController::class, 'subcategoryNews'])->name('subcategory.news');
    Route::get('/blog/{id}', [\App\Http\Controllers\MobileAppController::class, 'blog'])->name('blog');
    Route::get('/page/{slug}', [\App\Http\Controllers\MobileAppController::class, 'page'])->name('page');

    // Links shared while the app still spoke of wards keep working.
    Route::redirect('/my-ward', '/palika');
    Route::get('/ward/{id}', fn ($id) => redirect()->route('m.palika', $id));
    Route::get('/ward/{id}/categories', fn ($id) => redirect()->route('m.categories', $id));
    Route::get('/ward/{id}/category/{category}', fn ($id, $category) => redirect()->route('m.category.news', [$id, $category]));
});
