<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Middleware\CheckLoginAdmin;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['get', 'post'], 'botman', [BotManController::class, 'handle']);



Route::middleware('checkloginadmin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'home'])->name('home');

    Route::get('/ds_gionglua', [AdminController::class, 'ds_gionglua'])->name('ds_gionglua');
    Route::get('/add_gionglua', [AdminController::class, 'add_gionglua'])->name('add_gionglua');
    Route::post('/add_gionglua', [AdminController::class, 'postadd_gionglua']);
    Route::get('/delete_gionglua/{ma_gionglua}', [AdminController::class, 'delete_gionglua'])->name('delete_gionglua');
    Route::get('/edit_gionglua/{ma_gionglua}', [AdminController::class, 'edit_gionglua'])->name('edit_gionglua');
    Route::post('/edit_gionglua/{ma_gionglua}', [AdminController::class, 'postedit_gionglua']);

    Route::get('/ds_saubenh', [AdminController::class, 'ds_saubenh'])->name('ds_saubenh');
    Route::get('/add_saubenh', [AdminController::class, 'add_saubenh'])->name('add_saubenh');
    Route::post('/add_saubenh', [AdminController::class, 'postadd_saubenh']);
    Route::get('/delete_saubenh/{ma_saubenh}', [AdminController::class, 'delete_saubenh'])->name('delete_saubenh');
    Route::get('/edit_saubenh/{ma_saubenh}', [AdminController::class, 'edit_saubenh'])->name('edit_saubenh');
    Route::post('/edit_saubenh/{ma_saubenh}', [AdminController::class, 'postedit_saubenh']);

    Route::get('/ds_tintuc', [AdminController::class, 'ds_tintuc'])->name('ds_tintuc');
    Route::get('/add_tintuc', [AdminController::class, 'add_tintuc'])->name('add_tintuc');
    Route::post('/add_tintuc', [AdminController::class, 'postadd_tintuc']);
    Route::get('/delete_tintuc/{ma_tintuc}', [AdminController::class, 'delete_tintuc'])->name('delete_tintuc');
    Route::get('/edit_tintuc/{ma_tintuc}', [AdminController::class, 'edit_tintuc'])->name('edit_tintuc');
    Route::post('/edit_tintuc/{ma_tintuc}', [AdminController::class, 'postedit_tintuc']);

    Route::get('/add_loai_tintuc', [AdminController::class, 'add_loai_tintuc'])->name('add_loai_tintuc');
    Route::post('/add_loai_tintuc', [AdminController::class, 'postadd_loai_tintuc']);
    Route::get('/delete_loai_tintuc/{ma}', [AdminController::class, 'delete_loai_tintuc'])->name('delete_loai_tintuc');

    Route::get('/add_cauhoi', [AdminController::class, 'add_cauhoi'])->name('add_cauhoi');
    Route::post('/add_cauhoi', [AdminController::class, 'postadd_cauhoi']);
    Route::get('/delete_cauhoi/{ma}', [AdminController::class, 'delete_cauhoi'])->name('delete_cauhoi');
    Route::post('/edit_cauhoi', [AdminController::class, 'postedit_cauhoi'])->name('edit_cauhoi');

    Route::get('add_cauhoi_excel', [AdminController::class, 'add_cauhoi_excel'])->name('add_cauhoi_excel');
    Route::post('add_cauhoi_excel', [AdminController::class, 'post_add_cauhoi_excel'])->name('post_add_cauhoi_excel');
    Route::get('/tai_file', [AdminController::class, 'downloadfile'])->name('tai_file');

    Route::get('/ds_phanhoi', [AdminController::class, 'ds_phanhoi'])->name('ds_phanhoi');
    Route::get('/delete_phanhoi/{ma}', [AdminController::class, 'delete_phanhoi'])->name('delete_phanhoi');
    Route::post('/edit_phanhoi', [AdminController::class, 'postedit_phanhoi'])->name('edit_phanhoi');

    Route::get('/add_nguoidung', [AdminController::class, 'add_nguoidung'])->name('add_nguoidung');
    Route::post('/add_nguoidung', [AdminController::class, 'postadd_nguoidung']);

    Route::get('/thongke_baiviet', [AdminController::class, 'thongke_baiviet'])->name('thongke_baiviet');
    Route::post('/thongke_baiviet', [AdminController::class, 'postthongke_baiviet']);

    Route::get('/thongke_cauhoi', [AdminController::class, 'thongke_cauhoi'])->name('thongke_cauhoi');
    Route::post('/thongke_cauhoi', [AdminController::class, 'postthongke_cauhoi']);

    Route::get('/ds_thongtin_capnhat_gionglua/{ma_gionglua}', [AdminController::class, 'ds_thongtin_capnhat_gionglua'])->name('ds_thongtin_capnhat_gionglua');
    Route::get('/detail_thongtin_capnhat_gionglua/{ma}', [AdminController::class, 'detail_thongtin_capnhat_gionglua'])->name('detail_thongtin_capnhat_gionglua');
    Route::get('/ds_thongtin_capnhat_saubenh/{ma_saubenh}', [AdminController::class, 'ds_thongtin_capnhat_saubenh'])->name('ds_thongtin_capnhat_saubenh');
    Route::get('/detail_thongtin_capnhat_saubenh/{ma}', [AdminController::class, 'detail_thongtin_capnhat_saubenh'])->name('detail_thongtin_capnhat_saubenh');
    Route::get('/ds_thongtin_capnhat_tintuc/{ma_tintuc}', [AdminController::class, 'ds_thongtin_capnhat_tintuc'])->name('ds_thongtin_capnhat_tintuc');
    Route::get('/detail_thongtin_capnhat_tintuc/{ma}', [AdminController::class, 'detail_thongtin_capnhat_tintuc'])->name('detail_thongtin_capnhat_tintuc');

    Route::get('/ds_binhluan_gionglua/{ma}', [AdminController::class, 'ds_binhluan_gionglua'])->name('ds_binhluan_gionglua');
    Route::get('/ds_binhluan_saubenh/{ma}', [AdminController::class, 'ds_binhluan_saubenh'])->name('ds_binhluan_saubenh');
    Route::get('/ds_binhluan_tintuc/{ma}', [AdminController::class, 'ds_binhluan_tintuc'])->name('ds_binhluan_tintuc');

    Route::get('/an_binhluan/{ma}', [AdminController::class, 'an_binhluan'])->name('an_binhluan');
    Route::get('/hien_binhluan/{ma}', [AdminController::class, 'hien_binhluan'])->name('hien_binhluan');

    Route::get('/chan_binhluan/{ma}', [AdminController::class, 'chan_binhluan'])->name('chan_binhluan');
    Route::get('/chophep_binhluan/{ma}', [AdminController::class, 'chophep_binhluan'])->name('chophep_binhluan');
});

Route::get('/admin_login', [LoginRegisterController::class, 'admin_login'])->name('admin_login');
Route::post('/admin_login', [LoginRegisterController::class, 'postadmin_login']);
Route::get('/admin_logout', [LoginRegisterController::class, 'admin_logout'])->name('admin_logout');



Route::get('/', [UserController::class, 'home'])->name('home');

Route::get('/gionglua/{ma}', [UserController::class, 'detail_gionglua'])->name('gionglua');
Route::get('/saubenh/{ma}', [UserController::class, 'detail_saubenh'])->name('saubenh');
Route::get('/tintuc/{ma}', [UserController::class, 'detail_tintuc'])->name('tintuc');
Route::get('/ds_tintuc', [UserController::class, 'ds_tintuc'])->name('ds_tintuc');
Route::get('/ds_gionglua', [UserController::class, 'ds_gionglua'])->name('ds_gionglua');
Route::get('/ds_saubenh', [UserController::class, 'ds_saubenh'])->name('ds_saubenh');

Route::get('/ds_phanhoi', [UserController::class, 'ds_phanhoi'])->name('ds_phanhoi');

Route::post('/tintuc/{ma}', [UserController::class, 'binhluan_tintuc'])->name('binhluan_tintuc');
Route::post('/gionglua/{ma}', [UserController::class, 'binhluan_gionglua'])->name('binhluan_gionglua');
Route::post('/saubenh/{ma}', [UserController::class, 'binhluan_saubenh'])->name('binhluan_saubenh');

Route::delete('/tintuc/{ma}', [UserController::class, 'delete_binhluan'])->name('delete_binhluan');


Route::get('/dangky', [UserController::class, 'dangky'])->name('dangky');
Route::post('/dangky', [UserController::class, 'post_dangky']);
Route::get('/dangnhap', [LoginRegisterController::class, 'login'])->name('dangnhap');
Route::post('/dangnhap', [LoginRegisterController::class, 'post_login']);
Route::get('/dangxuat', [LoginRegisterController::class, 'logout'])->name('dangxuat');
