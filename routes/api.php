<?php

use App\Http\Controllers\ProductController;
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
Route::get('product/query', [ProductController::class,'queryAll']);
Route::get('product/query/{id1?}/{id2?}', [ProductController::class,'queryProduct']);
Route::get('product/queryImg/{bool}', [ProductController::class,'queryProductImg']);
Route::put('product/create', [ProductController::class, 'createProduct']);
Route::put('product/update/{id}', [ProductController::class,'updateProduct']);
Route::delete('product/delete/{id}',[ProductController::class,'deleteProduct']);