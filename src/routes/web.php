<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShopController;
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

Route::get('/auth/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth')->group(function(){
    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::get('/', [SearchController::class, 'search'])->name('search');
    Route::get('/shop_detail/{id}', [ShopController::class, 'showDetail'])->name('shop_detail');
    Route::get('/mypage', [AuthController::class, 'mypage'])->name('mypage');
    Route::post('/shops/{shop:id}/favorite', [ShopController::class, 'favorite'])->name('favorite');
    Route::post('/done', [ShopController::class, 'reservation']);
    Route::delete('/mypage/reservation/{id}', [ShopController::class, 'remove'])->name('reservation.remove');
    Route::delete('/mypage/favorite/{shop_id}', [ShopController::class, 'destroy'])->name('favorite.destroy');
});
Route::post('/register', [AuthController::class, 'create'])->name('register.post');
Route::post('/auth/login', [AuthController::class, 'logout']);
Route::get('/thanks', function () {
    return view('thanks');
});