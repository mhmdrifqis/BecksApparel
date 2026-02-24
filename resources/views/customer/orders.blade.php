@extends('layouts.app')

@section('title', 'Pesanan Saya - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
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

            <div class="bg-navy-800 border border-slate-700 rounded-xl overflow-hidden hover:border-lime-400/50 transition duration-300">
                <div class="bg-navy-900/50 px-6 py-4 border-b border-slate-700 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4 text-sm">
                        <span class="font-bold text-white">ORD-20260220-001</span>
                        <span class="text-slate-500">|</span>
                        <span class="text-slate-400">20 Feb 2026</span>
                    </div>
                    <div>
                        <span class="bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                            Menunggu Pembayaran
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-24 h-24 flex-shrink-0 bg-navy-900 rounded-md border border-slate-700 overflow-hidden">
                            <img src="https://placehold.co/150x150/1a202c/FFF?text=Jersey" alt="Produk" class="w-full h-full object-cover">
                        </div>

                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white mb-1">Custom Jersey Futsal - Full Print</h3>
                            <p class="text-sm text-slate-400 mb-2">Varian: Lengan Pendek, Bahan Dry-Fit Milano</p>
                            <div class="text-xs text-slate-500 space-y-1">
                                <p>Size: L (5 pcs), XL (2 pcs)</p>
                                <p>Custom Name: "BECKS FC"</p>
                            </div>
                        </div>

                        <div class="flex flex-row md:flex-col justify-between items-center md:items-end gap-4 border-t md:border-t-0 border-slate-700 pt-4 md:pt-0 mt-4 md:mt-0">
                            <div class="text-right">
                                <p class="text-xs text-slate-400">Total Belanja</p>
                                <p class="text-xl font-bold text-lime-400">Rp 1.050.000</p>
                            </div>
                            <button class="w-full md:w-auto bg-lime-500 hover:bg-lime-400 text-navy-900 font-bold py-2 px-6 rounded transition">
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-navy-800 border border-slate-700 rounded-xl overflow-hidden hover:border-lime-400/50 transition duration-300">
                <div class="bg-navy-900/50 px-6 py-4 border-b border-slate-700 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4 text-sm">
                        <span class="font-bold text-white">ORD-20260215-088</span>
                        <span class="text-slate-500">|</span>
                        <span class="text-slate-400">15 Feb 2026</span>
                    </div>
                    <div>
                        <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide flex items-center gap-2">
                            <span class="relative flex h-2 w-2">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                            </span>
                            Sedang Dijahit
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-24 h-24 flex-shrink-0 bg-navy-900 rounded-md border border-slate-700 overflow-hidden">
                            <img src="https://placehold.co/150x150/1a202c/FFF?text=Varsity" alt="Produk" class="w-full h-full object-cover">
                        </div>

                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white mb-1">Jaket Varsity Custom - Bordir</h3>
                            <p class="text-sm text-slate-400 mb-2">Varian: Fleece Cotton, Lengan Kulit Sintetis</p>
                            <div class="text-xs text-slate-500">
                                <p>Size: XL (1 pcs)</p>
                            </div>
                        </div>

                        <div class="flex flex-row md:flex-col justify-between items-center md:items-end gap-4 border-t md:border-t-0 border-slate-700 pt-4 md:pt-0 mt-4 md:mt-0">
                            <div class="text-right">
                                <p class="text-xs text-slate-400">Total Belanja</p>
                                <p class="text-xl font-bold text-white">Rp 350.000</p>
                            </div>
                            <div class="flex gap-2 w-full md:w-auto">
                                <button class="flex-1 md:flex-none border border-slate-500 text-slate-300 hover:text-white hover:border-white font-bold py-2 px-4 rounded transition text-sm">
                                    Detail
                                </button>
                                <button class="flex-1 md:flex-none bg-navy-700 text-white font-bold py-2 px-4 rounded cursor-not-allowed opacity-50 text-sm">
                                    Lacak (Belum Tersedia)
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-navy-800 border border-slate-700 rounded-xl overflow-hidden hover:border-lime-400/50 transition duration-300 opacity-75 hover:opacity-100">
                <div class="bg-navy-900/50 px-6 py-4 border-b border-slate-700 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4 text-sm">
                        <span class="font-bold text-white">ORD-20260110-012</span>
                        <span class="text-slate-500">|</span>
                        <span class="text-slate-400">10 Jan 2026</span>
                    </div>
                    <div>
                        <span class="bg-green-500/10 text-green-400 border border-green-500/20 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide">
                            Selesai
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-24 h-24 flex-shrink-0 bg-navy-900 rounded-md border border-slate-700 overflow-hidden">
                            <img src="https://placehold.co/150x150/1a202c/FFF?text=Kaos" alt="Produk" class="w-full h-full object-cover grayscale">
                        </div>

                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white mb-1">Kaos Event Komunitas</h3>
                            <p class="text-sm text-slate-400 mb-2">Varian: Cotton Combed 30s, Sablon Plastisol</p>
                            <div class="text-xs text-slate-500">
                                <p>Qty: 100 pcs</p>
                            </div>
                        </div>

                        <div class="flex flex-row md:flex-col justify-between items-center md:items-end gap-4 border-t md:border-t-0 border-slate-700 pt-4 md:pt-0 mt-4 md:mt-0">
                            <div class="text-right">
                                <p class="text-xs text-slate-400">Total Belanja</p>
                                <p class="text-xl font-bold text-white">Rp 8.500.000</p>
                            </div>
                            <button class="w-full md:w-auto border border-lime-400 text-lime-400 hover:bg-lime-400 hover:text-navy-900 font-bold py-2 px-6 rounded transition text-sm">
                                Beli Lagi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            </div>

    </div>
</div>
@endsection