<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CustomerController extends Controller
{
    // UC5: Lihat Produk (Publik)
    public function index()
    {
        $products = Product::where('status', 'available')->latest()->get();
        return view('customer.products.index', compact('products'));
    }

    public function design()
    {
        return view('customer.design'); // Arahkan ke file design.blade.php
    }

    public function orders()
    {
        // Nanti di sini kita tarik data order dari DB
        return view('customer.orders'); 
    }

    public function invoices()
    {
        return view('customer.invoices');
    }

    public function returns()
    {
        return view('customer.returns');
    }

    public function cart()
    {
        return view('customer.cart');
    }

    public function wishlist()
    {
        // UC7: Barang yang disukai (Wajib Login)
        return view('customer.wishlist'); 
    }


    public function checkout ()
    {
        return view('customer.checkout'); 
    }

    public function payment()
    {
        return view('customer.payment'); 
    }

    public function notifications()
    {
        return view('customer.notifications'); 
    }


    // UC3: Kelola Profil
    public function editProfile()
    {
        // Logika untuk menampilkan form edit profil
        // return view('customer.profile.edit', compact('user'));
        return view('customer.profile.edit');
    }

    public function updateProfile(Request $request)
    {
        // Logika untuk menyimpan perubahan profil
        // return redirect()->route('customer.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    // UC7: Tambah ke Keranjang
    public function addToCart(Request $request)
    {
        // Logika untuk menambahkan produk ke keranjang
        // return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // UC9: Upload Bukti Pembayaran
    public function uploadPaymentProof(Request $request)
    {
        // Logika untuk mengunggah dan memproses bukti pembayaran
        // return redirect()->route('customer.orders')->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
}