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
    return view('customer.view_booking');
});
// dành cho khách hàng đặt phòng online
Route::controller(checkinController::class)->group(function () {
    Route::get('/dat-phong/{id}/{start}/{end}', 'bookingRoom')->name('checkin.bookingRoom');
    Route::get('/camon/{id}', 'thank')->name('checkin.thank');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// dành cho quản lý
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/', [revenueController::class, 'index'])->name('index');
    // lấy thông tin cá nhân quản lý
    Route::get('/info/{id}', [accountController::class, 'getInfo'])->name('superadmin.infoSuperAdmin');
    // quản lý loại phòng
    Route::controller(typeRoomController::class)->group(function () {
        Route::get('/type-room', 'index')->name('typeroom.index');
    });
    // quản lý thông tin phòng
    Route::controller(RoomController::class)->group(function () {
        Route::get('/rooms', 'index')->name('room.indexRoom');
    });
    // quản lý giá phòng
    Route::controller(priceRoomController::class)->group(function () {
        Route::get('/price-room', 'index')->name('price.indexPriceRoom');
    });
    // quản lý tài khoản nhân viên
    Route::controller(accountController::class)->group(function () {
        Route::get('/account', 'index')->name('account.indexAccount');
    });
    // thống kê doanh số
    Route::controller(revenueController::class)->group(function () {
        Route::get('/doanh-so', 'index')->name('revenue.indexRevenue');
        Route::get('/search-rev', 'index')->name('revenue.searchRevenue');
    });
});

// dành cho nhân viên lễ tân
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [checkinController::class, 'index'])->name('index');
    // quản lý thông tin cá nhân lễ tân
    Route::get('/info/{id}', [accountController::class, 'getInfo'])->name('admin.infoAdmin');

    // thông tin chi tiết của phiếu trả phòng
    Route::get('/detail-checkout/{id}', [checkoutController::class, 'getInfo'])->name('admin.getInfoCheckout');

    // quản lý đặt, nhận phòng cho khách hàng tại quầy lễ tân
    Route::controller(checkinController::class)->group(function () {
        Route::get('/checkin', 'index')->name('checkin.createCheckinRoom');
        Route::get('/checkin-today', 'searchCheckinToday')->name('checkin.searchCheckinToday');

        Route::get('/nhan-phong', 'getInfo')->name('checkin.getInfo');
    });

    // quản lý phiếu trả phòng và in hóa đơn
    Route::controller(checkoutController::class)->group(function () {
        Route::get('/checkout', 'index')->name('checkout.createCheckout');
        Route::get('/checkout-today', 'searchCheckoutToday')->name('checkout.searchCheckoutToday');
        Route::get('/history', 'history')->name('checkout.history');
        Route::get('/print/{id}', 'print')->name('checkout.print');
    });

    // quản lý phòng cần dọn dẹp
    Route::controller(RoomController::class)->group(function () {
        Route::get('/clean', 'getRoom')->name('room.clean');
    });
});

// api
Route::prefix('api')->group(function () {
    // lấy thông tin loại phòng theo mã id
    Route::get('/get_type_room/{id}', [typeRoomApi::class, 'getinfo'])->name('typeroom.getInfoTypeRoom');
    // lấy thông tin giá phòng theo mã id
    Route::get('/get_price_room/{id}', [priceRoomApi::class, 'getinfo'])->name('priceroom.getInfoPriceRoom');
    // lấy thông tin đặt phòng
    Route::get('/search-booking', [RoomApi::class, 'searchBooking'])->name('rooms.searchBooking');
    Route::get('/get-time-end', [RoomApi::class, 'getTimeEnd'])->name('rooms.getTimeEnd');

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
        // lấy thông tin phòng theo mã id
        Route::get('/get_room/{id}', [RoomApi::class, 'getinfo'])->name('typeroom.getRoom');
        Route::post('/search-room', [RoomApi::class, 'searchRoom'])->name('rooms.searchForNameRoom');
        Route::post('/search-type-room/{id}', [RoomApi::class, 'searchTypeRoom'])->name('rooms.searchForTypeRoom');
        Route::post('/search-price-room/{id}', [RoomApi::class, 'searchPriceRoom'])->name('rooms.searchForPriceRoom');

        // tạo mới phiếu đặt phòng
        Route::post('/create_checkin', [checkinApi::class, 'create'])->name('checkin.createCheckin');
        // nhận phòng
        Route::post('/update_checkin/{id}', [checkinApi::class, 'update'])->name('checkin.updateCheckin');
        // hủy đặt phòng
        Route::post('/cancel_checkin/{id}', [checkinApi::class, 'cancel'])->name('checkin.cancelCheckin');
        // lấy thông tin chi tiết phiếu đặt phòng theo mã id
        Route::get('/get_checkin/{id}', [checkoutApi::class, 'getInfo'])->name('checkout.getCheckin');

        // Route::get('/get_booking/{id}', [checkintApi::class, 'getBooking'])->name('checkout.getBookingRoom');
        Route::post('/search-identify', [checkinApi::class, 'searchIdentify'])->name('checkin.searchIdentify');
        // tìm kiếm đặt phòng
        Route::post('/search-checkin', [checkinApi::class, 'searchRoom'])->name('checkin.searchCheckin');
        Route::get('/search-date-checkin', [checkinApi::class, 'searchDateCheckin'])->name('checkin.searchDateCheckin');

        // tạo mới phiếu trả phòng
        Route::post('/create_checkout', [checkoutApi::class, 'create'])->name('checkout.createCheckout');

        // lấy thông tin dịch vụ đã sử dụng
        Route::get('/get_service/{id}', [servicesApi::class, 'getInfo'])->name('services.getService');
        // tạo mới dịch vụ
        Route::post('/create_service', [servicesApi::class, 'create'])->name('services.createService');
        // cập nhật thông tin dịch vụ
        Route::post('/update_service', [servicesApi::class, 'update'])->name('services.updateService');
        // xóa thông tin dịch vụ
        Route::post('/delete_service/{id}', [servicesApi::class, 'destroy'])->name('services.deleteService');

        // lấy thông tin phí tổn thất theo mã id
        Route::get('/get_additional_fee/{id}', [additionalFeeApi::class, 'getInfo'])->name('additionalFee.getadditionalFee');
        // tạo mới phiếu tổn thất
        Route::post('/create_additional_fee', [additionalFeeApi::class, 'create'])->name('additionalFee.createadditionalFee');
        // cập nhật thông tin tổn thất
        Route::post('/update_additional_fee', [additionalFeeApi::class, 'update'])->name('additionalFee.updateadditionalFee');
        // xóa thông tin tổn thất
        Route::post('/delete_additional_fee/{id}', [additionalFeeApi::class, 'destroy'])->name('additionalFee.deleteadditionalFee');

        // thông tin phòng cần dọn dẹp theo mã id
        Route::post('/clean/{id}', [RoomApi::class, 'clean'])->name('room.clean');
    });

    // thay đổi thông tin cá nhân của quản lý hoặc lễ tân
    Route::post('/change-info', [AccountApi::class, 'changeInfo'])->name('admin.changeInfo');
    // đổi mật khẩu
    Route::post('/change-password', [AccountApi::class, 'changePassword'])->name('admin.changePassword');
    // lấy trạng thái phòng
    Route::get('/get-status-room', [RoomApi::class, 'getStatusRoom'])->name('room.getStatusRoom');
    // tạo phiếu đặt phòng
    Route::post('/create_booking', [checkinApi::class, 'booking'])->name('checkin.createBooking');
});
require __DIR__ . '/auth.php';