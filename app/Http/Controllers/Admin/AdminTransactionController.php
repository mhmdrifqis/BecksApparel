<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    // Menampilkan daftar semua transaksi
    public function index()
    {
        // Ambil data order beserta user-nya, urutkan dari yang terbaru
        $orders = Order::with('user')->latest()->paginate(10);
        
        return view('admin.transactions.index', compact('orders'));
    }

    // Menampilkan detail satu transaksi
    public function show(Order $order)
    {
        // Load detail item dan produknya
        $order->load('items.product', 'user');
        
        return view('admin.transactions.show', compact('order'));
    }

    // Update status (Misal: Konfirmasi Pembayaran / Update Resi / Masuk Produksi)
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required',
            'resi_number' => 'nullable|string'
        ]);

        $order->update([
            'status' => $request->status,
            'resi_number' => $request->resi_number,
        ]);
        
        // Jika status diubah jadi 'paid', otomatis payment_status jadi 'paid'
        if ($request->status == 'paid') {
            $order->update(['payment_status' => 'paid']);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}