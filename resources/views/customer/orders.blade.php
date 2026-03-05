@extends('layouts.app')

@section('title', 'Pesanan Saya - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-black text-white">PESANAN <span class="text-lime-400">SAYA</span></h1>
                <p class="text-slate-400 text-sm mt-1">Pantau status produksi dan pengiriman pesananmu di sini.</p>
            </div>
            
            <div class="bg-navy-800 p-1 rounded-lg inline-flex overflow-x-auto">
                <button class="px-4 py-2 text-sm font-bold text-navy-900 bg-lime-400 rounded shadow-sm transition">Semua</button>
                <button class="px-4 py-2 text-sm font-bold text-slate-400 hover:text-white transition">Menunggu Bayar</button>
                <button class="px-4 py-2 text-sm font-bold text-slate-400 hover:text-white transition">Diproses</button>
                <button class="px-4 py-2 text-sm font-bold text-slate-400 hover:text-white transition">Dikirim</button>
            </div>
        </div>

        <div class="space-y-6">

            @forelse($orders as $order)
            <div class="bg-navy-800 border border-slate-700 rounded-xl overflow-hidden hover:border-lime-400/50 transition duration-300">
                <div class="bg-navy-900/50 px-6 py-4 border-b border-slate-700 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4 text-sm">
                        <span class="font-bold text-white">{{ $order->invoice_number }}</span>
                        <span class="text-slate-500">|</span>
                        <span class="text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        @if($order->payment_status === 'pending')
                            <span class="bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                                Menunggu Pembayaran
                            </span>
                        @elseif($order->payment_status === 'awaiting_verification')
                            <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                                Menunggu Verifikasi
                            </span>
                        @elseif($order->payment_status === 'paid')
                            <span class="bg-lime-500/10 text-lime-400 border border-lime-500/20 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                                Lunas
                            </span>
                        @else
                            <span class="bg-red-500/10 text-red-400 border border-red-500/20 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                                {{ $order->payment_status }}
                            </span>
                        @endif
                        
                        <span class="ml-2 bg-slate-700/50 text-slate-300 border border-slate-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                            {{ $order->order_status }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-6">
                        @php $firstItem = $order->items->first(); @endphp
                        
                        @if($firstItem && $firstItem->product && $firstItem->product->image)
                        <div class="w-24 h-24 flex-shrink-0 bg-navy-900 rounded-md border border-slate-700 overflow-hidden">
                            <img src="{{ asset('storage/' . $firstItem->product->image) }}" alt="Produk" class="w-full h-full object-cover">
                        </div>
                        @else
                        <div class="w-24 h-24 flex-shrink-0 bg-navy-900 rounded-md border border-slate-700 overflow-hidden flex items-center justify-center text-xs text-slate-500">
                            No Image
                        </div>
                        @endif

                        <div class="flex-1">
                            @if($firstItem && $firstItem->product)
                                <h3 class="text-lg font-bold text-white mb-1">{{ $firstItem->product->name }}</h3>
                                <div class="text-xs text-slate-500 space-y-1">
                                    <p>Size: {{ $firstItem->size }} x {{ $firstItem->quantity }}</p>
                                </div>
                                @if($order->items->count() > 1)
                                    <p class="text-sm text-slate-400 italic mt-2">+ {{ $order->items->count() - 1 }} produk lainnya</p>
                                @endif
                            @else
                                <h3 class="text-lg font-bold text-slate-400 mb-1">Produk Tidak Tersedia</h3>
                            @endif
                        </div>

                        <div class="flex flex-row md:flex-col justify-between items-center md:items-end gap-4 border-t md:border-t-0 border-slate-700 pt-4 md:pt-0 mt-4 md:mt-0">
                            <div class="text-right">
                                <p class="text-xs text-slate-400">Total Belanja</p>
                                <p class="text-xl font-bold text-lime-400">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                            
                            <div class="flex gap-2 w-full md:w-auto">
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="flex-1 md:flex-none border border-slate-500 text-slate-300 hover:text-white hover:border-white font-bold py-2 px-6 rounded transition text-sm text-center">
                                    Lihat Detail
                                </a>
                                @if($order->payment_status === 'pending')
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="flex-1 md:flex-none bg-lime-500 hover:bg-lime-400 text-navy-900 font-bold py-2 px-6 rounded transition text-center text-sm">
                                    Bayar Sekarang
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-16 bg-navy-800 rounded-xl border border-slate-700">
                <i data-lucide="shopping-bag" class="w-16 h-16 text-slate-600 mx-auto mb-4"></i>
                <h3 class="text-xl font-bold text-white mb-2">Belum ada pesanan</h3>
                <p class="text-slate-400 mb-6">Anda belum pernah melakukan pemesanan apapun.</p>
                <a href="{{ route('customer.products.index') }}" class="inline-block bg-lime-500 hover:bg-lime-400 text-navy-900 font-bold py-3 px-8 rounded-lg shadow-lg">Belanja Sekarang</a>
            </div>
            @endforelse

            </div>

    </div>
</div>
@endsection