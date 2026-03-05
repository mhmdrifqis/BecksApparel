@extends('layouts.app')

@section('title', $product->name . ' - Becks Apparel')

@section('content')
<section class="pt-32 pb-20 bg-navy-950 min-h-[90vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-slate-400 hover:text-lime-400">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-500"></i>
                        <a href="{{ route('products.index') }}" class="ml-1 text-sm font-medium text-slate-400 hover:text-lime-400 md:ml-2">Produk</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-500"></i>
                        <span class="ml-1 text-sm font-bold text-white md:ml-2 line-clamp-1 break-all">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-navy-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl p-6 lg:p-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Product Image -->
                <div class="relative bg-navy-950 rounded-2xl overflow-hidden aspect-[4/5] lg:aspect-square flex items-center justify-center border border-slate-800">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                    @else
                        <i data-lucide="image" class="w-24 h-24 text-slate-700"></i>
                    @endif
                    
                    @if ($product->status == 'unavailable' || $product->stock <= 0)
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center backdrop-blur-sm">
                            <span class="bg-red-500 text-white font-black px-6 py-2 rounded-full uppercase tracking-widest -rotate-12 text-2xl border-4 border-red-600">HABIS</span>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="flex flex-col">
                    <h1 class="text-4xl lg:text-5xl font-black text-white mb-4 leading-tight">{{ $product->name }}</h1>
                    
                    <p class="text-3xl font-black text-lime-400 mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                    <div class="prose prose-invert prose-slate mb-8 max-w-none">
                        <p class="text-slate-300 leading-relaxed">{{ $product->description ?: 'Belum ada deskripsi untuk produk ini.' }}</p>
                    </div>

                    <!-- Colors -->
                    @if($product->colors->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-3">Pilihan Warna Tersedia</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($product->colors as $color)
                                <div class="flex items-center gap-2 bg-navy-950 border border-slate-800 rounded-full px-4 py-2" title="{{ $color->color_name }}">
                                    <span class="w-4 h-4 rounded-full border border-white/20" style="background-color: {{ $color->hex_code }}"></span>
                                    <span class="text-sm font-medium text-slate-300">{{ $color->color_name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="h-px w-full bg-slate-800 my-6"></div>

                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <!-- Size Selection -->
                            <div>
                                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-3">Pilih Ukuran <span class="text-red-400">*</span></h3>
                                <div class="relative">
                                    <select name="size" required class="w-full bg-navy-950 border border-slate-700 text-white text-base rounded-xl focus:ring-lime-400 focus:border-lime-400 block p-3.5 appearance-none">
                                        <option value="" disabled selected>Pilih Ukuran...</option>
                                        @forelse($product->sizes as $size)
                                            <option value="{{ $size->size_name }}">{{ $size->size_name }}</option>
                                        @empty
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                        @endforelse
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Quantity Selection -->
                            <div>
                                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-3">Kuantitas <span class="text-red-400">*</span></h3>
                                <div class="relative flex items-center max-w-[8rem]" x-data="{ qty: 1, max: {{ $product->stock }} }">
                                    <button type="button" @click="qty > 1 ? qty-- : null" class="bg-navy-950 hover:bg-slate-800 border-y border-l border-slate-700 rounded-l-xl p-3 h-12 flex items-center justify-center">
                                        <i data-lucide="minus" class="w-4 h-4 text-slate-300"></i>
                                    </button>
                                    <input type="number" name="quantity" x-model="qty" min="1" max="{{ $product->stock }}" 
                                           class="bg-navy-950 border-y border-slate-700 h-12 text-center text-white text-base focus:ring-lime-400 focus:border-lime-400 block w-full outline-none" required>
                                    <button type="button" @click="qty < max ? qty++ : null" class="bg-navy-950 hover:bg-slate-800 border-y border-r border-slate-700 rounded-r-xl p-3 h-12 flex items-center justify-center">
                                        <i data-lucide="plus" class="w-4 h-4 text-slate-300"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-slate-500 mt-2">Sisa stok: {{ $product->stock }}</p>
                            </div>
                        </div>

                        <button type="submit" 
                            class="w-full flex items-center justify-center gap-3 bg-lime-400 hover:bg-lime-500 text-navy-950 font-black text-lg py-4 rounded-xl shadow-lg shadow-lime-400/20 hover:scale-[1.02] transition-all duration-300 @if($product->stock <= 0 || $product->status == 'unavailable') opacity-50 cursor-not-allowed @endif"
                            @if($product->stock <= 0 || $product->status == 'unavailable') disabled @endif>
                            <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                            TAMBAH KE KERANJANG
                        </button>
                        @if ($errors->any())
                            <div class="mt-4 text-sm text-red-400 bg-red-400/10 border border-red-400/30 rounded-xl p-3">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
