@extends('layouts.app')

@section('title', 'Keranjang Belanja - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-black text-white mb-8">KERANJANG <span class="text-lime-400">BELANJA</span></h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-4">
                
                <div class="flex flex-col sm:flex-row items-center gap-4 bg-navy-800 p-4 rounded-xl border border-slate-700 relative group">
                    <div class="flex items-center h-5">
                        <input type="checkbox" checked class="w-4 h-4 text-lime-500 bg-navy-900 border-slate-600 rounded focus:ring-lime-500 focus:ring-2">
                    </div>

                    <div class="w-24 h-24 bg-navy-900 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="https://placehold.co/150x150/1a202c/FFF?text=Jersey" alt="Produk" class="w-full h-full object-cover">
                    </div>

                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="text-white font-bold text-lg">Jersey Futsal Custom - Full Print</h3>
                        <p class="text-slate-400 text-sm">Size: L | Bahan: Dry-Fit Milano</p>
                        <p class="text-lime-400 font-bold mt-1">Rp 150.000</p>
                    </div>

                    <div class="flex flex-col items-center gap-2">
                        <div class="flex items-center border border-slate-600 rounded-lg overflow-hidden">
                            <button class="px-3 py-1 text-white hover:bg-slate-700 transition">-</button>
                            <input type="text" value="1" class="w-12 py-1 text-center bg-navy-900 text-white border-none text-sm focus:ring-0">
                            <button class="px-3 py-1 text-white hover:bg-slate-700 transition">+</button>
                        </div>
                        <button class="text-red-400 text-xs hover:text-red-300 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus
                        </button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4 bg-navy-800 p-4 rounded-xl border border-slate-700 relative group">
                    <div class="flex items-center h-5">
                        <input type="checkbox" checked class="w-4 h-4 text-lime-500 bg-navy-900 border-slate-600 rounded focus:ring-lime-500 focus:ring-2">
                    </div>
                    <div class="w-24 h-24 bg-navy-900 rounded-lg overflow-hidden flex-shrink-0">
                        <img src="https://placehold.co/150x150/1a202c/FFF?text=Kaos" alt="Produk" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="text-white font-bold text-lg">Kaos Polos Cotton Combed 30s</h3>
                        <p class="text-slate-400 text-sm">Size: XL | Warna: Hitam</p>
                        <p class="text-lime-400 font-bold mt-1">Rp 85.000</p>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="flex items-center border border-slate-600 rounded-lg overflow-hidden">
                            <button class="px-3 py-1 text-white hover:bg-slate-700 transition">-</button>
                            <input type="text" value="2" class="w-12 py-1 text-center bg-navy-900 text-white border-none text-sm focus:ring-0">
                            <button class="px-3 py-1 text-white hover:bg-slate-700 transition">+</button>
                        </div>
                        <button class="text-red-400 text-xs hover:text-red-300 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus
                        </button>
                    </div>
                </div>

                </div>

            <div class="lg:col-span-1">
                <div class="bg-navy-800 p-6 rounded-xl border border-slate-700 sticky top-24">
                    <h3 class="text-white font-bold text-xl mb-6">Ringkasan Belanja</h3>
                    
                    <div class="space-y-3 mb-6 border-b border-slate-700 pb-6">
                        <div class="flex justify-between text-slate-400 text-sm">
                            <span>Total Harga (3 Barang)</span>
                            <span class="text-white font-medium">Rp 320.000</span>
                        </div>
                        <div class="flex justify-between text-slate-400 text-sm">
                            <span>Diskon</span>
                            <span class="text-green-400 font-medium">- Rp 0</span>
                        </div>
                        <div class="flex justify-between text-slate-400 text-sm">
                            <span>Pajak (PPN 11%)</span>
                            <span class="text-white font-medium">Rp 35.200</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-8">
                        <span class="text-white font-bold text-lg">Total Tagihan</span>
                        <span class="text-lime-400 font-black text-2xl">Rp 355.200</span>
                    </div>

                    <button class="w-full bg-lime-500 hover:bg-lime-400 text-navy-900 font-black py-4 rounded-lg shadow-lg shadow-lime-500/20 transition transform hover:-translate-y-1">
                        CHECKOUT SEKARANG
                    </button>
                    
                    <p class="text-center text-xs text-slate-500 mt-4">
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Transaksi Aman & Terenkripsi
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection