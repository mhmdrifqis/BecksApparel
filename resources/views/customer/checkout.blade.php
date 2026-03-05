@extends('layouts.app')

@section('title', 'Checkout - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-black text-white mb-8">PEMBAYARAN & <span class="text-lime-400">PENGIRIMAN</span></h1>

        <form action="{{ route('customer.checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Kiri: Data Pengiriman -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-navy-800 p-6 rounded-xl border border-slate-700">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-5 h-5 text-lime-400"></i>
                            Alamat Pengiriman
                        </h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-1">Nama Lengkap (Penerima) <span class="text-red-400">*</span></label>
                                <input type="text" name="recipient_name" value="{{ auth()->user()->name }}" required class="w-full bg-navy-950 border border-slate-700 rounded-lg p-3 text-white focus:ring-lime-400 focus:border-lime-400">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-1">Nomor Telepon / WhatsApp <span class="text-red-400">*</span></label>
                                <input type="text" name="recipient_phone" value="{{ auth()->user()->phone ?? '' }}" required class="w-full bg-navy-950 border border-slate-700 rounded-lg p-3 text-white focus:ring-lime-400 focus:border-lime-400">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-1">Alamat Lengkap <span class="text-red-400">*</span></label>
                                <textarea name="shipping_address" rows="4" required placeholder="Nama Jalan, Gedung, No. Rumah, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos..." class="w-full bg-navy-950 border border-slate-700 rounded-lg p-3 text-white focus:ring-lime-400 focus:border-lime-400"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-1">Catatan Tambahan (Opsional)</label>
                                <textarea name="notes" rows="2" placeholder="Catatan untuk penjual atau kurir, misal: titip di pos satpam..." class="w-full bg-navy-950 border border-slate-700 rounded-lg p-3 text-white focus:ring-lime-400 focus:border-lime-400"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-navy-800 p-6 rounded-xl border border-slate-700">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <i data-lucide="package" class="w-5 h-5 text-lime-400"></i>
                            Barang yang Dibeli
                        </h2>
                        
                        <div class="space-y-4 divide-y divide-slate-700/50">
                            @foreach($cart->items as $item)
                                @if($item->product)
                                <div class="flex items-center gap-4 py-4 first:pt-0 last:pb-0">
                                    <div class="w-20 h-20 bg-navy-950 rounded-lg overflow-hidden flex-shrink-0 border border-slate-700">
                                        @if ($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-white font-bold">{{ $item->product->name }}</h3>
                                        <p class="text-slate-400 text-sm">Size: {{ $item->size }}</p>
                                        <p class="text-sm font-medium text-slate-300 mt-1">Rp {{ number_format($item->product->price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lime-400 font-bold">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>

                <!-- Kanan: Ringkasan -->
                <div class="lg:col-span-1 border border-slate-700 bg-navy-800 rounded-xl p-6 h-fit sticky top-24">
                    <h3 class="text-white font-bold text-xl mb-6">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-3 mb-6 border-b border-slate-700 pb-6">
                        <div class="flex justify-between text-slate-400 text-sm">
                            <span>Total Harga ({{ $cart->items->sum('quantity') }} Barang)</span>
                            <span class="text-white font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-8">
                        <span class="text-white font-bold text-lg">Total Tagihan</span>
                        <span class="text-lime-400 font-black text-2xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="w-full bg-lime-500 hover:bg-lime-400 text-navy-900 font-black py-4 rounded-lg shadow-lg shadow-lime-500/20 transition transform hover:-translate-y-1">
                        BUAT PESANAN
                    </button>
                    
                    <p class="text-center text-xs text-slate-500 mt-4 leading-relaxed">
                        Dengan menekan tombol Buat Pesanan, Anda menyetujui Syarat & Ketentuan yang berlaku.
                    </p>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
