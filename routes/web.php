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
    Route::post('/profile/update', [AdminController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::get('/menu', [AdminController::class, 'menu'])->name('admin.menu');
    Route::get('/menu/create', [AdminController::class, 'menuCreate'])->name('admin.menu.create');
    Route::post('/menu/store', [AdminController::class, 'menuStore'])->name('admin.menu.store');
    Route::get('/menu/{id}/edit', [AdminController::class, 'menuEdit'])->name('admin.menu.edit');
    Route::post('/menu/{id}/update', [AdminController::class, 'menuUpdate'])->name('admin.menu.update');
    Route::post('/menu/{id}/delete', [AdminController::class, 'menuDestroy'])->name('admin.menu.delete');
    
    Route::get('/transaksi', [AdminController::class, 'transaksi'])->name('admin.transaksi');
    Route::get('/transaksi/create', [AdminController::class, 'transaksiCreate'])->name('admin.transaksi.create');
    Route::post('/transaksi/store', [AdminController::class, 'transaksiStore'])->name('admin.transaksi.store');
    Route::get('/transaksi/{id}/details', [AdminController::class, 'transaksiDetails'])->name('admin.transaksi.details');
    Route::post('/transaksi/item/{id}/delete', [AdminController::class, 'transaksiItemDestroy'])->name('admin.transaksi.item_delete');
    Route::post('/transaksi/update-status', [AdminController::class, 'transaksiUpdateStatus'])->name('admin.transaksi.update_status');
    Route::post('/transaksi/{id}/delete', [AdminController::class, 'transaksiDestroy'])->name('admin.transaksi.delete');
    Route::get('/riwayat', [AdminController::class, 'riwayat'])->name('admin.riwayat');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});