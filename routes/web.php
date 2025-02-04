<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/actionLogin', [AuthController::class, 'actionLogin'])->name('actionLogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('role:admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::prefix('admin/petugas')->group(function () {
        Route::get('/', function () {
            return view('petugas.index');
        })->name('petugas.index');
        // Route untuk CRUD operasi petugas
        Route::post('/store', [PetugasController::class, 'store'])->name('petugas.store');
        Route::get('/getall', [PetugasController::class, 'getall'])->name('petugas.getall');
        Route::get('/count', [PetugasController::class, 'count'])->name('petugas.count');
        Route::get('/{id_petugas}/edit', [PetugasController::class, 'edit'])->name('petugas.edit');
        Route::post('/update', [PetugasController::class, 'update'])->name('petugas.update');
        Route::delete('/delete', [PetugasController::class, 'delete'])->name('petugas.delete');
    });

    // Route::prefix('admin/pengguna')->group(function () {
    //     Route::get('/', function () {
    //         return view('user.index');
    //     })->name('user.index');
    //     // Route untuk CRUD operasi user
    //     Route::post('/store', [UserController::class, 'store'])->name('user.store');
    //     Route::get('/getall', [UserController::class, 'getall'])->name('user.getall');
    //     Route::get('/count', [UserController::class, 'count'])->name('user.count');
    //     Route::get('/{id_user}/edit', [UserController::class, 'edit'])->name('user.edit');
    //     Route::post('/update', [UserController::class, 'update'])->name('user.update');
    //     Route::delete('/delete', [UserController::class, 'delete'])->name('user.delete');
    // });

});

Route::middleware('role:user')->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');


    Route::prefix('user/pengaduan')->group(function () {
        Route::get('/', [PengaduanController::class, 'index'])->name('pengaduan.data.index');
        // Route untuk CRUD operasi pengaduan
        Route::post('/store', [PengaduanController::class, 'store'])->name('pengaduan.store');
        Route::get('/getall', [PengaduanController::class, 'getall'])->name('pengaduan.getall');
        Route::get('/count', [PengaduanController::class, 'count'])->name('pengaduan.count');
        Route::get('/{id_pengaduan}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
        Route::put('/update/{id}', [PengaduanController::class, 'update'])->name('pengaduan.update');
        Route::delete('/delete', [PengaduanController::class, 'delete'])->name('pengaduan.delete');
    });
});


Route::get('/user', function () {
    return view('user.index');
})->name('user.index');

// Route untuk CRUD operasi user
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/user/getall', [UserController::class, 'getall'])->name('user.getall');
Route::get('/user/count', [UserController::class, 'count'])->name('user.count');
Route::get('/user/{id_user}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/delete', [UserController::class, 'delete'])->name('user.delete');


