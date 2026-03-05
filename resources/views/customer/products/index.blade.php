@extends('layouts.app')

@section('title', 'Produk Kami - Becks Apparel')

@section('content')
<section class="relative min-h-[40vh] flex items-center pt-32 pb-20 overflow-hidden bg-navy-950">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-lime-500/10 rounded-full blur-[150px] -translate-y-1/2 -translate-x-1/4"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[120px] translate-y-1/3 translate-x-1/4"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full text-center">
        <div class="inline-flex items-center gap-3 bg-slate-800/50 border border-lime-500/30 rounded-full px-5 py-2 mb-8 backdrop-blur-sm" data-aos="fade-up">
            <span class="flex h-2.5 w-2.5 rounded-full bg-lime-400"></span>
            <span class="text-xs font-bold text-lime-400 uppercase tracking-widest">Koleksi Tersedia</span>
        </div>
        
        <h1 class="text-5xl lg:text-7xl font-black text-white tracking-tight mb-6" data-aos="fade-up" data-aos-delay="100">
            PRODUK 
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-300">
                KAMI
            </span>
        </h1>
        <p class="text-lg text-slate-400 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Temukan berbagai pilihan apparel dan jersey berkualitas premium yang siap melengkapi gaya kamu.
        </p>
    </div>
</section>

<section class="py-20 bg-navy-900 relative border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        @if($products->isEmpty())
            <div class="text-center py-20" data-aos="fade-up">
                <svg class="w-16 h-16 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                <h3 class="text-2xl font-bold text-white mb-2">Belum ada produk</h3>
                <p class="text-slate-400">Produk sedang dalam tahap persiapan. Coba lagi nanti.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($products as $index => $product)
                    <div class="group relative bg-slate-800/50 border border-slate-700 rounded-2xl overflow-hidden hover:border-lime-400/50 transition-all duration-300 flex flex-col" data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}">
                        <div class="aspect-[4/5] relative overflow-hidden bg-slate-800">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="{{ $product->name }}">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-slate-500">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                @if ($product->stock > 0)
                                    <span class="bg-lime-400 text-navy-950 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-sm">Tersedia</span>
                                @else
                                    <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-sm">Habis</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-white mb-2 line-clamp-2 group-hover:text-lime-400 transition-colors">{{ $product->name }}</h3>
                            <p class="text-2xl font-black text-lime-400 mb-4 mt-auto">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            
                            <a href="{{ route('products.show', $product->slug) }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white/5 text-white font-bold rounded-xl hover:bg-lime-400 hover:text-navy-950 transition-all group-hover:shadow-[0_0_20px_rgba(163,230,53,0.3)]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                LIHAT DETAIL
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
