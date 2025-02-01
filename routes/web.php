<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.dashboard');
})->name('layouts.dashboard');


Route::get('/petugas', function () {
    return view('petugas.index');
})->name('petugas.index');

// Route untuk CRUD operasi petugas
Route::post('/petugas/store', [PetugasController::class, 'store'])->name('petugas.store');
Route::get('/petugas/getall', [PetugasController::class, 'getall'])->name('petugas.getall');
Route::get('/petugas/count', [PetugasController::class, 'count'])->name('petugas.count');
Route::get('/petugas/{id}/edit', [PetugasController::class, 'edit'])->name('petugas.edit');
Route::post('/petugas/update', [PetugasController::class, 'update'])->name('petugas.update');
Route::delete('/petugas/delete', [PetugasController::class, 'delete'])->name('petugas.delete');

Route::get('/kategori', function () {
    return view('kategori.index');
})->name('kategori.index');

// Route untuk CRUD operasi kategori
Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/getall', [KategoriController::class, 'getall'])->name('kategori.getall');
Route::get('/kategori/count', [KategoriController::class, 'count'])->name('kategori.count');
Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::post('/kategori/update', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/delete', [KategoriController::class, 'delete'])->name('kategori.delete');

Route::get('/pengaduan', function () {
    return view('pengaduan.index');
})->name('pengaduan.index');

// Route untuk CRUD operasi pengaduan
Route::post('/pengaduan/store', [PengaduanController::class, 'store'])->name('pengaduan.store');
Route::get('/pengaduan/getall', [PengaduanController::class, 'getall'])->name('pengaduan.getall');
Route::get('/pengaduan/count', [PengaduanController::class, 'count'])->name('pengaduan.count');
Route::get('/pengaduan/{id}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
Route::put('/pengaduan/update/{id}', [PengaduanController::class, 'update'])->name('pengaduan.update');
Route::delete('/pengaduan/delete', [PengaduanController::class, 'delete'])->name('pengaduan.delete');
