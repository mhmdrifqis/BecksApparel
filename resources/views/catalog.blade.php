@extends('layouts.app')

@section('title', 'Catalog - Becks Apparel')

@section('content')
<section id="catalog-hero" class="relative min-h-[40vh] flex items-center pt-32 overflow-hidden bg-navy-950">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-lime-500/10 rounded-full blur-[150px] -translate-y-1/2 -translate-x-1/4"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-[120px] translate-y-1/3 translate-x-1/4"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full text-center">
        <div class="inline-flex items-center gap-3 bg-slate-800/50 border border-lime-500/30 rounded-full px-5 py-2 mb-8 backdrop-blur-sm" data-aos="fade-up">
            <span class="flex h-2.5 w-2.5 rounded-full bg-lime-400"></span>
            <span class="text-xs font-bold text-lime-400 uppercase tracking-widest">Premium Apparel Collection</span>
        </div>
        
        <h1 class="text-5xl lg:text-7xl font-black text-white tracking-tight mb-6" data-aos="fade-up" data-aos-delay="100">
            KATALOG 
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-300">
                KOLEKSI
            </span>
        </h1>
        <p class="text-lg text-slate-400 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Pilih kategori jersey atau apparel favoritmu dan mulai kustomisasi desain sesuai karakter tim kamu.
        </p>
    </div>
</section>

<section class="py-20 bg-navy-950 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="group relative h-[500px] rounded-3xl overflow-hidden border border-white/10 glass-card" data-aos="fade-up" data-aos-delay="100">
                <img src="{{ asset('images/cat-football.jpg') }}" class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0" alt="Football">
                <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/20 to-transparent opacity-90"></div>
                
                <div class="absolute inset-0 p-8 flex flex-col justify-end">
                    <span class="text-xs font-bold text-lime-400 uppercase tracking-[0.3em] mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">Professional Grade</span>
                    <h3 class="text-3xl font-black text-white mb-4">JERSEY SEPAKBOLA</h3>
                    <a href="{{ route('admin.products.index', ['category' => 'football']) }}" class="inline-flex items-center text-lime-400 font-bold tracking-wider hover:text-white transition-colors">
                        LIHAT KOLEKSI <span class="ml-2 transform group-hover:translate-x-2 transition-transform">&rarr;</span>
                    </a>
                </div>
                <div class="absolute inset-0 border-2 border-lime-400/0 group-hover:border-lime-400/40 transition-colors duration-500 pointer-events-none rounded-3xl"></div>
            </div>

            <div class="group relative h-[500px] rounded-3xl overflow-hidden border border-white/10 glass-card" data-aos="fade-up" data-aos-delay="200">
                <img src="{{ asset('images/cat-basketball.jpg') }}" class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0" alt="Basketball">
                <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/20 to-transparent opacity-90"></div>
                
                <div class="absolute inset-0 p-8 flex flex-col justify-end">
                    <span class="text-xs font-bold text-lime-400 uppercase tracking-[0.3em] mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">Performance Gear</span>
                    <h3 class="text-3xl font-black text-white mb-4">JERSEY BASKET</h3>
                    <a href="{{ route('admin.products.index', ['category' => 'basketball']) }}" class="inline-flex items-center text-lime-400 font-bold tracking-wider hover:text-white transition-colors">
                        LIHAT KOLEKSI <span class="ml-2 transform group-hover:translate-x-2 transition-transform">&rarr;</span>
                    </a>
                </div>
                <div class="absolute inset-0 border-2 border-lime-400/0 group-hover:border-lime-400/40 transition-colors duration-500 pointer-events-none rounded-3xl"></div>
            </div>

            <div class="group relative h-[500px] rounded-3xl overflow-hidden border border-white/10 glass-card" data-aos="fade-up" data-aos-delay="300">
                <img src="{{ asset('images/cat-lifestyle.jpg') }}" class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0" alt="Lifestyle">
                <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/20 to-transparent opacity-90"></div>
                
                <div class="absolute inset-0 p-8 flex flex-col justify-end">
                    <span class="text-xs font-bold text-lime-400 uppercase tracking-[0.3em] mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500">Daily Essentials</span>
                    <h3 class="text-3xl font-black text-white mb-4">LIFESTYLE APPAREL</h3>
                    <a href="{{ route('admin.products.index', ['category' => 'lifestyle']) }}" class="inline-flex items-center text-lime-400 font-bold tracking-wider hover:text-white transition-colors">
                        LIHAT KOLEKSI <span class="ml-2 transform group-hover:translate-x-2 transition-transform">&rarr;</span>
                    </a>
                </div>
                <div class="absolute inset-0 border-2 border-lime-400/0 group-hover:border-lime-400/40 transition-colors duration-500 pointer-events-none rounded-3xl"></div>
            </div>

        </div>
    </div>
</section>

<section class="py-20 bg-navy-900 border-t border-white/5">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-black text-white mb-2" data-aos="fade-up">BELUM MENEMUKAN YANG COCOK?</h2>
        <p class="text-slate-400 mb-8" data-aos="fade-up" data-aos-delay="100">Konsultasikan kebutuhan custom jersey tim kamu secara gratis dengan desainer kami.</p>
        <a href="https://wa.me/yournumber" class="inline-flex items-center gap-3 px-10 py-4 bg-lime-400 text-navy-950 font-black rounded-2xl hover:bg-lime-500 transition transform hover:scale-105 shadow-[0_0_20px_rgba(163,230,53,0.3)]">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.438 9.889-9.886.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.89 4.44-9.892 9.886-.001 2.125.593 3.456 1.574 5.111l-.973 3.558 3.653-.958zM17.433 14.125c-.313-.156-1.853-.914-2.14-.1.02-.288-.124-.439-.42-.589-.297-.149-1.247-.491-2.421-1.538-.914-.815-1.53-1.823-1.711-2.133-.181-.31-.019-.477.136-.632.141-.139.313-.367.47-.55.156-.184.209-.317.313-.529.104-.212.052-.397-.026-.55-.078-.154-.703-1.693-.963-2.321-.253-.615-.51-.531-.703-.541l-.598-.013c-.209 0-.547.079-.833.393-.286.315-1.094 1.071-1.094 2.613 0 1.541 1.12 3.033 1.276 3.246.156.212 2.204 3.366 5.341 4.72.747.322 1.33.515 1.784.659.75.239 1.433.205 1.972.125.6-.09 1.853-.758 2.114-1.458.26-.699.26-1.3.182-1.425-.077-.126-.285-.201-.598-.357z"/></svg>
            KONSULTASI VIA WHATSAPP
        </a>
    </div>
</section>
@endsection