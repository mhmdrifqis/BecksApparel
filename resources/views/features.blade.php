@extends('layouts.app')

@section('title', 'Fitur & Keunggulan - Becks Apparel')

@section('content')
<section class="relative min-h-screen pt-32 pb-20 overflow-hidden bg-navy-950">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-0 w-[500px] h-[500px] bg-lime-500/10 rounded-full blur-[120px] -translate-x-1/2"></div>
        <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-blue-500/10 rounded-full blur-[150px] translate-x-1/3 translate-y-1/4"></div>
        <div class="absolute inset-0 bg-[url('/images/grid-pattern.svg')] opacity-[0.02]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-3 bg-slate-800/50 border border-lime-500/30 rounded-full px-5 py-2 mb-6 backdrop-blur-sm" data-aos="fade-up">
                <span class="flex h-2.5 w-2.5 rounded-full bg-lime-400 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-lime-400 opacity-75"></span>
                </span>
                <span class="text-xs font-bold text-lime-400 uppercase tracking-widest">Keunggulan Kami</span>
            </div>

            <h2 class="text-4xl lg:text-5xl font-black text-white leading-tight mb-6 tracking-tight" data-aos="fade-up" data-aos-delay="100">
                MENGAPA MEMILIH <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-emerald-300">BECKS APPAREL?</span>
            </h2>
            
            <p class="text-slate-400 text-lg leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                Kami menggabungkan teknologi tekstil mutakhir, digital printing resolusi tinggi, dan platform kustomisasi cerdas untuk menghasilkan jersey kualitas juara.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center mb-24">
            
            <div class="relative order-2 lg:order-1 mt-10 lg:mt-0" data-aos="fade-right" data-aos-delay="300">
                <div class="absolute -inset-4 bg-gradient-to-tr from-lime-400/20 to-blue-500/20 blur-3xl rounded-[3rem] transform -rotate-6"></div>
                
                <div class="relative rounded-[2rem] overflow-hidden border border-white/10 bg-slate-900 shadow-[0_20px_50px_rgba(0,0,0,0.5)] group">
                    <img src="{{ asset('images/feature-showcase.png') }}" class="w-full h-auto object-cover transition duration-700 group-hover:scale-105" alt="Becks Apparel Features">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-950/80 via-transparent to-transparent opacity-60"></div>
                </div>

                <div class="absolute -bottom-6 -right-6 lg:-left-6 bg-slate-900/90 backdrop-blur-xl border border-white/10 p-5 rounded-2xl shadow-2xl flex items-center gap-4 hover:-translate-y-2 transition-transform duration-500">
                    <div class="w-12 h-12 rounded-full bg-lime-400 flex items-center justify-center text-navy-950 shadow-[0_0_15px_rgba(163,230,53,0.4)]">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Quality Control</p>
                        <p class="text-xl font-black text-white">100% Premium</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4 order-1 lg:order-2">
                
                <div class="group flex items-start gap-5 p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md hover:border-lime-400/40 hover:bg-white/10 transition-all duration-300" data-aos="fade-left" data-aos-delay="100">
                    <div class="flex-shrink-0 w-12 h-12 bg-navy-950 border border-lime-400/20 rounded-xl flex items-center justify-center text-lime-400 shadow-[0_0_15px_rgba(163,230,53,0.15)] group-hover:scale-110 group-hover:bg-lime-400 group-hover:text-navy-950 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-lg mb-1 group-hover:text-lime-300 transition-colors">Bahan Premium Dry-Fit</h4>
                        <p class="text-slate-400 text-sm leading-relaxed">Sirkulasi udara maksimal dan cepat menyerap keringat. Tetap sejuk di intensitas tinggi.</p>
                    </div>
                </div>

                <div class="group flex items-start gap-5 p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md hover:border-lime-400/40 hover:bg-white/10 transition-all duration-300" data-aos="fade-left" data-aos-delay="200">
                    <div class="flex-shrink-0 w-12 h-12 bg-navy-950 border border-lime-400/20 rounded-xl flex items-center justify-center text-lime-400 shadow-[0_0_15px_rgba(163,230,53,0.15)] group-hover:scale-110 group-hover:bg-lime-400 group-hover:text-navy-950 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-lg mb-1 group-hover:text-lime-300 transition-colors">Sublimation High-Res</h4>
                        <p class="text-slate-400 text-sm leading-relaxed">Warna tajam, anti luntur, dan menyatu sempurna dengan serat kain tanpa mengelupas.</p>
                    </div>
                </div>

                <div class="group flex items-start gap-5 p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md hover:border-lime-400/40 hover:bg-white/10 transition-all duration-300" data-aos="fade-left" data-aos-delay="300">
                    <div class="flex-shrink-0 w-12 h-12 bg-navy-950 border border-lime-400/20 rounded-xl flex items-center justify-center text-lime-400 shadow-[0_0_15px_rgba(163,230,53,0.15)] group-hover:scale-110 group-hover:bg-lime-400 group-hover:text-navy-950 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-lg mb-1 group-hover:text-lime-300 transition-colors">3D Live Customizer</h4>
                        <p class="text-slate-400 text-sm leading-relaxed">Visualisasikan desain jersey impianmu secara real-time dari segala sudut sebelum diproduksi.</p>
                    </div>
                </div>

                <div class="group flex items-start gap-5 p-5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md hover:border-lime-400/40 hover:bg-white/10 transition-all duration-300" data-aos="fade-left" data-aos-delay="400">
                    <div class="flex-shrink-0 w-12 h-12 bg-navy-950 border border-lime-400/20 rounded-xl flex items-center justify-center text-lime-400 shadow-[0_0_15px_rgba(163,230,53,0.15)] group-hover:scale-110 group-hover:bg-lime-400 group-hover:text-navy-950 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-lg mb-1 group-hover:text-lime-300 transition-colors">Jahitan & Cutting Presisi</h4>
                        <p class="text-slate-400 text-sm leading-relaxed">Dikerjakan oleh penjahit profesional dengan standar pola yang ergonomis untuk atlet.</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="pt-16 border-t border-white/10 relative">
            <div class="text-center mb-12">
                <h3 class="text-2xl lg:text-3xl font-black text-white" data-aos="fade-up">EKOSISTEM <span class="text-lime-400">LAYANAN KAMI</span></h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-slate-900/50 backdrop-blur-sm border border-white/10 p-8 rounded-3xl text-center hover:-translate-y-2 hover:border-lime-400/30 transition-all duration-500" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 mx-auto bg-navy-950 border border-lime-400/20 rounded-2xl flex items-center justify-center text-lime-400 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <h4 class="text-white font-bold text-lg mb-3">AI Design Assistant</h4>
                    <p class="text-slate-400 text-sm">Kehabisan ide? Fitur AI kami siap membantu men-generate pola dan warna eksklusif hanya dengan prompt teks.</p>
                </div>

                <div class="bg-slate-900/50 backdrop-blur-sm border border-white/10 p-8 rounded-3xl text-center hover:-translate-y-2 hover:border-lime-400/30 transition-all duration-500" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 mx-auto bg-navy-950 border border-lime-400/20 rounded-2xl flex items-center justify-center text-lime-400 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-white font-bold text-lg mb-3">Produksi Terukur</h4>
                    <p class="text-slate-400 text-sm">Timeline pengerjaan yang transparan. Anda bisa memantau status pesanan tim Anda langsung dari dashboard.</p>
                </div>

                <div class="bg-slate-900/50 backdrop-blur-sm border border-white/10 p-8 rounded-3xl text-center hover:-translate-y-2 hover:border-lime-400/30 transition-all duration-500" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 mx-auto bg-navy-950 border border-lime-400/20 rounded-2xl flex items-center justify-center text-lime-400 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <h4 class="text-white font-bold text-lg mb-3">Pembayaran Terintegrasi</h4>
                    <p class="text-slate-400 text-sm">Didukung oleh payment gateway otomatis untuk transaksi yang aman, cepat, dan terverifikasi secara instan.</p>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection