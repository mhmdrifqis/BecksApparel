@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white">Dashboard Overview</h1>
        <p class="text-slate-400">Ringkasan aktivitas operasional Becks Apparel hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-navy-900 border border-slate-800 rounded-xl">
            <div class="flex items-center justify-between mb-4">
                <span class="text-slate-400 text-sm font-bold uppercase">Pendapatan (Bln)</span>
                <div class="p-2 bg-lime-400/10 text-lime-400 rounded-lg"><i data-lucide="dollar-sign" class="w-5 h-5"></i></div>
            </div>
            <h3 class="text-2xl font-bold text-white">Rp {{ number_format($stats['pendapatan_bulan_ini'], 0, ',', '.') }}</h3>
            <p class="text-xs text-lime-400 flex items-center gap-1 mt-1"><i data-lucide="trending-up" class="w-3 h-3"></i> +12% dari bulan lalu</p>
        </div>

        <div class="p-4 bg-navy-900 border border-slate-800 rounded-xl">
            <div class="flex items-center justify-between mb-4">
                <span class="text-slate-400 text-sm font-bold uppercase">Pesanan (Harian)</span>
                <div class="p-2 bg-blue-400/10 text-blue-400 rounded-lg"><i data-lucide="shopping-bag" class="w-5 h-5"></i></div>
            </div>
            <h3 class="text-2xl font-bold text-white">{{ $stats['total_pesanan_harian'] }} <span class="text-sm text-slate-500 font-normal">/ {{ $stats['total_pesanan_bulanan'] }} Bln</span></h3>
        </div>

        <div class="p-4 bg-navy-900 border border-slate-800 rounded-xl">
            <div class="flex items-center justify-between mb-4">
                <span class="text-slate-400 text-sm font-bold uppercase">Stok Kritis</span>
                <div class="p-2 bg-red-400/10 text-red-400 rounded-lg"><i data-lucide="alert-triangle" class="w-5 h-5"></i></div>
            </div>
            <h3 class="text-2xl font-bold text-white">{{ $stats['stok_kritis'] }} <span class="text-sm text-slate-500 font-normal">Item</span></h3>
            <p class="text-xs text-red-400 mt-1">Perlu restock segera</p>
        </div>

        <div class="p-4 bg-navy-900 border border-slate-800 rounded-xl">
            <div class="flex items-center justify-between mb-4">
                <span class="text-slate-400 text-sm font-bold uppercase">Pelanggan Aktif</span>
                <div class="p-2 bg-purple-400/10 text-purple-400 rounded-lg"><i data-lucide="users" class="w-5 h-5"></i></div>
            </div>
            <h3 class="text-2xl font-bold text-white">1,240</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-navy-900 border border-slate-800 p-4 rounded-xl text-center">
                    <span class="text-slate-400 text-xs uppercase font-bold">Pending Payment</span>
                    <p class="text-2xl font-bold text-orange-400">{{ $stats['pesanan_pending'] }}</p>
                </div>
                <div class="bg-navy-900 border border-slate-800 p-4 rounded-xl text-center">
                    <span class="text-slate-400 text-xs uppercase font-bold">Dalam Produksi</span>
                    <p class="text-2xl font-bold text-blue-400">{{ $stats['pesanan_produksi'] }}</p>
                </div>
                <div class="bg-navy-900 border border-slate-800 p-4 rounded-xl text-center">
                    <span class="text-slate-400 text-xs uppercase font-bold">Selesai / Kirim</span>
                    <p class="text-2xl font-bold text-lime-400">{{ $stats['pesanan_selesai'] }}</p>
                </div>
            </div>

            <div class="bg-navy-900 border border-slate-800 p-6 rounded-xl">
                <h3 class="text-white font-bold mb-4">Grafik Pendapatan (6 Bulan Terakhir)</h3>
                <div class="h-64 bg-navy-950/50 rounded flex items-end justify-between px-4 pb-0 pt-10 gap-2">
                    @foreach($chartData['data'] as $index => $data)
                        @php $height = ($data / 50000000) * 100; @endphp
                        <div class="w-full bg-lime-400/20 hover:bg-lime-400 transition-all rounded-t relative group" style="height: {{ $height }}%">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-xs p-1 rounded opacity-0 group-hover:opacity-100 transition">
                                {{ number_format($data/1000000, 1) }}jt
                            </div>
                            <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-slate-500 text-xs">
                                {{ $chartData['labels'][$index] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-navy-900 border border-slate-800 p-6 rounded-xl">
            <h3 class="text-white font-bold mb-4">Aktivitas Sistem</h3>
            <div class="space-y-6">
                @foreach($activities as $activity)
                <div class="flex gap-3 relative">
                    <div class="absolute left-2 top-2 -bottom-6 w-0.5 bg-slate-800"></div>
                    
                    <div class="relative z-10 w-4 h-4 rounded-full {{ isset($activity['type']) && $activity['type'] == 'alert' ? 'bg-red-500' : 'bg-lime-400' }} mt-1"></div>
                    <div>
                        <p class="text-slate-300 text-sm"><span class="font-bold text-white">{{ $activity['user'] }}</span> {{ $activity['action'] }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $activity['time'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <button class="w-full mt-6 py-2 border border-slate-700 text-slate-400 rounded-lg hover:bg-slate-800 hover:text-white transition text-sm">
                Lihat Semua Log
            </button>
        </div>
    </div>

@endsection