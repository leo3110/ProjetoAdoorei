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
Route::get('product', [ProductController::class,'queryAll']);
Route::get('product/{id}', [ProductController::class,'queryProduct']);
Route::post('product', [ProductController::class, 'createProduct']);
Route::put('product/{id}', [ProductController::class,'updateProduct']);
Route::delete('product/{id}',[ProductController::class,'deleteProduct']);