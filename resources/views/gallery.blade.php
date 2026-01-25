@extends('layouts.app')

@section('title', 'Gallery - Our Best Works')

@section('content')
<section id="gallery-hero" class="relative min-h-[50vh] flex items-center pt-32 overflow-hidden bg-navy-950">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-lime-500/10 rounded-full blur-[150px] -translate-y-1/2 -translate-x-1/4"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-accent-purple/10 rounded-full blur-[120px] translate-y-1/3 translate-x-1/4"></div>
        <div class="absolute inset-0 bg-hero-pattern opacity-[0.03]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full text-center">
        <div class="inline-flex items-center gap-3 bg-slate-800/50 border border-lime-500/30 rounded-full px-5 py-2 mb-8 backdrop-blur-sm" data-aos="fade-up">
            <span class="flex h-2.5 w-2.5 rounded-full bg-lime-400"></span>
            <span class="text-xs font-bold text-lime-400 uppercase tracking-widest">Showcase Portofolio</span>
        </div>
        <h1 class="text-5xl lg:text-7xl font-black text-white tracking-tight mb-6" data-aos="fade-up" data-aos-delay="100">
            KARYA <span class="text-gradient">TERBAIK</span> KAMI
        </h1>
        <p class="text-lg text-slate-400 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Melihat lebih dekat kualitas jahitan, detail desain, dan hasil cetak premium yang telah kami kerjakan untuk ribuan tim.
        </p>
    </div>
</section>

<section class="py-20 bg-navy-950 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6">
            @forelse(($images ?? []) as $image)
            <div class="break-inside-avoid" data-aos="fade-up">
                <div class="relative group rounded-2xl overflow-hidden border border-white/10 bg-slate-900 glass-card transition-all duration-500 hover:border-lime-400/50">
                    
                    <img src="{{ $image }}" 
                         alt="Becks Apparel Gallery" 
                         class="w-full h-auto object-cover transition duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0 opacity-80 group-hover:opacity-100">

                    <div class="absolute inset-0 bg-linear-to-t from-navy-950 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
                        <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                            <span class="text-xs font-bold text-lime-400 uppercase tracking-widest">Premium Quality</span>
                            <h3 class="text-white font-bold text-lg">Custom Jersey Project</h3>
                            <div class="flex gap-2 mt-3">
                                <div class="w-2 h-2 rounded-full bg-lime-400"></div>
                                <div class="w-2 h-2 rounded-full bg-accent-cyan"></div>
                                <div class="w-2 h-2 rounded-full bg-accent-purple"></div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute inset-0 border-2 border-lime-400/0 group-hover:border-lime-400/20 transition-colors duration-500 pointer-events-none rounded-2xl"></div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20">
                <p class="text-slate-500 italic">Belum ada foto di folder gallery.</p>
            </div>
            @endforelse
        </div>

    </div>
</section>

<section class="py-20 bg-navy-900">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-black text-white mb-6">Tertarik dengan hasil kami?</h2>
        <a href="#" class="inline-flex items-center gap-3 px-8 py-4 bg-lime-400 text-navy-950 font-black rounded-xl hover:bg-lime-500 transition transform hover:scale-105">
            <i data-lucide="send"></i> KONSULTASI VIA WHATSAPP
        </a>
    </div>
</section>
@endsection