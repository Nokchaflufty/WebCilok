<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/order', [OrderController::class, 'index'])->name('order');
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{id}', [OrderController::class, 'success'])->name('order.success');

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.login.submit');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/profile/edit', [AdminController::class, 'profileEdit'])->name('admin.profile.edit');
    Route::get('/menu', [AdminController::class, 'menu'])->name('admin.menu');
    Route::get('/menu/create', [AdminController::class, 'menuCreate'])->name('admin.menu.create');
    Route::get('/transaksi', [AdminController::class, 'transaksi'])->name('admin.transaksi');
    Route::get('/riwayat', [AdminController::class, 'riwayat'])->name('admin.riwayat');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});