<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Landing Page (Home)
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Halaman Statis (Public)
Route::view('/about-us', 'about-us')->name('about.us');
Route::view('/faq', 'faq')->name('faq');
Route::view('/terms-and-conditions', 'terms')->name('terms.conditions');
Route::view('/features/ai-design', 'features.ai-design')->name('ai.design');

// 3. Gallery (Public)
Route::get('/gallery', function () {
    $path = public_path('images/gallery');
    $files = File::exists($path) ? File::files($path) : [];
    $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
    $images = [];

    foreach ($files as $file) {
        if (in_array(strtolower($file->getExtension()), $allowedExt)) {
            $images[] = asset('images/gallery/' . $file->getFilename());
        }
    }
    // Pastikan view 'dashboard.gallery' diganti jika letaknya bukan di folder dashboard
    return view('gallery', compact('images')); 
})->name('gallery');


// 4. Authentication Routes (Breeze)
require __DIR__.'/auth.php';


// 5. Protected Routes (Harus Login)
Route::middleware(['auth', 'verified'])->group(function () {

    // === UTAMA: Single Dashboard Route ===
    // Logika pemisahan Admin/Customer dipindah ke DashboardController
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // === ADMIN ONLY ===
    // Middleware 'role' diasumsikan sudah Anda buat. Jika belum, hapus 'role:...'
    Route::middleware(['role:admin,pimpinan'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', AdminUserController::class);
        Route::resource('products', \App\Http\Controllers\Admin\AdminProductController::class);
        // Admin Transaction Routes
        Route::get('/transactions', [App\Http\Controllers\Admin\AdminTransactionController::class, 'index'])->name('admin.transactions.index');
        Route::get('/transactions/{order}', [App\Http\Controllers\Admin\AdminTransactionController::class, 'show'])->name('admin.transactions.show');
        Route::put('/transactions/{order}', [App\Http\Controllers\Admin\AdminTransactionController::class, 'update'])->name('admin.transactions.update');
        
    });

});