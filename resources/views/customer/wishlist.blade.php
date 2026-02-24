@extends('layouts.app')

@section('title', 'Wishlist - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-black text-white">WISHLIST <span class="text-lime-400">SAYA</span></h1>
            <span class="text-slate-400 text-sm">3 Item tersimpan</span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            
            <div class="bg-navy-800 rounded-xl border border-slate-700 overflow-hidden group hover:border-lime-400/50 transition duration-300">
                <div class="relative aspect-[4/5] bg-navy-900">
                    <img src="https://placehold.co/300x400/1a202c/FFF?text=Jaket" alt="Produk" class="w-full h-full object-cover">
                    <button class="absolute top-2 right-2 bg-navy-900/80 text-white p-1.5 rounded-full hover:bg-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-4">
                    <h3 class="text-white font-bold text-sm truncate">Jaket Varsity Custom</h3>
                    <p class="text-lime-400 font-bold text-sm mt-1">Rp 250.000</p>
                    <button class="w-full mt-3 bg-slate-700 hover:bg-lime-500 hover:text-navy-900 text-white text-xs font-bold py-2 rounded transition flex items-center justify-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        + Keranjang
                    </button>
                </div>
            </div>

            <div class="bg-navy-800 rounded-xl border border-slate-700 overflow-hidden group hover:border-lime-400/50 transition duration-300">
                <div class="relative aspect-[4/5] bg-navy-900">
                    <img src="https://placehold.co/300x400/1a202c/FFF?text=Training" alt="Produk" class="w-full h-full object-cover">
                    <button class="absolute top-2 right-2 bg-navy-900/80 text-white p-1.5 rounded-full hover:bg-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-4">
                    <h3 class="text-white font-bold text-sm truncate">Celana Training Jogger</h3>
                    <p class="text-lime-400 font-bold text-sm mt-1">Rp 120.000</p>
                    <button class="w-full mt-3 bg-slate-700 hover:bg-lime-500 hover:text-navy-900 text-white text-xs font-bold py-2 rounded transition flex items-center justify-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        + Keranjang
                    </button>
                </div>
            </div>

            <div class="bg-navy-800 rounded-xl border border-slate-700 overflow-hidden group hover:border-lime-400/50 transition duration-300">
                <div class="relative aspect-[4/5] bg-navy-900">
                    <img src="https://placehold.co/300x400/1a202c/FFF?text=Jersey+GK" alt="Produk" class="w-full h-full object-cover">
                    <button class="absolute top-2 right-2 bg-navy-900/80 text-white p-1.5 rounded-full hover:bg-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-4">
                    <h3 class="text-white font-bold text-sm truncate">Jersey Kiper Panjang</h3>
                    <p class="text-lime-400 font-bold text-sm mt-1">Rp 160.000</p>
                    <button class="w-full mt-3 bg-slate-700 hover:bg-lime-500 hover:text-navy-900 text-white text-xs font-bold py-2 rounded transition flex items-center justify-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        + Keranjang
                    </button>
                </div>
            </div>

        </div>

        </div>
</div>
@endsection