<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ThuocController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\Admin\ThuocController as AdminThuocController;
use App\Http\Controllers\Admin\LoaiThuocController;
use App\Http\Controllers\Admin\DonHangController;


Route::get('/', [ThuocController::class, 'getTrangChu']);
//Page 
Route::get('/trangchu', [ThuocController::class, 'getTrangChu']);

Route::get('/lienhe', function () {
    return view('LienHe.index');
});

Route::get('/gioithieu', function () {
    return view('GioiThieu.index');
});

Route::get('/giohang', [GioHangController::class, 'ShowCartDetail'])->name('cart.index');

Route::get('/thuoc/{id}', [ThuocController::class, 'show'])->name('chi-tiet-san-pham');

Route::post('/cart/add/{id}', [GioHangController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/add/{id}', [GioHangController::class, 'addToCart'])->name('gio-hang-add');

Route::post('/cart/update/{id}', [GioHangController::class, 'updateCart'])->name('cart.update');

Route::post('/cart/remove/{id}', [GioHangController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/loaithuoc/{id}', [ThuocController::class, 'getByLoai']);

Route::get('/dangki', [AuthController::class, 'showRegister'])->name('register.show');

Route::post('/dangki', [AuthController::class, 'register'])->name('register.submit');

Route::get('/dangnhap', [AuthController::class, 'showLogin']);

Route::post('/dangnhap', [AuthController::class, 'login'])->name('login.submit');

Route::post('/dangxuat', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [AuthController::class, 'showAdminLogin'])->name('dashboard.index');

Route::post('/pay', [GioHangController::class, 'pay'])->name('cart.pay');

Route::get('/ajax/product/{maThuoc}', [ThuocController::class, 'ajaxGetProduct']);




//-----------------------------------------------------------------------------------------------------
//css
Route::get('/css/{file}', function ($file) {
    $path = resource_path('css/' . $file . '/index.css');

    if (!file_exists($path)) {
        abort(404);
    }

    $content = file_get_contents($path);
    return Response::make($content, 200, [
        'Content-Type' => 'text/css',
    ]);
});
//js
Route::get('/js/{file}', function ($file) {
    $path = resource_path('js/' . $file . '/index.js');

    if (!file_exists($path)) {
        abort(404);
    }

    $content = file_get_contents($path);
    return Response::make($content, 200, [
        'Content-Type' => 'application/javascript',
    ]);
});

//component
Route::get('/component/{file}', function ($file) {
    $path = resource_path('views/component/' . $file);

    if (!file_exists($path)) {
        abort(404);
    }

    // Lấy phần mở rộng file
    $ext = pathinfo($path, PATHINFO_EXTENSION);

    // Xác định Content-Type đúng
    $mimeTypes = [
        'css' => 'text/css',
        'js'  => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'webp' => 'image/webp',
    ];

    $contentType = $mimeTypes[$ext] ?? 'application/octet-stream';

    return response()->file($path, [
        'Content-Type' => $contentType,
    ]);
});

//-----------------------------------------------------------------------------------------------------
// ADMIN ROUTES
//-----------------------------------------------------------------------------------------------------
Route::prefix('dashboard')->name('admin.')->group(function () {
    // Quản lý loại thuốc
    Route::resource('loaithuoc', LoaiThuocController::class);
    Route::post('loaithuoc/quick-add', [LoaiThuocController::class, 'quickAdd'])->name('loaithuoc.quickAdd');

    // Quản lý thuốc
    Route::resource('thuoc', AdminThuocController::class);
    Route::patch('thuoc/{id}/restore', [AdminThuocController::class, 'restore'])->name('thuoc.restore');
    Route::delete('thuoc/{id}/force-delete', [AdminThuocController::class, 'forceDelete'])->name('thuoc.forceDelete');

    // Quản lý đơn hàng

    // QUẢN LÝ ĐƠN HÀNG
    Route::prefix('donhang')->name('donhang.')->group(function () {

        // Trang chính với bộ lọc trạng thái
        Route::get('/', [DonHangController::class, 'index'])->name('index');

        // Lịch sử đơn hàng
        Route::get('/lich-su', [DonHangController::class, 'pageLichSu'])->name('lichsu');

        // Duyệt đơn
        Route::patch('/{id}/duyet', [DonHangController::class, 'duyet'])->name('duyet');

        // Xem chi tiết 1 đơn hàng
        Route::get('/{id}', [DonHangController::class, 'show'])->name('show');
    });

    Route::post('/dangxuatadmin', [AuthController::class, 'adminLogout'])->name('logoutadmin');
});
