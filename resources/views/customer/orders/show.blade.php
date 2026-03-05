@extends('layouts.app')

@section('title', 'Invoice ' . $order->invoice_number)

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('customer.orders') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-lime-400 font-bold text-sm uppercase tracking-wider transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Pesanan Saya
            </a>
        </div>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-white">INVOICE</h1>
                <p class="text-slate-400 text-lg">#{{ $order->invoice_number }}</p>
            </div>
            <div class="flex gap-3">
                @if($order->payment_status === 'pending')
                    <span class="bg-yellow-500/20 text-yellow-500 border border-yellow-500/50 px-4 py-2 rounded-full font-bold text-sm tracking-widest uppercase">Menunggu Pembayaran</span>
                @elseif($order->payment_status === 'paid')
                    <span class="bg-lime-500/20 text-lime-400 border border-lime-500/50 px-4 py-2 rounded-full font-bold text-sm tracking-widest uppercase">Lunas</span>
                @else
                    <span class="bg-red-500/20 text-red-400 border border-red-500/50 px-4 py-2 rounded-full font-bold text-sm tracking-widest uppercase">{{ $order->payment_status }}</span>
                @endif
            </div>
        </div>

        @if(session('status'))
            <div class="bg-lime-500/20 border border-lime-500/30 text-lime-400 px-6 py-4 rounded-xl mb-8 font-medium">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-navy-800 rounded-2xl border border-slate-700 overflow-hidden shadow-xl">
            <!-- Info Section -->
            <div class="grid grid-cols-1 sm:grid-cols-2 p-8 gap-8 border-b border-slate-700">
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Ditagihkan Kepada:</h3>
                    <p class="text-white font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-slate-300 mt-2 whitespace-pre-line">{{ $order->shipping_address }}</p>
                </div>
                <div class="sm:text-right">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Pesanan:</h3>
                    <p class="text-white font-medium mb-6">{{ $order->created_at->translatedFormat('l, d F Y H:i') }}</p>
                    
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Status Pesanan:</h3>
                    <p class="text-white font-medium capitalize">{{ $order->order_status }}</p>
                </div>
            </div>

            <!-- Items Section -->
            <div class="p-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-700">
                                <th class="pb-4 pt-2 px-4 text-sm font-bold text-slate-400 uppercase tracking-widest">Produk</th>
                                <th class="pb-4 pt-2 px-4 text-sm font-bold text-slate-400 uppercase tracking-widest text-center">Qty</th>
                                <th class="pb-4 pt-2 px-4 text-sm font-bold text-slate-400 uppercase tracking-widest text-right">Harga</th>
                                <th class="pb-4 pt-2 px-4 text-sm font-bold text-slate-400 uppercase tracking-widest text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @php $subtotalRaw = 0; @endphp
                            @foreach($order->items as $item)
                            @php $subtotalRaw += ($item->price * $item->quantity); @endphp
                            <tr class="group">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-4">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="img" class="w-12 h-12 rounded object-cover border border-slate-700">
                                        @endif
                                        <div>
                                            <p class="text-white font-bold">{{ $item->product ? $item->product->name : 'Produk Dihapus' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center text-slate-300">{{ $item->quantity }}</td>
                                <td class="py-4 px-4 text-right text-slate-300">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="py-4 px-4 text-right text-white font-medium">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="mt-8 flex justify-end">
                    <div class="w-full sm:w-1/2 lg:w-1/3 space-y-3">
                        <div class="flex justify-between text-slate-400 text-sm">
                            <span>Subtotal</span>
                            <span class="text-white">Rp {{ number_format($subtotalRaw, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-slate-700 pt-3 flex justify-between items-center mt-3">
                            <span class="text-white font-bold text-lg">Total Tagihan</span>
                            <span class="text-lime-400 font-black text-2xl">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Action -->
            @if($order->payment_status === 'pending')
            <div class="bg-navy-950 p-8 border-t border-slate-700">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-6">
                    <div class="text-center sm:text-left">
                        <h3 class="text-white font-bold mb-1">Segera Lakukan Pembayaran</h3>
                        <p class="text-slate-400 text-sm">Transfer sejumlah <span class="text-lime-400 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span> ke rekening BCA 123456789 a.n PT Becks Apparel.</p>
                    </div>
                </div>

                <form action="{{ route('customer.payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-4 bg-navy-900 border border-slate-700 p-4 rounded-xl">
                    @csrf
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Upload Bukti Transfer (JPG/PNG)</label>
                        <input type="file" name="payment_proof" accept="image/*" required class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-lime-500/10 file:text-lime-400 hover:file:bg-lime-500/20">
                        @error('payment_proof')
                            <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full sm:w-auto mt-4 sm:mt-0 px-8 py-3 bg-lime-500 hover:bg-lime-400 text-navy-900 font-black rounded-lg shadow-lg shadow-lime-500/20 transition transform hover:-translate-y-1 self-end">
                        KIRIM BUKTI
                    </button>
                </form>
            </div>
            @elseif($order->payment_status === 'awaiting_verification')
            <div class="bg-navy-950 p-8 border-t border-slate-700 text-center">
                <i data-lucide="clock" class="w-12 h-12 text-yellow-500 mx-auto mb-4"></i>
                <h3 class="text-white font-bold text-xl mb-2">Bukti Pembayaran Sedang Diverifikasi</h3>
                <p class="text-slate-400">Terima kasih telah melakukan pembayaran. Tim admin kami sedang mengecek mutasi masuk. Pesanan Anda akan diproses setelah pembayaran terverifikasi.</p>
            </div>
            @endif

        </div>

    </div>
</div>
@endsection
