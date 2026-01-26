@extends('layouts.dashboard')

@section('title', 'Daftar Transaksi')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Transaksi Pesanan</h1>
            <p class="text-slate-400 text-sm">Pantau semua pesanan masuk, produksi, hingga pengiriman.</p>
        </div>
    </div>

    <div class="bg-navy-900 border border-slate-800 rounded-xl overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-slate-300">
                <thead class="bg-navy-950 text-slate-400 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">Invoice</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status Bayar</th>
                        <th class="px-6 py-4">Status Pesanan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($orders as $order)
                    <tr class="hover:bg-navy-800/50 transition">
                        <td class="px-6 py-4">
                            <span class="block font-bold text-white text-sm">{{ $order->invoice_number }}</span>
                            <span class="text-xs text-slate-500">{{ $order->created_at->format('d M Y H:i') }}</span>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-navy-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-lime-400">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white">{{ $order->user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $order->user->email }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 font-mono text-lime-400 font-bold">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            @if($order->payment_status == 'paid')
                                <span class="px-2 py-1 rounded text-xs font-bold bg-lime-500/10 text-lime-400 border border-lime-500/20">Lunas</span>
                            @elseif($order->payment_status == 'pending_confirmation')
                                <span class="px-2 py-1 rounded text-xs font-bold bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Cek Bukti</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-bold bg-slate-700 text-slate-400 border border-slate-600">Belum Bayar</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'text-slate-400 bg-slate-800',
                                    'paid' => 'text-blue-400 bg-blue-500/10 border-blue-500/20',
                                    'production' => 'text-purple-400 bg-purple-500/10 border-purple-500/20',
                                    'shipping' => 'text-cyan-400 bg-cyan-500/10 border-cyan-500/20',
                                    'completed' => 'text-lime-400 bg-lime-500/10 border-lime-500/20',
                                    'cancelled' => 'text-red-400 bg-red-500/10 border-red-500/20',
                                    'returned' => 'text-orange-400 bg-orange-500/10 border-orange-500/20',
                                ];
                                $colorClass = $statusColors[$order->status] ?? 'text-slate-400';
                            @endphp
                            <span class="px-2 py-1 rounded text-xs font-bold border {{ $colorClass }} uppercase">
                                {{ $order->status }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.transactions.show', $order->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-navy-800 hover:bg-lime-400 hover:text-navy-950 text-slate-300 rounded-lg transition text-xs font-bold">
                                <i data-lucide="eye" class="w-3 h-3"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <i data-lucide="shopping-cart" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                            <p>Belum ada transaksi masuk.</p>
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