<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\CustomerController;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // === ADMIN ONLY ===
    Route::middleware(['role:admin,pimpinan'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', AdminUserController::class);
        Route::resource('products', \App\Http\Controllers\Admin\AdminProductController::class);
        // Admin Transaction Routes
        Route::get('/transactions', [App\Http\Controllers\Admin\AdminTransactionController::class, 'index'])->name('admin.transactions.index');
        Route::get('/transactions/{order}', [App\Http\Controllers\Admin\AdminTransactionController::class, 'show'])->name('admin.transactions.show');
        Route::put('/transactions/{order}', [App\Http\Controllers\Admin\AdminTransactionController::class, 'update'])->name('admin.transactions.update');
        
    });




        Route::middleware(['auth', 'verified'])->group(function () {
            
            Route::prefix('my')->name('customer.')->group(function () {
                Route::get('/design', [CustomerController::class, 'design'])->name('design');
                Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
                Route::get('/invoices', [CustomerController::class, 'invoices'])->name('invoices');
                Route::get('/returns', [CustomerController::class, 'returns'])->name('returns');
                Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');
                Route::get('/wishlist', [CustomerController::class, 'wishlist'])->name('wishlist');

            });
        });



                // Route Publik (Bisa Tamu)
        Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');

        // Route Wajib Login (Gabung ke group customer tadi)
        Route::middleware(['auth', 'verified'])->group(function () {
            Route::prefix('my')->name('customer.')->group(function () {
                // ... design, orders, dll ...
                Route::get('/wishlist', [CustomerController::class, 'wishlist'])->name('wishlist');
            });
        });

});