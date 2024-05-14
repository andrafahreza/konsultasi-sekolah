<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ManajemenDataBkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name("login")->middleware('guest');
Route::post('/', [AuthController::class, 'auth'])->name("auth");

Route::middleware('auth')->group(function() {
    Route::get('/logout', [AuthController::class, 'logout'])->name("logout");
    Route::get('/home', [HomeController::class, 'home'])->name("home");
    Route::get('/profile', [UserController::class, 'profile'])->name("profile");
    Route::post('/profile', [UserController::class, 'simpanProfile'])->name("simpan-profile");
    Route::post('/ganti-password', [UserController::class, 'gantiPassword'])->name("ganti-password");

    Route::prefix("master-data")->group(function() {
        Route::prefix("pengguna")->group(function() {
            Route::get('/', [UserController::class, 'pengguna'])->name("pengguna");
            Route::post('ubah-status', [UserController::class, 'ubahStatus'])->name("ubah-status");
        });

        Route::prefix("siswa")->group(function() {
            Route::get('/', [UserController::class, 'siswa'])->name("siswa");
            Route::get('show/{id?}', [UserController::class, 'showSiswa'])->name("show-siswa");
            Route::post('simpan/{id?}', [UserController::class, 'simpanSiswa'])->name("siswa-simpan");

            Route::prefix("orang-tua")->group(function() {
                Route::get('list/{id?}', [UserController::class, 'orangTua'])->name("orang-tua");
                Route::get('show/{id?}', [UserController::class, 'showOrangTua'])->name("show-orang-tua");
                Route::post('simpan/{id?}', [UserController::class, 'simpanOrangTua'])->name("orang-tua-simpan");
                Route::post('hapus/{id?}', [UserController::class, 'hapusOrangTua'])->name("orang-tua-hapus");
            });
        });

        Route::prefix("kepala-sekolah")->group(function() {
            Route::get('/', [UserController::class, 'kepalaSekolah'])->name("kepala-sekolah");
            Route::post('simpan', [UserController::class, 'simpanKepalaSekolah'])->name("simpan-kepala-sekolah");
        });

        Route::prefix("konselor")->group(function() {
            Route::get('/', [UserController::class, 'konselor'])->name("konselor");
            Route::get('show/{id?}', [UserController::class, 'showKonselor'])->name("show-konselor");
            Route::post('simpan/{id?}', [UserController::class, 'simpanKonselor'])->name("konselor-simpan");
        });
    });

    Route::prefix("bimbingan-konseling")->group(function() {
        Route::prefix("data-bk")->group(function() {
            Route::get('/', [ManajemenDataBkController::class, 'dataBk'])->name("data-bk");
            Route::get('show/{id?}', [ManajemenDataBkController::class, 'showBk'])->name("show-data-bk");
            Route::post('simpan/{id?}', [ManajemenDataBkController::class, 'simpanBk'])->name("data-bk-simpan");
            Route::post('hapus', [ManajemenDataBkController::class, 'hapusBk'])->name("data-bk-hapus");
        });

        Route::prefix("history-bk")->group(function() {
            Route::get('/', [ManajemenDataBkController::class, 'historyBk'])->name("history-bk");
        });

        Route::prefix("laporan")->group(function() {
            Route::get('laporan-periode', [LaporanController::class, 'laporanPeriode'])->name("laporan-periode");
            Route::post('laporan-periode', [LaporanController::class, 'laporanPeriode'])->name("filter-laporan-periode");
            Route::get('laporan-siswa', [LaporanController::class, 'laporanSiswa'])->name("laporan-siswa");
            Route::post('laporan-siswa', [LaporanController::class, 'laporanSiswa'])->name("filter-laporan-siswa");
            Route::get('laporan-jenis', [LaporanController::class, 'laporanJenis'])->name("laporan-jenis");
            Route::post('laporan-jenis', [LaporanController::class, 'laporanJenis'])->name("filter-laporan-jenis");
        });
    });

    Route::prefix("chat")->group(function() {
        Route::get('list', [ChatController::class, 'list'])->name("list-chat");
        Route::get('start/{id_bk?}', [ChatController::class, 'start'])->name("start-chat");
        Route::get('get/{id_bk?}', [ChatController::class, 'get'])->name("get-chat");
        Route::post('send', [ChatController::class, 'send'])->name("send-chat");
        Route::post('end', [ChatController::class, 'end'])->name("chat-end");
        Route::get('history/{id?}', [ChatController::class, 'history'])->name("chat-history");
    });
});