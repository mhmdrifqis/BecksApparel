@extends('layouts.dashboard')

@section('title', 'Riwayat Invoice & Keuangan')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Invoice & Keuangan</h1>
            <p class="text-slate-400 text-sm">Lihat daftar histori invoice berdasarkan pesanan pelanggan yang lunas atau menunggu verifikasi.</p>
        </div>
    </div>

    <div class="bg-navy-900 border border-slate-800 rounded-xl overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-slate-300">
                <thead class="bg-navy-950 text-slate-400 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">Invoice</th>
                        <th class="px-6 py-4">Waktu Pembayaran</th>
                        <th class="px-6 py-4">Total Tagihan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($orders as $order)
                    <tr class="hover:bg-navy-800/50 transition">
                        <td class="px-6 py-4">
                            <span class="block font-bold text-white">{{ $order->invoice_number }}</span>
                            <span class="text-xs text-slate-500">{{ $order->user->name }}</span>
                        </td>
                        
                        <td class="px-6 py-4">
                            @if($order->payment && $order->payment->paid_at)
                                {{ \Carbon\Carbon::parse($order->payment->paid_at)->format('d M Y H:i') }}
                            @else
                                <span class="text-slate-500 italic">Belum dibayar</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 font-mono text-lime-400 font-bold">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            @if($order->payment_status == 'paid')
                                <span class="px-2 py-1 rounded text-xs font-bold bg-lime-500/10 text-lime-400 border border-lime-500/20">Lunas</span>
                            @elseif($order->payment_status == 'awaiting_verification')
                                <span class="px-2 py-1 rounded text-xs font-bold bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Cek Bukti</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-bold bg-slate-700 text-slate-400 border border-slate-600">{{ $order->payment_status }}</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.orders.invoice', $order->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-navy-800 hover:bg-lime-400 hover:text-navy-950 text-slate-300 rounded-lg transition text-xs font-bold">
                                <i data-lucide="file-text" class="w-3 h-3"></i> Detail Invoice
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <i data-lucide="file-off" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                            <p>Belum ada rekaman invoice untuk ditampilkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $orders->links() }}
        </div>
    </div>

@endsection
