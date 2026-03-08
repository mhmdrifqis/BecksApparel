<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function salesReport(Request $request)
    {
        // 1. Tentukan Rentang Waktu (Filter Default: Bulan Ini)
        $filter = $request->input('filter', 'this_month');
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        if ($filter == 'today') {
            $startDate = Carbon::today();
            $endDate = Carbon::today()->endOfDay();
        } elseif ($filter == 'last_7_days') {
            $startDate = Carbon::today()->subDays(6);
            $endDate = Carbon::today()->endOfDay();
        } elseif ($filter == 'this_year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } elseif ($filter == 'custom') {
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
            }
        }

        // Query Utama untuk pesanan yang valid (Sudah dibayar & Tidak dibatalkan/diretur)
        // Kita paksa order_status selain pending/cancelled/returned dan payment_status = paid
        // Bisa disesuaikan dengan rule bisnis, misal yang dihitung omzet adalah semua yang payment_status = paid
        $baseQuery = Order::where('payment_status', 'paid')
                          ->whereNotIn('order_status', ['cancelled', 'returned'])
                          ->whereBetween('created_at', [$startDate, $endDate]);

        // 2. Metrik Utama (Cards)
        $totalRevenue = (clone $baseQuery)->sum('total_amount');
        $totalOrders = (clone $baseQuery)->count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // 3. Data Grafik Area (Pendapatan per Hari dalam periode terpilih)
        // Gunakan date formatting berdasarkan koneksi database (MySQL => DATE(created_at))
        $salesTrend = (clone $baseQuery)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Siapkan array untuk Chart.js labels & data
        $chartLabels = $salesTrend->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('d M');
        })->toArray();
        $chartData = $salesTrend->pluck('total')->toArray();

        // 4. Produk Terlaris (Top Selling Products)
        // Ambil order id yang valid sesuai range tanggal dan status
        $validOrderIds = (clone $baseQuery)->pluck('id');

        $topProducts = OrderItem::whereIn('order_id', $validOrderIds)
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(quantity * price) as revenue'))
            ->with('product') // Relasi ke nama & gambar produk
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.reports.sales', compact(
            'filter',
            'startDate',
            'endDate',
            'totalRevenue',
            'totalOrders',
            'averageOrderValue',
            'chartLabels',
            'chartData',
            'topProducts'
        ));
    }
}
