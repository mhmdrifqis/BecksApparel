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
            // Data Dummy Statistik
            $stats = [
                'total_pesanan_harian' => 12,
                'total_pesanan_bulanan' => 345,
                'pendapatan_bulan_ini' => 45000000, 
                'stok_kritis' => 5, 
                'pesanan_pending' => 8,
                'pesanan_produksi' => 15,
                'pesanan_selesai' => 120,
            ];

            // Data Grafik
            $chartData = [
                'labels' => ['Agu', 'Sep', 'Okt', 'Nov', 'Des', 'Jan'],
                'data' => [15000000, 23000000, 18000000, 32000000, 45000000, 41000000]
            ];
            
            // Aktivitas Log
            $activities = [
                ['user' => 'Budi Santoso', 'action' => 'Membuat pesanan baru #ORD-1005', 'time' => '5 menit lalu'],
                ['user' => 'Siti Aminah', 'action' => 'Melakukan pembayaran via QRIS', 'time' => '10 menit lalu'],
                ['user' => 'System', 'action' => 'Stok Kain Cotton Combed 30s menipis', 'time' => '1 jam lalu', 'type' => 'alert'],
            ];

            return view('dashboard.admin', compact('stats', 'chartData', 'activities'));
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

            // Ubah view ke 'dashboard.management'
            return view('dashboard.management', compact('kpi', 'revenueTrend'));
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

            // Ubah view ke 'dashboard.production'
            return view('dashboard.production', compact('productionStats', 'priorityOrders'));
        }

        // ====================================================
        // 4. LOGIKA DASHBOARD PELANGGAN (Pesanan Saya)
        // ====================================================
        if ($user->isPelanggan()) {
            // Data Pesanan Pelanggan
            $myOrders = [
                [
                    'id' => 'ORD-1001', 
                    'invoice' => 'INV-20260120-001',
                    'date' => '20 Jan 2026',
                    'status' => 'Selesai', 
                    'total' => 125000, 
                    'resi' => 'JNE-8829100'
                ],
                [
                    'id' => 'ORD-1002', 
                    'invoice' => 'INV-20260125-002',
                    'date' => '25 Jan 2026',
                    'status' => 'Proses Jahit', 
                    'total' => 450000, 
                    'resi' => null
                ],
            ];

            // Ubah view ke 'dashboard.customers'
            return view('dashboard.customers', compact('myOrders'));
        }

        // Fallback jika tidak ada role yang cocok
        return view('dashboard.index');
    }
}