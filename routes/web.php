<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RedirectInternalUsers;
use App\Http\Middleware\CheckRole;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Landing Page (Home)
// Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])
    ->middleware(RedirectInternalUsers::class) 
    ->name('home');
    
// 2. Halaman Statis (Public)
Route::view('/about-us', 'about-us')->name('about.us');
Route::view('/faq', 'faq')->name('faq');
Route::view('/terms-and-conditions', 'terms')->name('terms.conditions');
Route::view('/features/ai-design', 'features.ai-design')->name('ai.design');
Route::view('/catalog', 'catalog')->name('catalog');
Route::view('/features', 'features')->name('features');

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

// 5. Public Product Routes (UC5: Lihat Produk)
Route::get('/products', [CustomerController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [CustomerController::class, 'show'])->name('products.show');
Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');

// 5. Protected Routes (Harus Login)
Route::middleware(['auth', 'verified'])->group(function () {

    // === UTAMA: Single Dashboard Route ===
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cart Actions
    Route::post('/cart/add', [CustomerController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/item/{item}', [CustomerController::class, 'removeCartItem'])->name('cart.remove');

    // === ADMIN ONLY ===
    Route::middleware(['role:admin,pimpinan'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', AdminUserController::class);
        Route::resource('products', \App\Http\Controllers\Admin\AdminProductController::class);
        
        // Admin Order Management (UA3 - UA7)
        Route::resource('orders', AdminOrderController::class);
        Route::post('orders/{order}/verify', [AdminOrderController::class, 'verifyPayment'])->name('orders.verify');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('orders/{order}/return', [AdminOrderController::class, 'handleReturn'])->name('orders.return');
        
    });

    // === CUSTOMER PROTECTED ROUTES ===
    Route::prefix('my')->name('customer.')->group(function () {
        Route::get('/design', [CustomerController::class, 'design'])->name('design');
        Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');
        Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
        Route::get('/invoices', [CustomerController::class, 'invoices'])->name('invoices');
        Route::get('/returns', [CustomerController::class, 'returns'])->name('returns');
        Route::get('/wishlist', [CustomerController::class, 'wishlist'])->name('wishlist');
        Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [CustomerController::class, 'processCheckout'])->name('checkout.process');
        Route::get('/payment', [CustomerController::class, 'payment'])->name('payment');
        Route::get('/notifications', [CustomerController::class, 'notifications'])->name('notifications');

        // Order & Invoices
        Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [CustomerController::class, 'showOrder'])->name('orders.show');
        Route::post('/orders/{order}/payment', [CustomerController::class, 'uploadPaymentProof'])->name('payment.upload');
        Route::get('/invoices', [CustomerController::class, 'invoices'])->name('invoices');

        // Route Profil & Alamat
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});