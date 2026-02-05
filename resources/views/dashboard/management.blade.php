@extends('layouts.dashboard')

@section('title', 'Executive Dashboard')

@section('content')

    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">Executive Overview</h1>
            <p class="text-slate-400 text-sm">Ringkasan performa bisnis dan operasional Becks Apparel.</p>
        </div>
        <div class="text-right hidden md:block">
            <p class="text-xs text-slate-500 uppercase font-bold">Periode Laporan</p>
            <p class="text-white font-bold">{{ date('F Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-navy-900 border border-slate-800 rounded-xl p-5 relative overflow-hidden group hover:border-lime-500/50 transition">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <i data-lucide="banknote" class="w-16 h-16 text-lime-400"></i>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2">Total Pendapatan (YTD)</p>
            <h3 class="text-2xl lg:text-3xl font-bold text-white mb-1">
                Rp {{ number_format($kpi['pendapatan_total'] / 1000000000, 1, ',', '.') }} M
            </h3>
            <div class="flex items-center gap-1 text-lime-400 text-xs font-bold bg-lime-400/10 inline-block px-2 py-1 rounded">
                <i data-lucide="trending-up" class="w-3 h-3"></i> +{{ $kpi['pertumbuhan_bulan_ini'] }}% Growth
            </div>
        </div>

        <div class="bg-navy-900 border border-slate-800 rounded-xl p-5">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-blue-500/10 text-blue-400 rounded-lg">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <span class="text-xs text-slate-500">vs bulan lalu</span>
            </div>
            <h3 class="text-2xl font-bold text-white mb-1">{{ number_format($kpi['pelanggan_aktif']) }}</h3>
            <p class="text-slate-400 text-xs font-bold uppercase">Pelanggan Aktif</p>
        </div>

        <div class="bg-navy-900 border border-slate-800 rounded-xl p-5">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-purple-500/10 text-purple-400 rounded-lg">
                    <i data-lucide="zap" class="w-6 h-6"></i>
                </div>
                @if($kpi['efisiensi_produksi'] >= 90)
                    <span class="text-lime-400 text-xs font-bold">Excellent</span>
                @else
                    <span class="text-yellow-400 text-xs font-bold">Perlu Review</span>
                @endif
            </div>
            <h3 class="text-2xl font-bold text-white mb-1">{{ $kpi['efisiensi_produksi'] }}%</h3>
            <p class="text-slate-400 text-xs font-bold uppercase">Efisiensi Produksi</p>
        </div>

        <div class="bg-navy-900 border border-slate-800 rounded-xl p-5">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-red-500/10 text-red-400 rounded-lg">
                    <i data-lucide="refresh-ccw" class="w-6 h-6"></i>
                </div>
                <span class="text-xs text-slate-500">Target: < 2%</span>
            </div>
            <h3 class="text-2xl font-bold text-white mb-1">{{ $kpi['retur_rate'] }}%</h3>
            <p class="text-slate-400 text-xs font-bold uppercase">Tingkat Retur</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-navy-900 border border-slate-800 rounded-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-white">Tren Pendapatan Tahunan</h3>
                <button class="text-xs text-lime-400 border border-lime-400/30 px-3 py-1 rounded hover:bg-lime-400 hover:text-navy-950 transition">
                    Download Laporan
                </button>
            </div>

            <div class="h-64 flex items-end justify-between gap-4 px-4 pb-2 border-b border-slate-800 relative">
                <div class="absolute inset-0 flex flex-col justify-between pointer-events-none opacity-20">
                    <div class="border-t border-slate-500 w-full"></div>
                    <div class="border-t border-slate-500 w-full"></div>
                    <div class="border-t border-slate-500 w-full"></div>
                    <div class="border-t border-slate-500 w-full"></div>
                </div>

                @foreach($revenueTrend['data'] as $index => $value)
                    @php $height = ($value / 3000) * 100; @endphp
                    
                    <div class="w-full flex flex-col justify-end group cursor-pointer">
                        <div class="mb-2 text-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <span class="bg-slate-800 text-white text-xs px-2 py-1 rounded shadow-lg">Rp {{ number_format($value, 0, ',', '.') }}Jt</span>
                        </div>
                        <div class="bg-gradient-to-t from-lime-600 to-lime-400 rounded-t w-full relative transition-all duration-500 hover:brightness-110" style="height: {{ $height }}%"></div>
                        <div class="text-center mt-3 text-xs text-slate-400 font-bold">{{ $revenueTrend['labels'][$index] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="bg-navy-900 border border-slate-800 rounded-xl p-6">
                <h3 class="font-bold text-white mb-4 text-sm uppercase tracking-wider text-lime-400">Top Performa Produk</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-slate-800">
                        <div class="flex items-center gap-3">
                            <span class="text-lg font-bold text-slate-500">01</span>
                            <div>
                                <p class="text-white font-bold text-sm">Jersey Full Print</p>
                                <p class="text-xs text-slate-500">1.2k Terjual</p>
                            </div>
                        </div>
                        <span class="text-lime-400 font-bold text-sm">+24%</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-slate-800">
                        <div class="flex items-center gap-3">
                            <span class="text-lg font-bold text-slate-500">02</span>
                            <div>
                                <p class="text-white font-bold text-sm">Kaos Sablon DTF</p>
                                <p class="text-xs text-slate-500">850 Terjual</p>
                            </div>
                        </div>
                        <span class="text-lime-400 font-bold text-sm">+12%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <span class="text-lg font-bold text-slate-500">03</span>
                            <div>
                                <p class="text-white font-bold text-sm">Jaket Varsity</p>
                                <p class="text-xs text-slate-500">400 Terjual</p>
                            </div>
                        </div>
                        <span class="text-red-400 font-bold text-sm">-5%</span>
                    </div>
                </div>
            </div>

            <div class="bg-navy-900 border border-slate-800 rounded-xl p-6">
                <h3 class="font-bold text-white mb-4 text-sm uppercase tracking-wider text-red-400">Perhatian Manajemen</h3>
                <ul class="space-y-3">
                    <li class="flex gap-3 items-start">
                        <i data-lucide="alert-triangle" class="w-4 h-4 text-yellow-400 mt-0.5 flex-shrink-0"></i>
                        <p class="text-sm text-slate-300">Stok bahan baku 'Cotton 24s' menipis, berpotensi menghambat produksi minggu depan.</p>
                    </li>
                    <li class="flex gap-3 items-start">
                        <i data-lucide="trending-down" class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0"></i>
                        <p class="text-sm text-slate-300">Penurunan penjualan kategori 'Aksesoris' sebesar 5% dibanding kuartal lalu.</p>
                    </li>
                </ul>
            </div>

        </div>
    </div>

@endsection