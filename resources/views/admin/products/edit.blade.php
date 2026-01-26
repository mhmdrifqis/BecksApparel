@extends('layouts.dashboard')

@section('title', 'Edit Produk')

@section('content')

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.products.index') }}" class="bg-navy-800 text-slate-300 hover:text-white p-2 rounded-lg transition border border-slate-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <h1 class="text-2xl font-bold text-white">Edit Produk: {{ $product->name }}</h1>
    </div>

    <div class="w-full bg-navy-900 border border-slate-800 rounded-xl p-6 lg:p-8 shadow-xl">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2">NAMA PRODUK</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-slate-400 text-sm font-bold mb-2">HARGA (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition">
                        </div>
                        <div>
                            <label class="block text-slate-400 text-sm font-bold mb-2">STOK</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2">DESKRIPSI</label>
                        <textarea name="description" rows="4" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2">STATUS PRODUK</label>
                        <select name="status" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition">
                            <option value="available" {{ $product->status == 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="unavailable" {{ $product->status == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                    </div>

                    <div class="p-4 bg-navy-950 border border-slate-700 border-dashed rounded-lg text-center">
                        <label class="block text-slate-400 text-sm font-bold mb-4">GANTI FOTO (Opsional)</label>
                        
                        @if($product->image)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $product->image) }}" class="h-32 mx-auto rounded-lg border border-slate-700" alt="Preview">
                                <p class="text-xs text-slate-500 mt-1">Foto saat ini</p>
                            </div>
                        @endif

                        <input type="file" name="image" class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-lime-400 file:text-navy-900 hover:file:bg-lime-500 transition"/>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-slate-800">
                <button type="submit" class="bg-lime-400 hover:bg-lime-500 text-navy-950 font-black px-8 py-3 rounded-lg transition shadow-lg shadow-lime-400/20 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> UPDATE PRODUK
                </button>
            </div>
        </form>
    </div>

@endsection