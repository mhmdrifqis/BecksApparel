@extends('layouts.dashboard')

@section('title', 'Laporan Penjualan & Analitik')

@section('content')

    <div class="flex flex-col md:flex-row justify-between md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Laporan Penjualan</h1>
            <p class="text-slate-400 text-sm mt-1">Ringkasan performa penjualan dan statistik produk.</p>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('admin.reports.sales') }}" method="GET" class="flex flex-col md:flex-row gap-2 bg-navy-800 p-2 rounded-xl border border-slate-700" x-data="{ filterOpt: '{{ $filter }}' }">
            <select name="filter" x-model="filterOpt" class="bg-navy-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-lime-400 focus:outline-none">
                <option value="today">Hari Ini</option>
                <option value="last_7_days">7 Hari Terakhir</option>
                <option value="this_month">Bulan Ini</option>
                <option value="this_year">Tahun Ini</option>
                <option value="custom">Kustom</option>
            </select>

            <div x-show="filterOpt === 'custom'" class="flex items-center gap-2" style="display: none;">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="bg-navy-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none w-32">
                <span class="text-slate-500">-</span>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="bg-navy-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none w-32">
            </div>

            <button type="submit" class="bg-lime-500 hover:bg-lime-400 text-navy-900 font-bold px-4 py-2 rounded-lg transition text-sm flex justify-center items-center gap-2">
                <i data-lucide="filter" class="w-4 h-4"></i> Terapkan
            </button>
        </form>
    </div>

    <!-- Peringatan Rentang Tanggal -->
    <div class="mb-6 bg-blue-500/10 border border-blue-500/20 text-blue-400 px-4 py-3 rounded-xl flex items-center gap-3 text-sm">
        <i data-lucide="calendar" class="w-5 h-5 shrink-0"></i>
        <p>Menampilkan data dari tanggal <strong>{{ $startDate->format('d M Y') }}</strong> hingga <strong>{{ $endDate->format('d M Y') }}</strong>.</p>
    </div>

    <!-- METRICS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Total Pendapatan -->
        <div class="bg-navy-800 rounded-2xl border border-slate-700 p-6 flex items-start gap-4 shadow-lg overflow-hidden relative group">
            <div class="bg-lime-500/10 p-4 rounded-xl text-lime-400 shrink-0">
                <i data-lucide="wallet" class="w-8 h-8"></i>
            </div>
            <div class="z-10 relative">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Pendapatan</p>
                <h3 class="text-3xl font-black text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
            <!-- Decorative abstract shape -->
            <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-lime-500/5 rounded-full blur-2xl group-hover:bg-lime-500/10 transition-colors"></div>
        </div>

        <!-- Total Pesanan Sukses -->
        <div class="bg-navy-800 rounded-2xl border border-slate-700 p-6 flex items-start gap-4 shadow-lg overflow-hidden relative group">
            <div class="bg-indigo-500/10 p-4 rounded-xl text-indigo-400 shrink-0">
                <i data-lucide="shopping-bag" class="w-8 h-8"></i>
            </div>
            <div class="z-10 relative">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Pesanan Sukses</p>
                <h3 class="text-3xl font-black text-white">{{ number_format($totalOrders) }} <span class="text-sm font-medium text-slate-500">Order</span></h3>
            </div>
            <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-indigo-500/5 rounded-full blur-2xl group-hover:bg-indigo-500/10 transition-colors"></div>
        </div>

        <!-- Average Order Value (AOV) -->
        <div class="bg-navy-800 rounded-2xl border border-slate-700 p-6 flex items-start gap-4 shadow-lg overflow-hidden relative group">
            <div class="bg-sky-500/10 p-4 rounded-xl text-sky-400 shrink-0">
                <i data-lucide="calculator" class="w-8 h-8"></i>
            </div>
            <div class="z-10 relative">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Rata-rata Order</p>
                <h3 class="text-3xl font-black text-white">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-500 mt-1">Nilai Rata-rata Pembelian</p>
            </div>
            <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-sky-500/5 rounded-full blur-2xl group-hover:bg-sky-500/10 transition-colors"></div>
        </div>

    </div>

    <!-- MAIN CHART & TOP PRODUCTS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Tren Penjualan -->
        <div class="lg:col-span-2 bg-navy-800 border border-slate-700 rounded-2xl p-6 shadow-xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg text-white">Tren Pendapatan Harian</h3>
                <span class="text-xs text-lime-400 bg-lime-400/10 px-3 py-1 rounded-full border border-lime-400/20 font-bold tracking-widest uppercase">Chart</span>
            </div>
            <div class="relative w-full h-[350px]">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="bg-navy-800 border border-slate-700 rounded-2xl p-6 shadow-xl flex flex-col">
            <h3 class="font-bold text-lg text-white mb-6 border-b border-slate-700 pb-3 flex items-center gap-2">
                <i data-lucide="trending-up" class="w-5 h-5 text-lime-400"></i> Top 5 Produk Terlaris
            </h3>
            
            <div class="space-y-4 flex-1">
                @forelse($topProducts as $index => $topItem)
                    <div class="flex items-center gap-4 bg-navy-900 p-3 rounded-xl border border-slate-700 hover:border-lime-500/50 transition">
                        <!-- Rank Badge -->
                        <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center font-bold text-sm border 
                            @if($index == 0) border-yellow-400 text-yellow-400
                            @elseif($index == 1) border-slate-300 text-slate-300
                            @elseif($index == 2) border-amber-600 text-amber-500
                            @else border-slate-600 text-slate-500
                            @endif">
                            #{{ $index + 1 }}
                        </div>

                        <!-- Product Image -->
                        <div class="w-12 h-12 rounded bg-navy-950 overflow-hidden flex-shrink-0">
                            @if($topItem->product && $topItem->product->image)
                                <img src="{{ asset('storage/' . $topItem->product->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-600"><i data-lucide="image" class="w-5 h-5"></i></div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-white truncate">{{ $topItem->product ? $topItem->product->name : 'Produk Dihapus' }}</p>
                            <p class="text-xs font-mono text-lime-400 mt-1">Rp {{ number_format($topItem->revenue, 0, ',', '.') }}</p>
                        </div>

                        <!-- Count -->
                        <div class="text-right">
                            <p class="text-xl font-black text-white">{{ $topItem->total_sold }}</p>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest">Terjual</p>
                        </div>
                    </div>
                @empty
                    <div class="h-full flex flex-col items-center justify-center text-slate-500 py-10 opacity-70">
                        <i data-lucide="inbox" class="w-12 h-12 mb-3"></i>
                        <p class="text-sm">Belum ada data penjualan</p>
                    </div>
                @endforelse
            </div>
            @if(count($topProducts) > 0)
                <p class="text-xs text-center text-slate-500 mt-6 pt-4 border-t border-slate-700">Peringkat berdasarkan kuantitas barang yang telah diproses.</p>
            @endif
        </div>

    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // Data dari Controller
        const labels = {!! json_encode($chartLabels) !!};
        const dataValues = {!! json_encode($chartData) !!};

        // Gradien Background Bawah Garis
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(163, 230, 53, 0.4)'); // lime-400 opacity
        gradient.addColorStop(1, 'rgba(163, 230, 53, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: dataValues,
                    borderColor: '#a3e635', // lime-400
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#1e293b', // navy-800
                    pointBorderColor: '#a3e635',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: 'start', // Fill area dibawah garis
                    tension: 0.4 // Garis melengkung halus (curved)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan tulisan legend karena cuma 1 dataset
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#a3e635',
                        bodyColor: '#ffffff',
                        borderColor: '#334155',
                        borderWidth: 1,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                let value = context.raw;
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: '#334155', // slate-700
                            borderDash: [5, 5]
                        },
                        ticks: {
                            color: '#94a3b8' // slate-400
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#334155', // slate-700
                            borderDash: [5, 5]
                        },
                        ticks: {
                            color: '#94a3b8',
                            callback: function(value) {
                                // Persingkat angka besar misalnya 1.000.000 jadi 1M / 1Jt
                                if(value >= 1000000) return 'Rp ' + (value/1000000) + ' Jt';
                                if(value >= 1000) return 'Rp ' + (value/1000) + ' Rb';
                                return value;
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    });
</script>
@endpush
