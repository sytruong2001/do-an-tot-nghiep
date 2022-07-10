<?php

use App\Http\Controllers\Api\priceRoomApi;
use App\Http\Controllers\Api\typeRoomApi;
use App\Http\Controllers\SuperAdmin\accountController;
use App\Http\Controllers\SuperAdmin\priceRoomController;
use App\Http\Controllers\SuperAdmin\revenueController;
use App\Http\Controllers\SuperAdmin\RoomController;
use App\Http\Controllers\SuperAdmin\typeRoomController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// dành cho quản lý
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/', [typeRoomController::class, 'index'])->name('index');

    Route::controller(typeRoomController::class)->group(function () {
        Route::get('/type-room', 'index')->name('typeroom.index');
    });

    Route::controller(RoomController::class)->group(function () {
        Route::get('/rooms', 'index')->name('room.indexRoom');
    });

    Route::controller(priceRoomController::class)->group(function () {
        Route::get('/price-room', 'index')->name('price.indexPriceRoom');
    });

    Route::controller(accountController::class)->group(function () {
        Route::get('/account', 'index')->name('account.indexAccount');
    });

    Route::controller(revenueController::class)->group(function () {
        Route::get('/revenue-room', 'index')->name('revenue.indexRevenue');
    });
});

// dành cho nhân viên lễ tân
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
});

// api
Route::prefix('api')->group(function () {
    Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
        // loại phòng
        Route::get('/get_type_room/{id}', [typeRoomApi::class, 'getinfo'])->name('typeroom.getInfoTypeRooom');
        Route::post('/create_type_room', [typeRoomApi::class, 'create'])->name('typeroom.createTypeRoom');
        Route::post('/update_type_room', [typeRoomApi::class, 'update'])->name('typeroom.updateTypeRoom');
        Route::post('/lock_type_room/{id}', [typeRoomApi::class, 'lockOrUnlock'])->name('typeroom.lockTypeRoom');

        // giá phòng theo từng loại phòng riêng
        Route::get('/get_price_room/{id}', [priceRoomApi::class, 'getinfo'])->name('priceroom.getInfoPriceRooom');
        Route::post('/create_price_room', [priceRoomApi::class, 'create'])->name('priceroom.createPriceRoom');
        Route::post('/update_price_room', [priceRoomApi::class, 'update'])->name('priceroom.updatePriceRoom');
        Route::post('/lock_price_room/{id}', [priceRoomApi::class, 'lockOrUnlock'])->name('priceroom.lockPriceRoom');
    });
});
require __DIR__ . '/auth.php';