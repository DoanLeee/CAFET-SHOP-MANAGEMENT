<?php

use App\Http\Controllers\BanController;
use App\Http\Controllers\ChitietbanhangController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\HoaDonBanHangController;
use App\Http\Controllers\KhuVucController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MomoController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TrangChuController;
use App\Http\Controllers\VouCherController;
use Illuminate\Support\Facades\Route;






Route::get('/test', [TestController::class, 'test']);
Route::get('/', [TrangChuController::class, 'index']);



Route::group(['prefix' => '/admin'], function () {

    Route::group(['prefix' => '/khu-vuc'], function () {
        Route::get('/', [KhuVucController::class, 'index']);
        Route::get('/data', [KhuVucController::class, 'getData'])->name('datakhuvuc');
        Route::post('/nhap', [KhuVucController::class, 'nhap'])->name('nhapkhuvuc');
        Route::post('/tinhtrangkv', [KhuvucController::class, 'tinhtrangkv'])->name('tinhtrangkhuvuc');
        Route::post('/xoa', [KhuVucController::class, 'xoa'])->name('xoakhuvuc');
        Route::post('/capnhapkv', [KhuVucController::class, 'capnhapkv'])->name('capnhapkhuvuc');
        Route::post('/checkslug', [KhuvucController::class, 'checkslug'])->name('checkslugkhuvuc');
    });

    Route::group(['prefix' => '/ban'], function () {
        Route::get('/', [BanController::class, 'index']);
        Route::get('/data', [BanController::class, 'getData'])->name('databan');
        Route::post('/nhap', [BanController::class, 'nhap'])->name('nhapban');
        Route::post('/tinhtrangban', [BanController::class, 'tinhtrangban'])->name('tinhtrangban');
        Route::post('/xoa', [BanController::class, 'xoa'])->name('xoaban');
        Route::post('/capnhapban', [BanController::class, 'capnhapban'])->name('capnhapban');
        Route::post('/checkslug', [BanController::class, 'checkslug'])->name('checkslugban');
    });

    Route::group(['prefix' => '/danh-muc'], function () {
        Route::get('/', [DanhMucController::class, 'index']);
        Route::get('/data', [DanhMucController::class, 'getData'])->name('datadanhmuc');
        Route::post('/nhap', [DanhMucController::class, 'nhap'])->name('nhapdanhmuc');
        Route::post('/tinhtrangdanhmuc', [DanhMucController::class, 'tinhtrangdanhmuc'])->name('tinhtrangdanhmuc');
        Route::post('/xoa', [DanhMucController::class, 'xoa'])->name('xoadanhmuc');
        Route::post('/capnhapdanhmuc', [DanhMucController::class, 'capnhapdanhmuc'])->name('capnhapdanhmuc');
        Route::post('/checkslug', [DanhMucController::class, 'checkslug'])->name('checkslugdanhmuc');
    });

    Route::group(['prefix' => '/menu'], function () {
        Route::get('/', [MenuController::class, 'index']);
        Route::get('/data', [MenuController::class, 'getData'])->name('datamenu');
        Route::post('/nhap', [MenuController::class, 'nhap'])->name('nhapmenu');
        Route::post('/tinhtrangmenu', [MenuController::class, 'tinhtrangmenu'])->name('tinhtrangmenu');
        Route::post('/xoa', [MenuController::class, 'xoa'])->name('xoamenu');
        Route::post('/capnhapmenu', [MenuController::class, 'capnhapmenu'])->name('capnhapmenu');
        Route::post('/checkslug', [MenuController::class, 'checkslug'])->name('checkslugmenu');
        Route::post('/search', [MenuController::class, 'search'])->name('searchmenu');
    });

    Route::group(['prefix' => '/ban-hang'], function () {
        Route::get('/', [HoaDonBanHangController::class, 'index']);
        Route::post('/tao-hoa-don', [HoaDonBanHangController::class, 'store'])->name('banhangtaohoadon');
        Route::post('/find-id-by-idban', [HoaDonBanHangController::class, 'findIdByIdBan'])->name('banhangfindidbyidban');
        Route::post('/them-menu', [HoadonbanhangController::class, 'addmenuchitiethoadon'])->name('banhangthemmenu');
        Route::post('/danh-sach-menu-theo-hoa-don', [HoadonbanhangController::class, 'getdanhsachmenutheohoadon'])->name('banhangdanhsachmenutheohoadon');
        Route::post('/update', [HoadonbanhangController::class, 'update'])->name('banhangupdate');
        Route::post('/pha-che', [HoaDonBanHangController::class, 'phache'])->name('phache');
        Route::post('/xoa-chi-tiet', [HoadonbanhangController::class, 'xoachitietdonhang'])->name('xoachitietdonhang');

        Route::post('/chi-tiet/update-chiet-khau', [ChitietbanhangController::class, 'UpdateChietKhau'])->name('updatechietkhau');  //1
        Route::post('/danh-sach-mon-theo-id-ban', [ChiTietBanHangController::class, 'getDanhSachMonTheoIdBan'])->name('getdanhsachmontheoidban'); //2
        Route::post('/chuyen-mon', [ChiTietBanHangController::class, 'chuyenMonQuaBanKhac'])->name('chuyenmonquabankhac');  //3
        Route::post('/xac-nhan', [HoaDonBanHangController::class, 'xacnhanvoucher'])->name('xacnhanvoucher'); //5  chưa xong

        Route::post('/update-hoa-don', [HoaDonBanHangController::class, 'updateHoaDon'])->name('updatehoadon');
        Route::get('/in-bill/{id}', [HoaDonBanHangController::class, 'inBill'])->name('inbill');
        Route::post('/thanh-toan', [HoaDonBanHangController::class, 'thanhToan'])->name('thanhtoan');
        Route::post('/momo_payment', [HoaDonBanHangController::class, 'momo_payment'])->name('momo_payment');


    });

    // phache
    Route::group(['prefix' => '/pha-che'], function() {
        Route::get('/', [ChitietbanhangController::class, 'index']);
        Route::get('/data-phache', [ChiTietBanHangController::class, 'getdataphache'])->name('dataphache');
        Route::post('/update-phache', [ChiTietBanHangController::class, 'updatephache'])->name('capnhapphache');
    });

    // Khách hàng
    Route::group(['prefix' => '/voucher'], function() {
        Route::get('/', [VouCherController::class, 'index']);
        Route::get('/data', [VouCherController::class, 'getData'])->name('datavoucher');
        Route::post('/nhap', [VouCherController::class, 'nhap'])->name('nhapvoucher');
        Route::post('/xoa', [VouCherController::class, 'xoa'])->name('xoavoucher');
        Route::post('/capnhapvoucher', [VouCherController::class, 'capnhapvoucher'])->name('capnhapvoucher');
    });
});

// Route::post('/momo_payment', [MomoController::class, 'momo_payment'])->name('momo_payment');




