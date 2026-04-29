<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\BukuUserController;
use App\Http\Controllers\User\PeminjamanUserController;
use App\Http\Controllers\User\ProfileUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Kelola User
    Route::get('/users', [ManageUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [ManageUserController::class, 'create'])->name('users.create');
    Route::post('/users', [ManageUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [ManageUserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [ManageUserController::class, 'update'])->name('users.update');

    // Kelola Kategori
    Route::resource('kategoris', KategoriController::class);

    // Kelola Buku
    Route::resource('buku', BukuController::class);

    // Kelola Peminjaman & Pengembalian
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::patch('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::patch('/peminjaman/{peminjaman}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
    Route::patch('/peminjaman/{peminjaman}/konfirmasi-kembali', [PeminjamanController::class, 'konfirmasiKembali'])->name('peminjaman.konfirmasiKembali');
    Route::post('/peminjaman/{peminjaman}/review-terlambat', [PeminjamanController::class, 'reviewTerlambat'])->name('peminjaman.reviewTerlambat');
    Route::patch('/peminjaman/{peminjaman}/konfirmasi-bayar', [PeminjamanController::class, 'konfirmasiBayar'])->name('peminjaman.konfirmasiBayar');
});

// Route User
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    // Daftar Buku
    Route::get('/buku', [BukuUserController::class, 'index'])->name('buku.index');
    Route::get('/buku/{buku}', [BukuUserController::class, 'show'])->name('buku.show');

    // Peminjaman User
    Route::get('/peminjaman', [PeminjamanUserController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/pinjam/{buku}', [PeminjamanUserController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanUserController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{peminjaman}/kembali', [PeminjamanUserController::class, 'formKembali'])->name('peminjaman.formKembali');
    Route::post('/peminjaman/{peminjaman}/ajukan-kembali', [PeminjamanUserController::class, 'ajukanKembali'])->name('peminjaman.ajukanKembali');

    // Profil User
    Route::get('/profile', [ProfileUserController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileUserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileUserController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileUserController::class, 'updatePassword'])->name('profile.password');
});

require __DIR__.'/auth.php';