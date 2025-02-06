<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/actionLogin', [AuthController::class, 'actionLogin'])->name('actionLogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('role:admin')->group(function () {
    Route::get('/dashboardAdmin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // PETUGAS
    Route::get('/petugas', function () {
        return view('admin.petugas.index');
    })->name('petugas.index');
    Route::post('/petugas/store', [AdminController::class, 'storePetugas'])->name('petugas.store');
    Route::get('/petugas/getall', [AdminController::class, 'getallPetugas'])->name('petugas.getall');
    Route::get('/petugas/count', [AdminController::class, 'countPetugas'])->name('petugas.count');
    Route::get('/petugas/{id_petugas}/edit', [AdminController::class, 'editPetugas'])->name('petugas.edit');
    Route::post('/petugas/update', [AdminController::class, 'updatePetugas'])->name('petugas.update');
    Route::delete('/petugas/delete', [AdminController::class, 'deletePetugas'])->name('petugas.delete');
    // END PETUGAS

    // PENGGUNA
    Route::get('/user', function () {
        return view('admin.user.index');
    })->name('user.index');
    // Route untuk CRUD operasi user
    Route::post('user/store', [AdminController::class, 'storeUser'])->name('user.store');
    Route::get('user/getall', [AdminController::class, 'getallUser'])->name('user.getall');
    Route::get('user/count', [AdminController::class, 'countUser'])->name('user.count');
    Route::get('user/{id_user}/edit', [AdminController::class, 'editUser'])->name('user.edit');
    Route::post('user/update', [AdminController::class, 'updateUser'])->name('user.update');
    Route::delete('user/delete', [AdminController::class, 'deleteUser'])->name('user.delete');
    // END PENGGUNA

    // PENGADUAN
    Route::get('/admin/pengaduan', function () {
        return view('admin.pengaduan.data.index');
    })->name('pengaduan.index');
    Route::get('/admin/pengaduan/getall', [AdminController::class, 'getallPengaduan'])->name('pengaduan.getallforAdmin');
    Route::get('/admin/pengaduan/count', [AdminController::class, 'countPengaduan'])->name('pengaduan.countforAdmin');

    Route::get('/admin/tindakLanjut', function () {
        return view('admin.pengaduan.tindakLanjut.index');
    })->name('tindakLanjut.index');
    Route::get('/admin/tindakLanjut/getall', [AdminController::class, 'getallTindakLanjut'])->name('tindakLanjut.getallforAdmin');
    Route::get('/admin/tindakLanjut/count', [AdminController::class, 'countTindakLanjut'])->name('tindakLanjut.countforAdmin');
    // END PENGADUAN

    // LAPORAN
    Route::get('/laporan', function () {
        return view('admin.laporan.index');
    })->name('laporan.index');
    Route::get('/laporan/getall', [AdminController::class, 'getallLaporan'])->name('laporan.getallforAdmin');
    Route::get('/laporan/count', [AdminController::class, 'countLaporan'])->name('laporan.countforAdmin');
    // END LAPORAN
});


Route::middleware('role:user')->group(function () {
    Route::get('/dashboardUser', [UserController::class, 'dashboard'])->name('user.dashboard');
    // PENGADUAN
    Route::get('/user/pengaduan', function () {
        return view('user.pengaduan.index');
    })->name('user.pengaduan.index');
    Route::post('/user/pengaduan/store', [UserController::class, 'storePengaduan'])->name('pengaduan.store');
    Route::get('/user/pengaduan/getall', [UserController::class, 'getallPengaduan'])->name('pengaduan.getallforUser');
    Route::get('/user/pengaduan/count', [UserController::class, 'countPengaduan'])->name('pengaduan.countforUser');
    Route::get('/user/pengaduan/{id_pengaduan}/edit', [UserController::class, 'editPengaduan'])->name('pengaduan.edit');
    Route::put('/user/pengaduan/update', [UserController::class, 'updatePengaduan'])->name('pengaduan.update');
    Route::delete('/user/pengaduan/delete', [UserController::class, 'deletePengaduan'])->name('pengaduan.delete');
    // END PENGADUAN

    // NOTIFIKASI
    Route::get('/user/notifikasi', function () {
        return view('user.notifikasi.index');
    })->name('user.notifikasi.index');
    Route::post('/user/notifikasi/store', [UserController::class, 'storeNotifikasi'])->name('notifikasi.store');
    Route::get('/user/notifikasi/getall', [UserController::class, 'getallNotifikasi'])->name('notifikasi.getallforUser');
    Route::get('/user/notifikasi/count', [UserController::class, 'countNotifikasi'])->name('notifikasi.countforUser');
    Route::get('/user/notifikasi/{id_notifikasi}/edit', [UserController::class, 'editNotifikasi'])->name('notifikasi.edit');
    Route::put('/user/notifikasi/update', [UserController::class, 'updateNotifikasi'])->name('notifikasi.update');
    Route::get('/user/notifikasi/{id_notifikasi}', [UserController::class, 'updateStatus'])->name('notifikasi.updateStatus');
    Route::delete('/user/notifikasi/delete', [UserController::class, 'deleteNotifikasi'])->name('notifikasi.delete');
    // END NOTIFIKASI
});

Route::middleware('role:petugas')->group(function () {
    Route::get('/dashboardPetugas', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
    Route::get('/petugas/pengaduan', function () {
        return view('petugas.pengaduan.index');
    })->name('petugas.pengaduan.index');
    Route::get('/petugas/pengaduan/getall', [PetugasController::class, 'getallPengaduan'])->name('pengaduan.getallforPetugas');
    Route::get('/petugas/pengaduan/count', [PetugasController::class, 'countPengaduan'])->name('pengaduan.countforPetugas');
    // NOTIFIKASI
    Route::get('/petugas/notifikasi', function () {
        return view('petugas.notifikasi.index');
    })->name('petugas.notifikasi.index');
    Route::post('/petugas/notifikasi/store', [PetugasController::class, 'storeNotifikasi'])->name('notifikasi.storeforPetugas');
    Route::get('/petugas/notifikasi/getall', [PetugasController::class, 'getallNotifikasi'])->name('notifikasi.getallforPetugas');
    Route::get('/petugas/notifikasi/count', [PetugasController::class, 'countNotifikasi'])->name('notifikasi.countforPetugas');
    Route::get('/petugas/notifikasi/{id_notifikasi}/edit', [PetugasController::class, 'editNotifikasi'])->name('notifikasi.editforPetugas');
    Route::put('/petugas/notifikasi/update', [PetugasController::class, 'updateNotifikasi'])->name('notifikasi.updateforPetugas');
    Route::delete('/petugas/notifikasi/delete', [PetugasController::class, 'deleteNotifikasi'])->name('notifikasi.deleteforPetugas');
    // END NOTIFIKASI
});
