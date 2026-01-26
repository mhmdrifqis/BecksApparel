@extends('layouts.dashboard')

@section('title', 'Detail Transaksi #' . $order->invoice_number)

@section('content')

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.transactions.index') }}" class="bg-navy-800 text-slate-300 hover:text-white p-2 rounded-lg transition border border-slate-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Invoice: {{ $order->invoice_number }}</h1>
            <p class="text-slate-400 text-sm">Detail pesanan dari {{ $order->user->name }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-lime-400/10 border border-lime-400/20 text-lime-400 rounded-lg flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-navy-900 border border-slate-800 rounded-xl p-6">
                <h3 class="text-lime-400 font-bold text-sm uppercase tracking-wider mb-4 border-b border-slate-800 pb-2">Item Pesanan</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 bg-navy-800 rounded-lg overflow-hidden border border-slate-700 flex-shrink-0">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-slate-500"><i data-lucide="image" class="w-6 h-6"></i></div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="text-white font-bold">{{ $item->product->name }}</h4>
                            <div class="text-xs text-slate-400 mt-1 space-y-1">
                                <p>Size: <span class="text-white">{{ $item->size ?? '-' }}</span></p>
                                <p>Qty: <span class="text-white">{{ $item->quantity }}x</span></p>
                                @if($item->custom_note)
                                    <p class="text-yellow-400 italic">"{{ $item->custom_note }}"</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <p class="text-lime-400 font-mono font-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-500">@ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="flex justify-between items-center mt-6 pt-4 border-t border-slate-800">
                    <span class="text-slate-300 font-bold">Total Transaksi</span>
                    <span class="text-2xl font-bold text-lime-400">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-navy-900 border border-slate-800 rounded-xl p-6">
                <h3 class="text-lime-400 font-bold text-sm uppercase tracking-wider mb-4 border-b border-slate-800 pb-2">Informasi Pengiriman</h3>
                <div class="text-slate-300 text-sm space-y-2">
                    <p><span class="text-slate-500 block text-xs uppercase mb-1">Penerima</span> <span class="font-bold text-white">{{ $order->user->name }}</span></p>
                    <p><span class="text-slate-500 block text-xs uppercase mb-1">Telepon</span> {{ $order->user->nomor_telepon }}</p>
                    <p><span class="text-slate-500 block text-xs uppercase mb-1">Alamat Lengkap</span> {{ $order->shipping_address }}</p>
                    
                    @if($order->resi_number)
                        <div class="mt-4 p-3 bg-blue-500/10 border border-blue-500/20 rounded-lg">
                            <p class="text-blue-400 text-xs font-bold uppercase">Nomor Resi Pengiriman</p>
                            <p class="text-white font-mono text-lg tracking-wider">{{ $order->resi_number }}</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <div class="space-y-6">
            
            <div class="bg-navy-900 border border-slate-800 rounded-xl p-6 shadow-xl">
                <h3 class="text-white font-bold mb-4 flex items-center gap-2">
                    <i data-lucide="settings" class="w-5 h-5 text-lime-400"></i> Update Status
                </h3>
                
                <form action="{{ route('admin.transactions.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">Status Pesanan</label>
                            <select name="status" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-3 py-2 text-white focus:border-lime-400 focus:outline-none">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Bayar)</option>
                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid (Sudah Bayar)</option>
                                <option value="production" {{ $order->status == 'production' ? 'selected' : '' }}>Production (Sedang Dijahit)</option>
                                <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Shipping (Dikirim)</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                            </select>
                        </div>

                        <div x-data="{ showResi: '{{ $order->status }}' === 'shipping' || '{{ $order->status }}' === 'completed' }">
                            <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">Nomor Resi (Opsional)</label>
                            <input type="text" name="resi_number" value="{{ $order->resi_number }}" 
                                   class="w-full bg-navy-950 border border-slate-700 rounded-lg px-3 py-2 text-white focus:border-lime-400 focus:outline-none"
                                   placeholder="Contoh: JNE-12345678">
                        </div>

                        <button type="submit" class="w-full bg-lime-400 hover:bg-lime-500 text-navy-950 font-bold py-3 rounded-lg transition shadow-lg shadow-lime-400/20">
                            SIMPAN PERUBAHAN
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-navy-900 border border-slate-800 rounded-xl p-6">
                <h3 class="text-slate-400 font-bold text-xs uppercase mb-4">Bukti Pembayaran</h3>
                
                @if($order->payment_proof)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full rounded-lg border border-slate-700 hover:opacity-90 transition cursor-pointer" onclick="window.open(this.src, '_blank')">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition pointer-events-none">
                            <span class="bg-black/70 text-white text-xs px-2 py-1 rounded">Klik untuk perbesar</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-2 text-center">Diupload: {{ $order->updated_at->format('d M Y H:i') }}</p>
                @else
                    <div class="h-32 bg-navy-950 border border-slate-700 border-dashed rounded-lg flex flex-col items-center justify-center text-slate-500">
                        <i data-lucide="image-off" class="w-8 h-8 mb-2 opacity-50"></i>
                        <span class="text-xs">Belum ada bukti bayar</span>
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection