<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('auth.login');
});
// Route::get('/otp', function () {
//     return view('otp');
// });

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/product', [App\Http\Controllers\ProductController::class, 'index'])->name('product');
Route::get('/product/add', [App\Http\Controllers\ProductController::class, 'add']);
Route::get('/product/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit']);
Route::post('/product/store', [App\Http\Controllers\ProductController::class, 'store']);
Route::post('/product/update', [App\Http\Controllers\ProductController::class, 'update']);
Route::get('/product/get-datatables', [App\Http\Controllers\ProductController::class, 'getDatatables']);
Route::delete('/product/delete/{id}', [App\Http\Controllers\ProductController::class, 'destroy']);
