<?php

use App\Http\Controllers\Admin\checkinController;
use App\Http\Controllers\Admin\checkoutController;
use App\Http\Controllers\Api\AccountApi;
use App\Http\Controllers\Api\additionalFeeApi;
use App\Http\Controllers\Api\checkinApi;
use App\Http\Controllers\Api\checkoutApi;
use App\Http\Controllers\Api\priceRoomApi;
use App\Http\Controllers\Api\typeRoomApi;
use App\Http\Controllers\Api\RoomApi;
use App\Http\Controllers\Api\servicesApi;
use App\Http\Controllers\SuperAdmin\accountController;
use App\Http\Controllers\SuperAdmin\priceRoomController;
use App\Http\Controllers\SuperAdmin\revenueController;
use App\Http\Controllers\SuperAdmin\RoomController;
use App\Http\Controllers\SuperAdmin\typeRoomController;
use App\Models\RoomModel;
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
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// dành cho quản lý
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/', [typeRoomController::class, 'index'])->name('index');

    Route::get('/info/{id}', [accountController::class, 'getInfo'])->name('superadmin.infoSuperAdmin');

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
        Route::get('/doanh-so', 'index')->name('revenue.indexRevenue');
        Route::get('/search-rev', 'index')->name('revenue.searchRevenue');
    });
});

// dành cho nhân viên lễ tân
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [checkinController::class, 'index'])->name('index');

    Route::get('/info/{id}', [accountController::class, 'getInfo'])->name('admin.infoAdmin');

    Route::get('/detail-checkout/{id}', [checkoutController::class, 'getInfo'])->name('admin.getInfoCheckout');

    Route::controller(checkinController::class)->group(function () {
        Route::get('/checkin', 'index')->name('checkin.createCheckin');

        Route::get('/nhan-phong', 'getInfo')->name('checkin.getInfo');
    });

    Route::controller(checkoutController::class)->group(function () {
        Route::get('/checkout', 'index')->name('checkout.createCheckout');
        Route::get('/history', 'history')->name('checkout.history');
        Route::get('/print/{id}', 'print')->name('checkout.print');
    });


    Route::controller(RoomController::class)->group(function () {
        Route::get('/clean', 'getRoom')->name('room.clean');
    });
});

// api
Route::prefix('api')->group(function () {

    Route::get('/get_type_room/{id}', [typeRoomApi::class, 'getinfo'])->name('typeroom.getInfoTypeRoom');
    Route::get('/get_price_room/{id}', [priceRoomApi::class, 'getinfo'])->name('priceroom.getInfoPriceRoom');

    Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
        // loại phòng
        Route::get('/get_type_room/{id}', [typeRoomApi::class, 'getinfo'])->name('typeroom.getInfoTypeRoom');
        Route::post('/create_type_room', [typeRoomApi::class, 'create'])->name('typeroom.createTypeRoom');
        Route::post('/update_type_room', [typeRoomApi::class, 'update'])->name('typeroom.updateTypeRoom');
        Route::post('/lock_type_room/{id}', [typeRoomApi::class, 'lockOrUnlock'])->name('typeroom.lockTypeRoom');

        // giá phòng theo từng loại phòng riêng
        Route::get('/get_price_room/{id}', [priceRoomApi::class, 'getinfo'])->name('priceroom.getInfoPriceRoom');
        Route::post('/create_price_room', [priceRoomApi::class, 'create'])->name('priceroom.createPriceRoom');
        Route::post('/update_price_room', [priceRoomApi::class, 'update'])->name('priceroom.updatePriceRoom');
        Route::post('/lock_price_room/{id}', [priceRoomApi::class, 'lockOrUnlock'])->name('priceroom.lockPriceRoom');

        // phòng theo từng loại phòng riêng
        Route::get('/get_room/{id}', [RoomApi::class, 'getinfo'])->name('room.getInfoRoom');
        Route::post('/create_room', [RoomApi::class, 'create'])->name('room.createRoom');
        Route::post('/update_room', [RoomApi::class, 'update'])->name('room.updateRoom');
        Route::post('/lock_room/{id}', [RoomApi::class, 'lockOrUnlock'])->name('room.lockRoom');

        // nhân viên
        Route::get('/get_account/{id}', [AccountApi::class, 'getinfo'])->name('account.getInfoAccount');
        Route::post('/create_account', [AccountApi::class, 'create'])->name('account.createAccount');
        Route::post('/lock_account/{id}', [AccountApi::class, 'lockOrUnlock'])->name('account.lockAccount');
    });

    Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
        Route::get('/get_room/{id}', [RoomApi::class, 'getinfo'])->name('typeroom.getRoom');
        Route::post('/search-room', [RoomApi::class, 'searchRoom'])->name('rooms.searchForNameRoom');
        Route::post('/search-type-room/{id}', [RoomApi::class, 'searchTypeRoom'])->name('rooms.searchForTypeRoom');
        Route::post('/search-price-room/{id}', [RoomApi::class, 'searchPriceRoom'])->name('rooms.searchForPriceRoom');

        Route::post('/create_checkin', [checkinApi::class, 'create'])->name('checkin.createCheckin');
        Route::get('/get_checkin/{id}', [checkoutApi::class, 'getInfo'])->name('checkout.getCheckin');
        Route::post('/search-checkin', [checkinApi::class, 'searchRoom'])->name('checkin.searchCheckin');
        Route::get('/search-date-checkin', [checkinApi::class, 'searchDateCheckin'])->name('checkin.searchDateCheckin');

        Route::post('/create_checkout', [checkoutApi::class, 'create'])->name('checkout.createCheckout');

        Route::get('/get_service/{id}', [servicesApi::class, 'getInfo'])->name('services.getService');
        Route::post('/create_service', [servicesApi::class, 'create'])->name('services.createService');
        Route::post('/update_service', [servicesApi::class, 'update'])->name('services.updateService');
        Route::post('/delete_service/{id}', [servicesApi::class, 'destroy'])->name('services.deleteService');

        Route::get('/get_additional_fee/{id}', [additionalFeeApi::class, 'getInfo'])->name('additionalFee.getadditionalFee');
        Route::post('/create_additional_fee', [additionalFeeApi::class, 'create'])->name('additionalFee.createadditionalFee');
        Route::post('/update_additional_fee', [additionalFeeApi::class, 'update'])->name('additionalFee.updateadditionalFee');
        Route::post('/delete_additional_fee/{id}', [additionalFeeApi::class, 'destroy'])->name('additionalFee.deleteadditionalFee');

        Route::post('/clean/{id}', [RoomApi::class, 'clean'])->name('room.clean');
    });

    Route::post('/change-info', [AccountApi::class, 'changeInfo'])->name('admin.changeInfo');

    Route::post('/change-password', [AccountApi::class, 'changePassword'])->name('admin.changePassword');

    Route::get('/get-status-room', [RoomApi::class, 'getStatusRoom'])->name('room.getStatusRoom');
});
require __DIR__ . '/auth.php';