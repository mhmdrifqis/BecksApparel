@extends('layouts.app')

@section('title', 'Invoice & Pembayaran - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl md:text-3xl font-black text-white">RIWAYAT <span class="text-lime-400">INVOICE</span></h1>
            <button class="text-sm text-slate-400 hover:text-white flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
        </div>

        <div class="bg-navy-800 rounded-xl border border-slate-700 overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-navy-900 text-slate-400 uppercase text-xs font-bold border-b border-slate-700">
                        <tr>
                            <th class="px-6 py-4">No. Invoice</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Total Belanja</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @forelse($orders as $order)
                        <tr class="hover:bg-navy-700/50 transition">
                            <td class="px-6 py-4 font-medium text-white">{{ $order->invoice_number }}</td>
                            <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 font-bold text-white">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($order->payment_status === 'paid')
                                    <span class="bg-green-500/10 text-green-400 border border-green-500/20 px-2.5 py-0.5 rounded-full text-xs font-bold uppercase block w-fit">
                                        LUNAS
                                    </span>
                                @elseif($order->payment_status === 'pending')
                                    <span class="bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-2.5 py-0.5 rounded-full text-xs font-bold uppercase block w-fit">
                                        PENDING
                                    </span>
                                @else
                                    <span class="bg-slate-700/50 text-slate-300 border border-slate-600 px-2.5 py-0.5 rounded-full text-xs font-bold uppercase block w-fit">
                                        {{ $order->payment_status }}
                                    </span>
                                @endif
                                
                                @if($order->tracking_number)
                                    <div class="mt-2 text-xs">
                                        <span class="text-slate-500 block">No. Resi:</span>
                                        <span class="text-lime-400 font-mono">{{ $order->tracking_number }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($order->payment_status === 'paid')
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="text-lime-400 hover:text-lime-300 font-bold text-xs border border-lime-400 rounded px-3 py-1.5 hover:bg-lime-400 hover:text-navy-900 transition mt-2 inline-block">
                                    Lihat Detail & Unduh
                                </a>
                                @else
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="text-white bg-lime-600 hover:bg-lime-500 font-bold text-xs rounded px-3 py-1.5 transition mt-2 inline-block">
                                    Bayar Sekarang
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <i data-lucide="file-text" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                                <p>Belum ada riwayat invoice.</p>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-slate-700 flex justify-between items-center text-xs text-slate-400">
                <span>Menampilkan 2 dari 2 data</span>
                <div class="flex gap-2">
                    <button class="px-3 py-1 bg-navy-900 rounded border border-slate-600 hover:bg-slate-700">Prev</button>
                    <button class="px-3 py-1 bg-navy-900 rounded border border-slate-600 hover:bg-slate-700">Next</button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection