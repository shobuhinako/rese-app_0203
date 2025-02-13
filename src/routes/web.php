<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StripeController;

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

Route::get('/auth/register', [AuthController::class, 'showRegisterForm'])->name('show.register');
Route::post('/register', [AuthController::class, 'create'])->name('register');
Route::get('/thanks', [AuthController::class, 'showThanks'])->name('thanks');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('show.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function(){
    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::get('/search', [ShopController::class, 'search'])->name('search');
    Route::get('/shop_detail/{id}', [ShopController::class, 'showDetail'])->name('shop.detail');
    Route::get('/mypage', [AuthController::class, 'mypage'])->name('mypage');
    Route::get('/admin/mypage', [AuthController::class, 'adminPage'])->name('admin.mypage');
    Route::get('/manager/mypage', [AuthController::class, 'managerPage'])->name('manager.mypage');
    Route::post('/shops/{shop:id}/favorite', [ShopController::class, 'favorite'])->name('favorite');
    Route::post('/done', [ReservationController::class, 'reservation'])->name('make.reservation');
    Route::delete('/mypage/reservation/{id}', [ReservationController::class, 'remove'])->name('reservation.remove');
    Route::delete('/mypage/favorite/{shop_id}', [ShopController::class, 'destroy'])->name('favorite.destroy');
    Route::get('/reservation/{id}/edit/{shop_name}', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('/reservation/update/{id}', [ReservationController::class, 'update'])->name('reservation.update');
    Route::get('/review/{id}', [ReviewController::class, 'showReview'])->name('show.review');
    Route::post('/review/store', [ReviewController::class, 'store'])->name('store.review');
    Route::post('/review/delete/{shop_id}', [ReviewController::class, 'remove'])->name('remove.review');
    Route::get('/display/reviews/{shop_id}', [ReviewController::class, 'showShopReviews'])->name('display.reviews');
    Route::post('/display/reviews/delete/{shop_id}', [ReviewController::class, 'deleteReview'])->name('delete.review');
    Route::post('/create/admin', [AuthController::class, 'createAdmin'])->name('admin.create');
    Route::get('/create/admin', [AuthController::class, 'showAdmin'])->name('show.admin');
    Route::get('/create/manager', [AuthController::class, 'showManager'])->name('show.manager');
    Route::post('/create/manager', [AuthController::class, 'createManager'])->name('manager.create');
    Route::get('/send-notification', [AuthController::class, 'showNotification'])->name('send.notification.show');
    Route::post('/send-notification', [AuthController::class, 'sendNotification'])->name('send-notification');
    Route::get('/reservation/status/{id}', [ReservationController::class, 'showStatus'])->name('reservation.status');
    Route::post('/charge', [StripeController::class, 'charge'])->name('stripe.charge');
    Route::get('/charge', [StripeController::class, 'showCharge'])->name('show.charge');
    Route::get('/sort', [ShopController::class, 'sort'])->name('sort');
    Route::get('/admin/import', [ShopController::class, 'showImportForm'])->name('show.import.form');
    Route::post('/upload/image', [ShopController::class, 'uploadImage'])->name('upload.image');
    Route::post('/admin/import', [ShopController::class, 'importCsv'])->name('shop.import.csv');
    Route::get('/update/shop', [ShopController::class, 'showUpdateStorePage'])->name('shop.update.show');
    Route::put('/update/shop', [ShopController::class, 'updateStore'])->name('shop.update');

});
Route::get('/email/verify/{id}/{hash}',[AuthController::class, 'verify'])->name('verification.verify');