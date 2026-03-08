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
    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_note' => 'nullable|string'
        ]);

        return DB::transaction(function () use ($request, $order) {
            if ($request->action === 'approve') {
                // 1. Update status pembayaran saja (status pesanan tetap Menunggu/Pending)
                $order->update([
                    'payment_status' => 'paid' // Memastikan sinkronisasi dengan field payment_status
                ]);

                // Update payment model
                if ($order->payment) {
                    $order->payment->update([
                        'payment_status' => 'paid',
                        'paid_at' => now()
                    ]);
                }

                // 2. UA9: Kurangi stok produk secara otomatis
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product) {
                        $product->decrement('stock', $item->quantity);
                    }
                }

                // --- NOTIFICATION ---
                if ($order->user) {
                    $order->user->notify(new \App\Notifications\OrderStatusUpdatedNotification($order, 'Pembayaran untuk pesanan ' . $order->invoice_number . ' telah berhasil diverifikasi. Pesanan akan segera diproses.'));
                }

                return back()->with('success', 'Pembayaran untuk pesanan ' . $order->invoice_number . ' berhasil diverifikasi dan stok telah diperbarui.');
            } else {
                // Menolak pembayaran
                $order->update([
                    'payment_status' => 'rejected'
                ]);

                if ($order->payment) {
                    $order->payment->update([
                        'payment_status' => 'rejected'
                    ]);
                }
                
                // --- NOTIFICATION ---
                if ($order->user) {
                    $order->user->notify(new \App\Notifications\OrderStatusUpdatedNotification($order, 'Maaf, bukti pembayaran untuk pesanan ' . $order->invoice_number . ' ditolak. Silakan unggah ulang bukti yang valid.'));
                }

                return back()->with('success', 'Pembayaran ditolak. Pelanggan akan diminta untuk mengunggah ulang bukti pembayaran.');
            }
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

        // --- NOTIFICATION ---
        if ($order->user) {
            $order->user->notify(new \App\Notifications\OrderStatusUpdatedNotification($order));
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . strtoupper($request->order_status));
    }

    /**
     * UA5: Lihat Daftar Invoice & Keuangan
     */
    public function invoices()
    {
        $orders = Order::with(['user', 'payment'])
            ->whereIn('payment_status', ['paid', 'awaiting_verification'])
            ->latest()
            ->paginate(15);
            
        return view('admin.orders.invoices', compact('orders'));
    }

    /**
     * UA5: Generate / Lihat Invoice Detail
     */
    public function showInvoice(Order $order)
    {
        $order->load(['user', 'items.product', 'payment']);
        // Logika untuk menampilkan atau generate PDF invoice
        return view('admin.orders.invoice', compact('order'));
    }

    /**
     * UA6: Kelola Retur (Menyetujui/Menolak)
     */
    public function handleReturn(Request $request, Order $order)
    {
        // ... (unchanged previous method) ...
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

    /**
     * Menampilkan daftar pesanan yang siap dikirim (Mass Waybill)
     */
    public function shipping()
    {
        // Ambil pesanan yang sudah dibayar atau sedang diproduksi (siap kirim)
        $orders = Order::with(['user', 'items.product', 'items.design'])
            ->whereIn('order_status', ['paid', 'production'])
            ->where('payment_status', 'paid')
            ->orderBy('created_at', 'asc') // Yang paling lama bayar didahulukan
            ->get();

        return view('admin.orders.shipping', compact('orders'));
    }

    /**
     * Memproses input resi massal
     */
    public function bulkUpdateShipping(Request $request)
    {
        $request->validate([
            'tracking_numbers' => 'nullable|array',
            'tracking_numbers.*' => 'nullable|string'
        ]);

        $trackingNumbers = $request->input('tracking_numbers', []);
        $updatedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($trackingNumbers as $orderId => $trackingNumber) {
                // Hanya proses jika nomor resi tidak kosong
                if (!empty(trim($trackingNumber))) {
                    $order = Order::find($orderId);
                    if ($order && in_array($order->order_status, ['paid', 'production'])) {
                        $order->update([
                            'tracking_number' => $trackingNumber,
                            'order_status' => 'shipped' // Otomatis ubah status
                        ]);
                        
                        // --- NOTIFICATION ---
                        if ($order->user) {
                            $order->user->notify(new \App\Notifications\OrderStatusUpdatedNotification($order, 'Pesanan ' . $order->invoice_number . ' Anda telah dikirim! Nomor Resi: ' . $trackingNumber));
                        }
                        
                        $updatedCount++;
                    }
                }
            }
            DB::commit();
            
            if ($updatedCount > 0) {
                return back()->with('success', "Berhasil memperbarui resi dan mengirim $updatedCount pesanan.");
            } else {
                return back()->with('info', 'Tidak ada nomor resi baru yang diinput.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan resi: ' . $e->getMessage());
        }
    }
}