@extends('layouts.dashboard')

@section('title', 'Manajemen Produk')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Produk & Layanan</h1>
            <p class="text-slate-400 text-sm">Kelola katalog produk Becks Apparel.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-lime-400 hover:bg-lime-500 text-navy-950 font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition shadow-lg shadow-lime-400/20">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-lime-400/10 border border-lime-400/20 text-lime-400 rounded-lg flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-navy-900 border border-slate-800 rounded-xl overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-slate-300">
                <thead class="bg-navy-950 text-slate-400 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Stok</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($products as $product)
                    <tr class="hover:bg-navy-800/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-lg object-cover border border-slate-700" alt="{{ $product->name }}">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-navy-800 border border-slate-700 flex items-center justify-center text-slate-500">
                                        <i data-lucide="image" class="w-6 h-6"></i>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-bold text-white">{{ $product->name }}</h4>
                                    <p class="text-xs text-slate-500 truncate max-w-50">{{ $product->description ?? 'Tidak ada deskripsi' }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 font-bold text-lime-400">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            @if($product->stock <= 5)
                                <span class="text-red-400 font-bold flex items-center gap-1">
                                    {{ $product->stock }} <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                </span>
                            @else
                                <span class="text-slate-300">{{ $product->stock }} pcs</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if($product->status == 'available')
                                <span class="bg-lime-500/10 text-lime-400 border border-lime-500/20 text-xs font-bold px-2 py-1 rounded">Tersedia</span>
                            @else
                                <span class="bg-red-500/10 text-red-400 border border-red-500/20 text-xs font-bold px-2 py-1 rounded">Habis / Non-aktif</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white rounded-lg transition">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white rounded-lg transition">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            Belum ada produk. Silakan tambah produk baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $products->links() }}
        </div>
    </div>

@endsection