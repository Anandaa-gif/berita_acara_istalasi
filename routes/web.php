<?php

use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserViewController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'teknisi'])->group(
    function () {
        Route::get('/user/berita-acara', [UserViewController::class, 'index'])->name('user.index');
        Route::get('/user/berita-acara/create', [UserViewController::class, 'create'])->name('user.berita_acara.create');
        Route::post('/user/berita-acara/store', [UserViewController::class, 'store'])->name('user.store');
        Route::get('/user/berita-acara/{id}', [UserViewController::class, 'show'])->name('user.show');
        Route::get('/user/berita-acara/{id}/pdf', [UserViewController::class, 'exportPdf'])->name('user.pdf');
        Route::get('/user/berita-acara/{id}/send-whatsapp', [UserViewController::class, 'sendWhatsapp'])->name('user.sendWhatsapp');
    }
);

Route::get('/pelanggan/berita-acara/{id}', [PelangganController::class, 'show'])->name('pelanggan.show');
Route::get('/pelanggan/berita-acara/{id}/pdf', [PelangganController::class, 'exportPdf'])->name('pelanggan.pdf');



Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/berita-acara', [BeritaAcaraController::class, 'index'])->name('berita_acara.index');
    Route::get('/berita-acara/create', [BeritaAcaraController::class, 'create'])->name('berita_acara.create');
    Route::post('/berita-acara/store', [BeritaAcaraController::class, 'store'])->name('berita_acara.store');
    Route::get('/berita-acara/{id}', [BeritaAcaraController::class, 'show'])->name('berita_acara.show');
    Route::get('/berita-acara/{id}/edit', [BeritaAcaraController::class, 'edit'])->name('berita_acara.edit');
    Route::put('/berita-acara/{id}', [BeritaAcaraController::class, 'update'])->name('berita_acara.update');
    Route::delete('/berita-acara/{id}', [BeritaAcaraController::class, 'destroy'])->name('berita_acara.destroy');
    Route::get('/berita-acara/{id}/pdf', [BeritaAcaraController::class, 'exportPdf'])->name('berita_acara.pdf');
    Route::get('/berita-acara/{id}/send-whatsapp', [BeritaAcaraController::class, 'sendWhatsapp'])->name('berita_acara.sendWhatsapp');
    Route::get('/berita-acara/export/excel', [BeritaAcaraController::class, 'export'])->name('berita_acara.export.excel');

});
require __DIR__ . '/auth.php';
