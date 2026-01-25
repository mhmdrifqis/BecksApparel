<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan ini di-use biar lebih aman

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Role Admin, Manajemen, ATAU Produksi (Internal Staff)
        if ($user->isAdmin() || $user->isManajemen() || $user->isProduksi()) {
            return view('dashboard.index'); // Nanti kontennya kita buat dinamis di view
        }

        // 2. Role Pelanggan
        if ($user->isPelanggan()) {
            // Data Dummy
            $orders = [
                ['id' => 'ORD-001', 'status' => 'Selesai', 'total' => 150000],
                ['id' => 'ORD-002', 'status' => 'Produksi', 'total' => 300000],
            ];
            return view('dashboard.index', compact('orders'));
        }

        return view('dashboard.index');
    }
}