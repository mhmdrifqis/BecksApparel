@extends('layouts.app')

@section('title', 'Keranjang Belanja - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-black text-white mb-8">KERANJANG <span class="text-lime-400">BELANJA</span></h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" 
             x-data="cartManager()" 
             @init="calculateTotal()">
            
            <div class="lg:col-span-2 space-y-4">
                
                @forelse($cart->items as $item)
                @if($item->product)
                <div class="flex flex-col sm:flex-row items-center gap-4 bg-navy-800 p-4 rounded-xl border border-slate-700 relative group"
                     x-data="{ 
                        itemId: {{ $item->id }}, 
                        price: {{ $item->product->price }}, 
                        qty: {{ $item->quantity }}, 
                        max: {{ $item->product->stock }},
                        selected: true
                     }"
                     x-init="
                        items.push({ id: itemId, price: price, qty: qty, selected: selected });
                        $watch('qty', value => updateItem(itemId, 'qty', value));
                        $watch('selected', value => updateItem(itemId, 'selected', value));
                     ">
                    
                    <div class="flex items-center h-5">
                        <input type="checkbox" x-model="selected" class="w-4 h-4 text-lime-500 bg-navy-900 border-slate-600 rounded focus:ring-lime-500 focus:ring-2">
                    </div>

                    <div class="w-24 h-24 bg-navy-900 rounded-lg overflow-hidden flex-shrink-0">
                        @if ($item->design_id && $item->design && $item->design->preview_image)
                            <img src="{{ asset('storage/' . $item->design->preview_image) }}" alt="Custom Design" class="w-full h-full object-contain bg-slate-800">
                        @elseif ($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-800 text-slate-500 text-xs">No Image</div>
                        @endif
                    </div>

                    <div class="flex-1 text-center sm:text-left">
                        <a href="{{ route('products.show', $item->product->slug) }}">
                            <h3 class="text-white font-bold text-lg hover:text-lime-400 transition">{{ $item->product->name }}</h3>
                        </a>
                        <p class="text-slate-400 text-sm">Size: {{ $item->size }}</p>
                        @if($item->design_id)
                            <span class="inline-block px-2 py-0.5 mt-1 text-xs font-bold bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 rounded uppercase tracking-wider">Desain Kustom</span>
                        @endif
                        <p class="text-lime-400 font-bold mt-1">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                    </div>

                    <div class="flex flex-col items-center gap-2">
                        <div class="flex items-center border border-slate-600 rounded-lg overflow-hidden">
                            <button type="button" @click="if(qty > 1) qty--" class="px-3 py-1 text-white hover:bg-slate-700 transition">-</button>
                            <input type="text" x-model="qty" readonly class="w-12 py-1 text-center bg-navy-900 text-white border-none text-sm focus:ring-0">
                            <button type="button" @click="if(qty < max) qty++" class="px-3 py-1 text-white hover:bg-slate-700 transition">+</button>
                        </div>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 text-xs hover:text-red-300 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endif
                @empty
                <div class="bg-navy-800 p-8 rounded-xl border border-slate-700 text-center">
                    <svg class="w-16 h-16 mx-auto text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <h3 class="text-xl font-bold text-white mb-2">Keranjang belanja Anda masih kosong</h3>
                    <p class="text-slate-400 mb-6">Mulai isi keranjang Anda dengan desain apparel terbaik dari kami.</p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-lime-500 text-navy-900 font-bold px-6 py-2 rounded-lg hover:bg-lime-400 transition">Lihat Katalog</a>
                </div>
                @endforelse

                </div>

            <div class="lg:col-span-1">
                <div class="bg-navy-800 p-6 rounded-xl border border-slate-700 sticky top-24">
                    <h3 class="text-white font-bold text-xl mb-6">Ringkasan Belanja</h3>
                    
                    <div class="space-y-3 mb-6 border-b border-slate-700 pb-6">
                        <div class="flex justify-between text-slate-400 text-sm">
                            <span>Total Harga (<span x-text="totalItems"></span> Barang)</span>
                            <span class="text-white font-medium">Rp <span x-text="formatRupiah(subtotal)"></span></span>
                        </div>
                        <div class="flex justify-between text-slate-400 text-sm">
                            <span>Diskon</span>
                            <span class="text-green-400 font-medium">- Rp 0</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-8">
                        <span class="text-white font-bold text-lg">Total Tagihan</span>
                        <span class="text-lime-400 font-black text-2xl">Rp <span x-text="formatRupiah(subtotal)"></span></span>
                    </div>

                    <form action="{{ route('customer.checkout') }}" method="GET" x-ref="checkoutForm" @submit.prevent="proceedToCheckout()">
                        <!-- Hidden inputs akan di-generate oleh AlpineJS sebelum submit -->
                        <button type="submit" class="w-full bg-lime-500 hover:bg-lime-400 text-navy-900 font-black py-4 rounded-lg shadow-lg shadow-lime-500/20 transition transform hover:-translate-y-1" :disabled="totalItems === 0" :class="{ 'opacity-50 cursor-not-allowed transform-none': totalItems === 0 }">
                            CHECKOUT SEKARANG
                        </button>
                    </form>
                    
                    <p class="text-center text-xs text-slate-500 mt-4">
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Transaksi Aman & Terenkripsi
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cartManager', () => ({
            items: [],
            subtotal: 0,
            totalItems: 0,

            updateItem(id, key, value) {
                const index = this.items.findIndex(i => i.id === id);
                if (index !== -1) {
                    this.items[index][key] = value;
                    this.calculateTotal();
                }
            },

            calculateTotal() {
                this.subtotal = 0;
                this.totalItems = 0;
                
                this.items.forEach(item => {
                    if (item.selected) {
                        this.subtotal += (item.price * item.qty);
                        this.totalItems += parseInt(item.qty);
                    }
                });
            },

            proceedToCheckout() {
                if (this.totalItems === 0) return;

                const form = this.$refs.checkoutForm;
                
                // Hapus input hidden lama jika ada
                form.querySelectorAll('input[type="hidden"]').forEach(el => el.remove());

                // Tambahkan input hidden baru untuk barang yang dipilih
                let index = 0;
                this.items.forEach(item => {
                    if (item.selected) {
                        const idInput = document.createElement('input');
                        idInput.type = 'hidden';
                        idInput.name = `selected_items[${index}][id]`;
                        idInput.value = item.id;
                        form.appendChild(idInput);

                        const qtyInput = document.createElement('input');
                        qtyInput.type = 'hidden';
                        qtyInput.name = `selected_items[${index}][qty]`;
                        qtyInput.value = item.qty;
                        form.appendChild(qtyInput);
                        
                        index++;
                    }
                });

                form.submit();
            },

            formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka);
            }
        }))
    })
</script>
@endsection