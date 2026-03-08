<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ====================================================
        // 1. LOGIKA DASHBOARD ADMIN (Full Access)
        // ====================================================
        if ($user->isAdmin()) {
            // Live Stats Query
            $stats = [
                'total_pesanan_harian' => \App\Models\Order::whereDate('created_at', now()->today())->count(),
                'total_pesanan_bulanan' => \App\Models\Order::whereMonth('created_at', now()->month)
                                            ->whereYear('created_at', now()->year)->count(),
                'pendapatan_bulan_ini' => \App\Models\Order::whereMonth('created_at', now()->month)
                                            ->whereYear('created_at', now()->year)
                                            ->where('payment_status', 'paid')
                                            ->whereNotIn('order_status', ['pending', 'cancelled', 'returned'])
                                            ->sum('total_amount'), 
                'stok_kritis' => \App\Models\Product::where('stock', '<=', 5)->count(), 
                'pesanan_pending' => \App\Models\Order::where('order_status', 'pending')->count(),
                'pesanan_produksi' => \App\Models\Order::where('order_status', 'production')->count(),
                'pesanan_selesai' => \App\Models\Order::whereIn('order_status', ['shipped', 'completed'])->count(),
            ];

            // Recent Orders (5 pesanan terakhir)
            $recentOrders = \App\Models\Order::with('user')
                ->latest()
                ->take(5)
                ->get();

            // Data Grafik Live (6 Bulan Terakhir)
            $chartData = [
                'labels' => [],
                'data' => []
            ];
            
            for ($i = 5; $i >= 0; $i--) {
                $monthStr = now()->subMonths($i)->translatedFormat('M Y');
                $monthNum = now()->subMonths($i)->month;
                $yearNum = now()->subMonths($i)->year;
                
                $monthlyRevenue = \App\Models\Order::whereMonth('created_at', $monthNum)
                                    ->whereYear('created_at', $yearNum)
                                    ->where('payment_status', 'paid')
                                    ->whereNotIn('order_status', ['pending', 'cancelled', 'returned'])
                                    ->sum('total_amount');
                                    
                $chartData['labels'][] = $monthStr;
                $chartData['data'][] = (float) $monthlyRevenue;
            }

            return view('dashboard.admin', compact('stats', 'recentOrders', 'chartData'));
        }

        // ====================================================
        // 2. LOGIKA DASHBOARD MANAJEMEN (Monitoring & KPI)
        // ====================================================
        if ($user->isManajemen()) {
            // Data Dummy Khusus Eksekutif
            $kpi = [
                'pendapatan_total' => 1500000000, // 1.5 Milyar (YTD)
                'pertumbuhan_bulan_ini' => 12.5, // Persen
                'pelanggan_aktif' => 1240,
                'retur_rate' => 1.2, // Persen (Rendah = Bagus)
                'efisiensi_produksi' => 94, // Persen
            ];

            // Grafik Tren Tahunan
            $revenueTrend = [
                'labels' => ['2021', '2022', '2023', '2024', '2025'],
                'data' => [800, 1200, 1500, 2100, 2500] // Dalam Juta
            ];

            // Ubah view ke 'dashboard.manajemen'
            return view('dashboard.manajemen', compact('kpi', 'revenueTrend'));
        }
        
        // ====================================================
        // 3. LOGIKA DASHBOARD PRODUKSI (Antrean & Operasional)
        // ====================================================
        if ($user->isProduksi()) {
            // Data Antrean Produksi
            $productionStats = [
                'antrean_cetak' => 5,    // Perlu segera dicetak
                'proses_jahit' => 12,    // Sedang dijahit
                'quality_control' => 4,  // Sedang diperiksa
                'siap_kirim' => 8,       // Packing selesai
            ];

            // Pesanan Prioritas (Deadline dekat)
            $priorityOrders = [
                ['invoice' => 'INV-001', 'item' => 'Jersey Timnas', 'qty' => 50, 'deadline' => 'Hari Ini', 'status' => 'Jahit'],
                ['invoice' => 'INV-005', 'item' => 'Kaos Event', 'qty' => 100, 'deadline' => 'Besok', 'status' => 'Cetak'],
            ];

            // Ubah view ke 'dashboard.produksi'
            return view('dashboard.produksi', compact('productionStats', 'priorityOrders'));
        }

        // ====================================================
        // 4. LOGIKA DASHBOARD PELANGGAN (Pesanan Saya)
        // ====================================================
        if ($user->isPelanggan()) {
            // Live Query: Ambil 5 pesanan terbaru milik pelanggan ini
            $myOrders = \App\Models\Order::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();

            // Ubah view ke 'dashboard.pelanggan'
            return view('dashboard.pelanggan', compact('myOrders'));
        }

        // Fallback jika tidak ada role yang cocok
        return view('dashboard.index');
    }
}