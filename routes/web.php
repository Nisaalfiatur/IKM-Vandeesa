<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\AuthController;

// ========== AUTH ROUTES (Tanpa Middleware Auth) ==========
// Rute untuk halaman login, proses login, dan logout pengguna
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Halaman utama: redirect ke dashboard jika sudah login, jika belum tampilkan landing page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('landing');
});

// Dashboard untuk semua role
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// ========== ADMIN & KASIR SHARED INVOICE ROUTES ==========
// Invoice resource didefinisikan sekali untuk menghindari konflik nama rute.
// Proteksi per-action dilakukan via middleware di bawah.
Route::middleware(['auth'])->group(function () {
    // Shared invoice actions (admin & kasir)
    Route::get('/invoice/{id}/print', [InvoiceController::class, 'print'])->name('invoice.print');
    Route::post('/invoice/{invoiceId}/detail', [InvoiceController::class, 'storeDetail'])->name('invoice.storeDetail');
    Route::get('/invoice/{invoiceId}/detail/{itemId}/delete', [InvoiceController::class, 'deleteDetail'])->name('invoice.deleteDetail');
    Route::post('/invoice/{invoiceId}/diskon', [InvoiceController::class, 'updateDiskon'])->name('invoice.updateDiskon');
    Route::resource('/invoice', InvoiceController::class);
});

// ========== ADMIN ROUTES ==========
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Item Management
    Route::get('/item/{id}/delete', [ItemController::class, 'delete'])->name('item.delete');
    Route::resource('/item', ItemController::class);

    // Pegawai Management
    Route::get('/pegawai/{id}/delete', [PegawaiController::class, 'delete'])->name('pegawai.delete');
    Route::resource('/pegawai', PegawaiController::class);

    // Member Management
    Route::get('/member/{id}/delete', [MemberController::class, 'delete'])->name('member.delete');
    Route::resource('/member', MemberController::class);

    // Reseller Management
    Route::get('/reseller/{id}/delete', [ResellerController::class, 'delete'])->name('reseller.delete');
    Route::resource('/reseller', ResellerController::class);

    // Invoice delete (admin only)
    Route::get('/invoice/{id}/delete', [InvoiceController::class, 'delete'])->name('invoice.delete');

    // Delivery Management
    Route::get('/delivery/{id}/delete', [DeliveryController::class, 'delete'])->name('delivery.delete');
    Route::get('/delivery/{id}/print', [DeliveryController::class, 'print'])->name('delivery.print');
    Route::resource('/delivery', DeliveryController::class);

});

// ========== SHARED ADMIN & OWNER ROUTES ==========
Route::middleware(['auth', 'role:admin,owner'])->group(function () {

    // Laporan (Admin & Owner)
    Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])->name('laporan.penjualan');
    Route::get('/laporan/stok', [LaporanController::class, 'stok'])->name('laporan.stok');
    Route::get('/laporan/delivery', [LaporanController::class, 'delivery'])->name('laporan.delivery');
});

// ========== KASIR ROUTES ==========
Route::middleware(['auth', 'role:kasir'])->group(function () {
    // Item dengan UI e-commerce / POS
    Route::get('/kasir/items', [KasirController::class, 'items'])->name('kasir.items');
    Route::get('/kasir/item/{id}', [KasirController::class, 'itemDetail'])->name('kasir.item-detail');
    Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');
    Route::get('/kasir/struk/{id}', [KasirController::class, 'printStruk'])->name('kasir.print_struk');
});

