@extends('layouts.dashboard')

@section('title', 'Dashboard Pelanggan')

@section('content')

    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Halo, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-slate-400">Selamat datang kembali di Becks Apparel. Cek status pesananmu di sini.</p>
        </div>
        <a href="#" class="bg-lime-400 hover:bg-lime-500 text-navy-950 font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition shadow-lg shadow-lime-400/20">
            <i data-lucide="plus" class="w-4 h-4"></i> Pesan Baru
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            
            @php 
                $activeOrder = $myOrders[1] ?? null; // Simulasi order yang sedang diproses
            @endphp

            @if($activeOrder)
            <div class="bg-navy-900 border border-slate-800 rounded-xl p-6 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-lime-400/10 rounded-full blur-3xl"></div>

                <div class="flex justify-between items-start mb-6 relative z-10">
                    <div>
                        <span class="text-lime-400 font-bold text-xs uppercase tracking-wider mb-1 block">Pesanan Sedang Diproses</span>
                        <h3 class="text-xl font-bold text-white">{{ $activeOrder['invoice'] }}</h3>
                        <p class="text-slate-400 text-sm mt-1">Estimasi Selesai: <span class="text-white font-bold">3 Hari Lagi</span></p>
                    </div>
                    <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-3 py-1 rounded-full text-xs font-bold uppercase">
                        {{ $activeOrder['status'] }}
                    </span>
                </div>

                <div class="relative mt-8 mb-4">
                    <div class="absolute top-1/2 left-0 w-full h-1 bg-navy-800 -translate-y-1/2 rounded"></div>
                    <div class="absolute top-1/2 left-0 w-1/2 h-1 bg-lime-400 -translate-y-1/2 rounded"></div> <div class="relative flex justify-between z-10">
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-lime-400 text-navy-950 flex items-center justify-center border-4 border-navy-900 shadow-lg">
                                <i data-lucide="check" class="w-4 h-4 font-bold"></i>
                            </div>
                            <span class="text-xs font-bold text-lime-400">Bayar</span>
                        </div>

                        <div class="flex flex-col items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-lime-400 text-navy-950 flex items-center justify-center border-4 border-navy-900 shadow-lg animate-pulse">
                                <i data-lucide="scissors" class="w-4 h-4"></i>
                            </div>
                            <span class="text-xs font-bold text-white">Produksi</span>
                        </div>

                        <div class="flex flex-col items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-navy-800 text-slate-500 flex items-center justify-center border-4 border-navy-900">
                                <i data-lucide="truck" class="w-4 h-4"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-500">Kirim</span>
                        </div>

                        <div class="flex flex-col items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-navy-800 text-slate-500 flex items-center justify-center border-4 border-navy-900">
                                <i data-lucide="package" class="w-4 h-4"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-500">Terima</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-navy-900 border border-slate-800 rounded-xl overflow-hidden">
                <div class="p-6 border-b border-slate-800 flex justify-between items-center">
                    <h3 class="font-bold text-white">Riwayat Pesanan Saya</h3>
                    <a href="#" class="text-xs text-lime-400 hover:text-white transition">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-slate-300 text-sm">
                        <thead class="bg-navy-950 text-slate-400 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4">Invoice</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($myOrders as $order)
                            <tr class="hover:bg-navy-800/50 transition">
                                <td class="px-6 py-4 font-bold text-white">{{ $order['invoice'] }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $order['date'] }}</td>
                                <td class="px-6 py-4 text-lime-400 font-mono">Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($order['status'] == 'Selesai')
                                        <span class="px-2 py-1 bg-lime-500/10 text-lime-400 border border-lime-500/20 rounded text-xs font-bold">Selesai</span>
                                    @else
                                        <span class="px-2 py-1 bg-blue-500/10 text-blue-400 border border-blue-500/20 rounded text-xs font-bold">{{ $order['status'] }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-slate-400 hover:text-white mx-1"><i data-lucide="eye" class="w-4 h-4"></i></button>
                                    <button class="text-slate-400 hover:text-lime-400 mx-1"><i data-lucide="download" class="w-4 h-4"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">Belum ada riwayat pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="bg-gradient-to-br from-red-500/20 to-navy-900 border border-red-500/30 rounded-xl p-6">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-red-500 text-white rounded-lg shadow-lg shadow-red-500/20">
                        <i data-lucide="alert-circle" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-white">Menunggu Pembayaran</h4>
                        <p class="text-xs text-slate-300 mt-1 mb-3">Invoice #INV-2026-NEW belum dibayar. Segera selesaikan agar pesanan diproses.</p>
                        <button class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded-lg text-sm transition">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-navy-900 border border-slate-800 rounded-xl p-6 text-center">
                <div class="w-16 h-16 bg-navy-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-700">
                    <i data-lucide="message-circle-question" class="w-8 h-8 text-lime-400"></i>
                </div>
                <h4 class="font-bold text-white mb-2">Butuh Bantuan?</h4>
                <p class="text-sm text-slate-400 mb-4">CS kami atau Chatbot Becks siap membantumu 24/7.</p>
                <button class="w-full border border-slate-600 hover:bg-navy-800 text-slate-300 font-bold py-2 rounded-lg text-sm transition flex items-center justify-center gap-2">
                    <i data-lucide="message-square" class="w-4 h-4"></i> Hubungi CS
                </button>
            </div>

        </div>
    </div>

@endsection