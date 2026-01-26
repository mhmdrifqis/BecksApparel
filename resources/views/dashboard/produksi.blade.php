@extends('layouts.dashboard')

@section('title', 'Dashboard Produksi')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Halo, Tim Produksi! 🛠️</h1>
            <p class="text-slate-400 text-sm">Pantau antrean, stok bahan, dan target harian di sini.</p>
        </div>
        <div class="flex gap-3">
            <button class="bg-navy-800 hover:bg-navy-700 text-slate-300 border border-slate-700 font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition text-sm">
                <i data-lucide="layers" class="w-4 h-4"></i> Cek Stok Bahan
            </button>
            <button class="bg-lime-400 hover:bg-lime-500 text-navy-950 font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition shadow-lg shadow-lime-400/20 text-sm">
                <i data-lucide="scan-barcode" class="w-4 h-4"></i> Scan Pesanan
            </button>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        
        <div class="bg-navy-900 border border-slate-800 p-4 rounded-xl relative overflow-hidden group hover:border-lime-500/50 transition cursor-pointer">
            <div class="flex justify-between items-start mb-2">
                <div class="p-2 bg-red-500/10 text-red-500 rounded-lg group-hover:bg-red-500 group-hover:text-white transition">
                    <i data-lucide="printer" class="w-6 h-6"></i>
                </div>
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">Urgent</span>
            </div>
            <h3 class="text-3xl font-bold text-white">{{ $productionStats['antrean_cetak'] }}</h3>
            <p class="text-slate-400 text-xs font-bold uppercase mt-1">Antrean Cetak</p>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-navy-800">
                <div class="h-full bg-red-500 w-[70%]"></div>
            </div>
        </div>

        <div class="bg-navy-900 border border-slate-800 p-4 rounded-xl relative overflow-hidden group hover:border-yellow-500/50 transition cursor-pointer">
            <div class="flex justify-between items-start mb-2">
                <div class="p-2 bg-yellow-500/10 text-yellow-500 rounded-lg group-hover:bg-yellow-500 group-hover:text-navy-950 transition">
                    <i data-lucide="scissors" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-white">{{ $productionStats['proses_jahit'] }}</h3>
            <p class="text-slate-400 text-xs font-bold uppercase mt-1">Sedang Dijahit</p>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-navy-800">
                <div class="h-full bg-yellow-500 w-[45%]"></div>
            </div>
        </div>

        <div class="bg-navy-900 border border-slate-800 p-4 rounded-xl relative overflow-hidden group hover:border-blue-500/50 transition cursor-pointer">
            <div class="flex justify-between items-start mb-2">
                <div class="p-2 bg-blue-500/10 text-blue-500 rounded-lg group-hover:bg-blue-500 group-hover:text-white transition">
                    <i data-lucide="clipboard-check" class="w-6 h-6"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-white">{{ $productionStats['quality_control'] }}</h3>
            <p class="text-slate-400 text-xs font-bold uppercase mt-1">Quality Control</p>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-navy-800">
                <div class="h-full bg-blue-500 w-[30%]"></div>
            </div>
        </div>

        <div class="bg-navy-900 border border-slate-800 p-4 rounded-xl relative overflow-hidden group hover:border-lime-500/50 transition cursor-pointer">
            <div class="flex justify-between items-start mb-2">
                <div class="p-2 bg-lime-500/10 text-lime-500 rounded-lg group-hover:bg-lime-500 group-hover:text-navy-950 transition">
                    <i data-lucide="package-check" class="w-6 h-6"></i>
                </div>
                <span class="text-xs text-lime-400 font-bold flex items-center gap-1"><i data-lucide="check-circle" class="w-3 h-3"></i> Done</span>
            </div>
            <h3 class="text-3xl font-bold text-white">{{ $productionStats['siap_kirim'] }}</h3>
            <p class="text-slate-400 text-xs font-bold uppercase mt-1">Siap Kirim</p>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-navy-800">
                <div class="h-full bg-lime-500 w-[90%]"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-navy-900 border border-slate-800 rounded-xl overflow-hidden">
            <div class="p-6 border-b border-slate-800 flex justify-between items-center">
                <h3 class="font-bold text-white flex items-center gap-2">
                    <i data-lucide="alert-octagon" class="w-5 h-5 text-red-500"></i> Prioritas Pengerjaan
                </h3>
                <span class="text-xs text-slate-500">Diurutkan berdasarkan deadline</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-slate-300 text-sm">
                    <thead class="bg-navy-950 text-slate-400 uppercase text-xs font-bold">
                        <tr>
                            <th class="px-6 py-4">Invoice / Desain</th>
                            <th class="px-6 py-4">Item & Qty</th>
                            <th class="px-6 py-4">Deadline</th>
                            <th class="px-6 py-4">Tahap Saat Ini</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse($priorityOrders as $order)
                        <tr class="hover:bg-navy-800/50 transition">
                            <td class="px-6 py-4">
                                <span class="block font-bold text-white">{{ $order['invoice'] }}</span>
                                <a href="#" class="text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1 mt-1">
                                    <i data-lucide="file-down" class="w-3 h-3"></i> Download Desain
                                </a>
                            </td>
                            
                            <td class="px-6 py-4">
                                <p class="text-white font-bold">{{ $order['item'] }}</p>
                                <p class="text-xs text-slate-500">{{ $order['qty'] }} pcs</p>
                            </td>

                            <td class="px-6 py-4">
                                @if($order['deadline'] == 'Hari Ini')
                                    <span class="bg-red-500/20 text-red-400 border border-red-500/30 px-2 py-1 rounded text-xs font-bold uppercase animate-pulse">
                                        {{ $order['deadline'] }}
                                    </span>
                                @else
                                    <span class="bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 px-2 py-1 rounded text-xs font-bold uppercase">
                                        {{ $order['deadline'] }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <span class="flex items-center gap-2 text-slate-300 font-bold text-xs uppercase">
                                    @if($order['status'] == 'Cetak')
                                        <div class="w-2 h-2 rounded-full bg-red-500"></div> Antrean Cetak
                                    @elseif($order['status'] == 'Jahit')
                                        <div class="w-2 h-2 rounded-full bg-yellow-500"></div> Proses Jahit
                                    @endif
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <button class="bg-navy-800 hover:bg-lime-400 hover:text-navy-950 text-slate-300 p-2 rounded-lg transition" title="Update Status">
                                    <i data-lucide="arrow-right-circle" class="w-4 h-4"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">Tidak ada antrean prioritas. Aman!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="bg-navy-900 border border-slate-800 rounded-xl p-6">
                <h3 class="font-bold text-white mb-4 text-sm uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="package-minus" class="w-4 h-4 text-yellow-400"></i> Stok Menipis
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center bg-navy-950 p-3 rounded-lg border border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded bg-slate-800 flex items-center justify-center text-slate-400">
                                <i data-lucide="shirt" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">Kain Combed 30s (Hitam)</p>
                                <p class="text-xs text-red-400">Sisa: 2 Roll</p>
                            </div>
                        </div>
                        <button class="text-xs bg-navy-800 hover:bg-white hover:text-navy-950 text-slate-300 px-2 py-1 rounded border border-slate-700 transition">
                            Req
                        </button>
                    </div>

                    <div class="flex justify-between items-center bg-navy-950 p-3 rounded-lg border border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded bg-slate-800 flex items-center justify-center text-slate-400">
                                <i data-lucide="droplet" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">Tinta Sablon (Putih)</p>
                                <p class="text-xs text-yellow-400">Sisa: 1 Kg</p>
                            </div>
                        </div>
                        <button class="text-xs bg-navy-800 hover:bg-white hover:text-navy-950 text-slate-300 px-2 py-1 rounded border border-slate-700 transition">
                            Req
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-navy-900 border border-slate-800 rounded-xl p-6">
                <h3 class="font-bold text-white mb-4 text-sm uppercase tracking-wider">Catatan Shift</h3>
                <div class="relative pl-4 border-l-2 border-slate-800 space-y-4">
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-slate-600 border-2 border-navy-900"></div>
                        <p class="text-xs text-slate-500 mb-0.5">10:30 AM - Ahmad (QC)</p>
                        <p class="text-sm text-slate-300">"Pesanan #INV-005 ada cacat sablon di 2 pcs, sudah dikembalikan ke bagian cetak."</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-lime-400 border-2 border-navy-900"></div>
                        <p class="text-xs text-slate-500 mb-0.5">09:15 AM - Budi (Jahit)</p>
                        <p class="text-sm text-slate-300">"Mesin jahit no. 3 sudah diperbaiki, bisa dipakai full speed."</p>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-800">
                    <input type="text" placeholder="Tulis catatan..." class="w-full bg-navy-950 border border-slate-700 rounded-lg px-3 py-2 text-white text-xs focus:border-lime-400 focus:outline-none">
                </div>
            </div>

        </div>
    </div>

@endsection