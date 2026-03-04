<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    /**
     * UA3: Melihat seluruh transaksi pelanggan
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * UA4: Verifikasi Pembayaran Manual
     */
    public function verifyPayment(Order $order)
    {
        return DB::transaction(function () use ($order) {
            // 1. Update status pesanan
            $order->update([
                'order_status' => 'production', // Setelah bayar, status jadi produksi
                'paid_at' => now(),
                'payment_status' => 'paid' // Memastikan sinkronisasi dengan field payment_status
            ]);

            // 2. UA9: Kurangi stok produk secara otomatis
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            // UA10: Trigger Notifikasi WhatsApp bisa diletakkan di sini

            return back()->with('success', 'Pembayaran untuk pesanan ' . $order->invoice_number . ' berhasil diverifikasi dan stok telah diperbarui.');
        });
    }

    /**
     * UA7: Kelola Status Pesanan (Update ke Produksi, Selesai, dll)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,production,shipped,completed,cancelled,returned',
            'tracking_number' => 'nullable|string'
        ]);

        $order->update(['order_status' => $request->order_status]);

        // Jika status 'shipped', admin biasanya memasukkan nomor resi
        if ($request->has('tracking_number')) {
            $order->update(['tracking_number' => $request->tracking_number]);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . strtoupper($request->order_status));
    }

    /**
     * UA5: Generate / Lihat Invoice
     */
    public function showInvoice(Order $order)
    {
        // Logika untuk menampilkan atau generate PDF invoice
        return view('admin.orders.invoice', compact('order'));
    }

    /**
     * UA6: Kelola Retur (Menyetujui/Menolak)
     */
    public function handleReturn(Request $request, Order $order)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_note' => 'nullable|string'
        ]);

        if ($request->action === 'approve') {
            $order->update(['order_status' => 'returned']);
            
            // UA9: Kembalikan stok produk karena barang diretur
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        return back()->with('success', 'Pengajuan retur telah diproses.');
    }
}