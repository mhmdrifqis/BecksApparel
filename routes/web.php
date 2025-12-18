<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; 
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini kita mendaftarkan semua route untuk aplikasi.
| Pastikan Route::get('/') menggunakan [HomeController::class, 'index'].
|
*/

// 1. Landing Page (PENTING: Ini yang mengirim data $products)
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Halaman Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// POST: attempt login (simple session-based demo)
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.attempt');

// 3. Dashboard Pelanggan
Route::get('/customer/dashboard', function () {
    // Simple session-based protection: redirect to login if not a customer
    $user = session('user');
    if (!$user || ($user['role'] ?? '') !== 'customer') {
        return redirect()->route('login');
    }

    // Sample demo data for the customer dashboard — replace with real queries later
    $orders = [
        [
            'id' => 'ORD-1001',
            'date' => '2025-12-01',
            'status' => 'Selesai',
            'total' => 125000,
            'items' => 3
        ],
        [
            'id' => 'ORD-1002',
            'date' => '2025-12-05',
            'status' => 'Dalam Produksi',
            'total' => 85000,
            'items' => 1
        ],
        [
            'id' => 'ORD-1003',
            'date' => '2025-12-10',
            'status' => 'Menunggu Pembayaran',
            'total' => 150000,
            'items' => 2
        ]
    ];

    return view('dashboard.customer', compact('orders'));
})->name('customer.dashboard');

// 4. Dashboard Produksi
Route::get('/production/dashboard', function () {
    return view('dashboard.production');
})->name('production.dashboard');

// 5. Dashboard Admin
Route::get('/admin/dashboard', function () {
    return view('dashboard.admin');
})->name('admin.dashboard');

// 6. Fitur AI Design
Route::get('/features/ai-design', function () {
    return view('features.ai-design');
})->name('ai.design');

// POST: logout (clears demo session)
Route::post('/logout', function () {
    session()->forget('user');
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

//--alfi

// Gallery
Route::get('/gallery', function () {
    $path = public_path('images/gallery');

    $files = File::exists($path) ? File::files($path) : [];

    $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
    $images = [];
    foreach ($files as $file) {
        $ext = strtolower($file->getExtension());
        if (in_array($ext, $allowedExt, true)) {
            $images[] = asset('images/gallery/' . $file->getFilename());
        }
    }

    return view('dashboard.gallery', compact('images'));
})->name('gallery');