@extends('layouts.dashboard')

@section('title', 'Tambah Produk')

@section('content')

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.products.index') }}" class="bg-navy-800 text-slate-300 hover:text-white p-2 rounded-lg transition border border-slate-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-bold text-white">Tambah Produk Baru</h1>
    </div>

    <div class="w-full bg-navy-900 border border-slate-800 rounded-xl p-6 lg:p-8 shadow-xl">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2">NAMA PRODUK</label>
                        <input type="text" name="name" required class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition" placeholder="Contoh: Jersey Home 2026">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-slate-400 text-sm font-bold mb-2">HARGA (Rp)</label>
                            <input type="number" name="price" required class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition" placeholder="150000">
                        </div>
                        <div>
                            <label class="block text-slate-400 text-sm font-bold mb-2">STOK AWAL</label>
                            <input type="number" name="stock" required class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition" placeholder="100">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2">DESKRIPSI</label>
                        <textarea name="description" rows="4" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition" placeholder="Jelaskan detail bahan, ukuran, dll..."></textarea>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2">STATUS PRODUK</label>
                        <select name="status" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition">
                            <option value="available">Tersedia (Dijual)</option>
                            <option value="unavailable">Tidak Tersedia / Arsip</option>
                        </select>
                    </div>

                    <div class="p-4 bg-navy-950 border border-slate-700 border-dashed rounded-lg text-center">
                        <label class="block text-slate-400 text-sm font-bold mb-2">FOTO PRODUK</label>
                        <input type="file" name="image" class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-lime-400 file:text-navy-900 hover:file:bg-lime-500 transition"/>
                        <p class="text-xs text-slate-500 mt-2">Format: JPG, PNG, WEBP (Max 2MB)</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-slate-800">
                <button type="submit" class="bg-lime-400 hover:bg-lime-500 text-navy-950 font-black px-8 py-3 rounded-lg transition shadow-lg shadow-lime-400/20 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> SIMPAN PRODUK
                </button>
            </div>
        </form>
    </div>

@endsection