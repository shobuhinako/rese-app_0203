<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TimestampController;
use App\Http\Controllers\BreakstampController;

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
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::get('/attendance', [AuthController::class, 'attendance'])->name('attendance');
Route::middleware('auth')->group(function(){
    Route::get('/', [AuthController::class, 'index'])->name('index');
});
Route::post('/auth/register', [AuthController::class, 'create']);
Route::post('/auth/login', [AuthController::class, 'logout']);

Route::group(['middleware' => 'auth'], function() {
    Route::post('/punchin', [TimestampController::class, 'punchIn'])->name('punchin');
    Route::post('/punchout', [TimestampController::class, 'punchOut'])->name('punchout');
    Route::post('/breakin', [BreakstampController::class, 'breakIn'])->name('breakin');
    Route::post('/breakout', [BreakstampController::class, 'breakOut'])->name('breakout');
});
Route::group(['middleware' => 'auth'], function() {
    Route::post('/adddate/{dt}', [AuthController::class, 'adddate'])->name('adddate');
    Route::post('/subday/{dt}', [AuthController::class, 'subday'])->name('subday');
});

