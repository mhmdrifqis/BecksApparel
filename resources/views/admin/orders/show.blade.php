@extends('layouts.dashboard')

@section('title', 'Detail Transaksi #' . $order->invoice_number)

@section('content')

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.orders.index') }}" class="bg-navy-800 text-slate-300 hover:text-white p-2 rounded-lg transition border border-slate-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Invoice: {{ $order->invoice_number }}</h1>
            <p class="text-slate-400 text-sm">Detail pesanan dari {{ $order->user->name }}</p>
        </div>
        
        <div class="ml-auto">
            @php
                // Generate WA Notification Message
                $statusMap = [
                    'pending' => 'Sedang Menunggu Pembayaran/Verifikasi',
                    'production' => 'Sedang Diproduksi (Dijahit)',
                    'shipped' => 'Telah Dikirim' . ($order->tracking_number ? ' dengan No. Resi: ' . $order->tracking_number : ''),
                    'completed' => 'Telah Selesai',
                    'cancelled' => 'Dibatalkan',
                    'returned' => 'Diretur'
                ];
                
                $statusText = $statusMap[$order->order_status] ?? strtoupper($order->order_status);
                
                $waMessage = "Halo " . $order->user->name . ",\n\nIni adalah informasi pembaruan status pesanan Anda di Becks Apparel.\n\nNomor Invoice: *" . $order->invoice_number . "*\nStatus Pesanan Saat Ini: *" . $statusText . "*\n\nUntuk melihat rincian serta mengunduh/mencetak invoice lengkap Anda, klik tautan berikut:\n" . route('customer.orders.show', $order->id) . "\n\nTerima kasih telah berbelanja!";
                
                $rawPhone = $order->user->phone ?? '';
                $phone = preg_replace('/[^0-9]/', '', $rawPhone);
                if (str_starts_with($phone, '0')) {
                    $phone = '62' . substr($phone, 1);
                } elseif (str_starts_with($phone, '8')) {
                    $phone = '62' . $phone;
                }
                
                $waUrl = "https://wa.me/" . $phone . "?text=" . urlencode($waMessage);
            @endphp
            <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-4 py-2 rounded-lg transition shadow-lg shadow-emerald-500/20">
                <i data-lucide="message-circle" class="w-4 h-4"></i> Info Update via WA
            </a>
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
                            @if($item->design_id && $item->design && $item->design->preview_image)
                                <img src="{{ asset('storage/' . $item->design->preview_image) }}" class="w-full h-full object-contain bg-slate-800">
                            @elseif($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-slate-500"><i data-lucide="image" class="w-6 h-6"></i></div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="text-white font-bold">{{ $item->product->name }}</h4>
                            <div class="text-xs text-slate-400 mt-1 space-y-1">
                                <p>Size: <span class="text-white">{{ $item->size ?? '-' }}</span></p>
                                <p>Qty: <span class="text-white">{{ $item->quantity }}</span></p>
                                @if($item->design_id)
                                    <div class="mt-2 text-indigo-400 font-bold bg-indigo-500/10 inline-block px-2 py-1 rounded border border-indigo-500/20">
                                        <i data-lucide="pen-tool" class="w-3 h-3 inline mr-1"></i> Desain Kustom 
                                        <a href="{{ asset('storage/' . $item->design->preview_image) }}" target="_blank" class="ml-2 underline hover:text-indigo-300">Lihat Full</a>
                                    </div>
                                @endif
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
                    <span class="text-2xl font-bold text-lime-400">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="bg-navy-900 border border-slate-800 rounded-xl p-6">
                <h3 class="text-lime-400 font-bold text-sm uppercase tracking-wider mb-4 border-b border-slate-800 pb-2">Informasi Pengiriman</h3>
                <div class="text-slate-300 text-sm space-y-2">
                    <p><span class="text-slate-500 block text-xs uppercase mb-1">Penerima</span> <span class="font-bold text-white">{{ $order->user->name }}</span></p>
                    <p><span class="text-slate-500 block text-xs uppercase mb-1">Telepon</span> {{ $order->user->nomor_telepon }}</p>
                    <p><span class="text-slate-500 block text-xs uppercase mb-1">Alamat Lengkap</span> {{ $order->shipping_address }}</p>
                    
                    @if($order->tracking_number)
                        <div class="mt-4 p-3 bg-blue-500/10 border border-blue-500/20 rounded-lg">
                            <p class="text-blue-400 text-xs font-bold uppercase">Nomor Resi Pengiriman</p>
                            <p class="text-white font-mono text-lg tracking-wider">{{ $order->tracking_number }}</p>
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
                
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">Status Pesanan</label>
                            <select name="order_status" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-3 py-2 text-white focus:border-lime-400 focus:outline-none">
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Bayar)</option>
                                <option value="production" {{ $order->order_status == 'production' ? 'selected' : '' }}>Production (Sedang Dijahit)</option>
                                <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
                                <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                                <option value="returned" {{ $order->order_status == 'returned' ? 'selected' : '' }}>Returned (Diretur)</option>
                            </select>
                        </div>

                        <div x-data="{ showResi: '{{ $order->order_status }}' === 'shipped' || '{{ $order->order_status }}' === 'completed' }">
                            <label class="block text-slate-400 text-xs font-bold mb-2 uppercase">Nomor Resi (Opsional)</label>
                            <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" 
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
                
                @if($order->payment && $order->payment->transaction_id)
                    <div class="relative group mb-4">
                        <img src="{{ asset('storage/' . $order->payment->transaction_id) }}" class="w-full rounded-lg border border-slate-700 hover:opacity-90 transition cursor-pointer" onclick="window.open(this.src, '_blank')">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition pointer-events-none">
                            <span class="bg-black/70 text-white text-xs px-2 py-1 rounded">Klik untuk perbesar</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-2 text-center mb-4">Diupload: {{ $order->payment->updated_at->format('d M Y H:i') }}</p>
                    
                    @if($order->payment_status === 'awaiting_verification')
                        <div class="flex gap-2">
                            <form action="{{ route('admin.orders.verify', $order->id) }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="w-full bg-lime-400 hover:bg-lime-500 text-navy-950 font-bold py-2 rounded-lg transition text-sm">
                                    Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.orders.verify', $order->id) }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded-lg transition text-sm">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @elseif($order->payment_status === 'paid')
                        <div class="bg-lime-500/10 border border-lime-500/20 text-lime-400 rounded-lg p-3 text-center text-sm font-bold">
                            Pembayaran Telah Disetujui
                        </div>
                    @elseif($order->payment_status === 'rejected')
                        <div class="bg-red-500/10 border border-red-500/20 text-red-400 rounded-lg p-3 text-center text-sm font-bold">
                            Pembayaran Ditolak
                        </div>
                    @endif
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