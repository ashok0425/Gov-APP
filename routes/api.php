<?php

use App\Http\Controllers\API\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('verifyToken')->group(function(){
    Route::get('/wards', [HomeController::class,'wards']);
    Route::get('/category', [HomeController::class,'category']);
    Route::get('/blogs', [HomeController::class,'blogs']);
    Route::get('/blog/{id}', [HomeController::class,'blogDetail']);
    Route::get('/banners', [HomeController::class,'banner']);
    Route::get('/blogs-by-category/{id}', [HomeController::class,'blogByCategory']);
    Route::get('/blogs-by-ward/{id}', [HomeController::class,'blogByWard']);

});
