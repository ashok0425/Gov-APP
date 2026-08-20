<?php

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

    Route::post('organizations/reorder', [\App\Http\Controllers\OrganizationController::class, 'reorder'])->name('organizations.reorder')->middleware('can:do anything');
    Route::resource('organizations', \App\Http\Controllers\OrganizationController::class)->except(['show'])->middleware('can:do anything');
    Route::post('categories/reorder', [\App\Http\Controllers\CategoryController::class, 'reorder'])->name('categories.reorder')->middleware('can:do anything');

    Route::get('subcategories', [\App\Http\Controllers\CategoryController::class, 'subcategories'])->name('subcategories.index')->middleware('can:do anything');
    Route::get('child-categories', [\App\Http\Controllers\CategoryController::class, 'childCategories'])->name('childcategories.index')->middleware('can:do anything');
    Route::get('grandchild-categories', [\App\Http\Controllers\CategoryController::class, 'grandchildCategories'])->name('grandchildcategories.index')->middleware('can:do anything');
    Route::resource('categories', \App\Http\Controllers\CategoryController::class)->middleware('can:do anything');

    Route::resource('posts', \App\Http\Controllers\BlogController::class)->names('blogs');
    Route::resource('banners', \App\Http\Controllers\BannerController::class);
    Route::resource('attachments', \App\Http\Controllers\AttachmentController::class);

    Route::resource('notices', \App\Http\Controllers\NoticeController::class)->middleware('can:do anything');
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
    Route::get('/blog/{id}', [\App\Http\Controllers\MobileAppController::class, 'blog'])->name('blog');
    Route::get('/notice/{id}', [\App\Http\Controllers\MobileAppController::class, 'notice'])->name('notice');
    Route::get('/page/{slug}', [\App\Http\Controllers\MobileAppController::class, 'page'])->name('page');

    // The menu belongs to the app, not to a palika. One route serves every
    // level — a category id says on its own how deep in the tree it sits.
    // "/menu" rather than "/categories": the admin categories resource already
    // owns that URI, and a same-method same-URI route registered later here
    // would replace it instead of sitting beside it.
    Route::get('/menu', [\App\Http\Controllers\MobileAppController::class, 'categories'])->name('categories');
    Route::get('/org/{id}', [\App\Http\Controllers\MobileAppController::class, 'organization'])->name('organization');
    Route::get('/category/{category}', [\App\Http\Controllers\MobileAppController::class, 'category'])->name('category');

    // Links shared while the app still spoke of wards, or scoped the menu to a
    // palika, keep working.
    Route::redirect('/my-ward', '/palika');
    Route::get('/ward/{id}', fn ($id) => redirect()->route('m.palika', $id));
    Route::get('/ward/{id}/categories', fn () => redirect()->route('m.categories'));
    Route::get('/ward/{id}/category/{category}', fn ($id, $category) => redirect()->route('m.category', $category));
    Route::get('/palika/{id}/categories', fn () => redirect()->route('m.categories'));
    Route::get('/palika/{id}/category/{category}', fn ($id, $category) => redirect()->route('m.category', $category));
    Route::get('/palika/{id}/category/{category}/{subcategory}', fn ($id, $category, $subcategory) => redirect()->route('m.category', $subcategory));
});
