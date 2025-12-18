

    @extends('layouts.app')

@section('title', 'The Future of Custom Sportswear')

@section('content')
      <!-- HERO SECTION (Megah & Dynamic) -->
    <section id="home" class="relative min-h-screen flex items-center pt-20 overflow-hidden">
        <!-- Dynamic Background Elements -->
        <div class="absolute inset-0 bg-navy-950">
            <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-lime-500/10 rounded-full blur-[150px] -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-accent-purple/10 rounded-full blur-[120px] translate-y-1/3 -translate-x-1/4"></div>
            <div class="absolute inset-0 bg-hero-pattern opacity-[0.03]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                
                <!-- Left Content -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-3 bg-slate-800/50 border border-lime-500/30 rounded-full px-5 py-2 mb-8 backdrop-blur-sm" data-aos="fade-up">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-lime-400 animate-pulse"></span>
                        <span class="text-xs font-bold text-lime-400 uppercase tracking-widest">Platform Kustomisasi #1 Indonesia</span>
                    </div>

                    <h1 class="text-5xl lg:text-7xl font-black text-white tracking-tight mb-6 leading-[1.1]" data-aos="fade-up" data-aos-delay="100">
                        WUJUDKAN <br>
                        <span class="text-gradient">JERSEY IMPIAN</span> <br>
                        TIM ANDA.
                    </h1>

                    <p class="text-lg lg:text-xl text-slate-400 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                        Teknologi canvas interaktif bertemu dengan manufaktur presisi. Desain sendiri, bayar otomatis, dan pantau produksi secara real-time.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start" data-aos="fade-up" data-aos-delay="300">
                        <a href="#" class="px-8 py-5 bg-lime-400 hover:bg-lime-500 text-navy-950 text-lg font-black rounded-xl transition transform hover:scale-105 shadow-[0_0_30px_rgba(163,230,53,0.3)] flex items-center justify-center gap-3">
                            <i data-lucide="palette"></i> MULAI DESAIN
                        </a>
                        <a href="#" class="px-8 py-5 glass hover:bg-white/5 text-white text-lg font-bold rounded-xl transition border border-white/10 flex items-center justify-center gap-3 group">
                            <i data-lucide="play-circle" class="group-hover:text-lime-400 transition"></i> LIHAT DEMO
                        </a>
                    </div>
                  
                </div>

                <!-- Right Visual (Floating Jersey) -->
                <div class="relative hidden lg:block" data-aos="zoom-in" data-aos-duration="1000">
                    <div class="absolute inset-0 bg-linear-to-tr from-lime-400/20 to-accent-cyan/20 rounded-full blur-[80px] animate-pulse-slow"></div>
                    
                    <!-- Jersey Mockup Card -->
                    <div class="relative animate-float z-10">
                        <div class="glass-card rounded-3xl p-6 transform rotate-6 hover:rotate-0 transition duration-500 border-t border-l border-white/10">
                            <!-- Header Mockup -->
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                                <div class="text-xs font-mono text-lime-400">live_preview.jsx</div>
                            </div>
                            
                            <!-- Image -->
                            <div class="relative rounded-2xl overflow-hidden aspect-4/5 bg-navy-800 group cursor-pointer">
                                <img src="https://i.pinimg.com/1200x/15/23/05/15230562cbe539dfcabd0bcc87e1a37d.jpg" alt="Jersey" class="w-full h-full object-cover opacity-90 group-hover:scale-110 transition duration-700">
                                
                                <!-- Floating UI Tooltips -->
                                <div class="absolute top-10 left-10 bg-black/60 backdrop-blur px-3 py-1.5 rounded-lg border border-lime-500/50 flex items-center gap-2 transform -translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition delay-100">
                                    <div class="w-2 h-2 rounded-full bg-lime-400"></div>
                                    <span class="text-xs font-bold text-white">Bahan: Dryfit</span>
                                </div>

                                <div class="absolute bottom-20 right-10 bg-black/60 backdrop-blur px-3 py-1.5 rounded-lg border border-accent-cyan/50 flex items-center gap-2 transform translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition delay-200">
                                    <div class="w-2 h-2 rounded-full bg-lime-400"></div>
                                    <span class="text-xs font-bold text-white">Kerah: V-Neck</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Elements behind jersey -->
                    <div class="absolute -bottom-10 -left-10 glass-card p-6 rounded-2xl animate-float" style="animation-delay: 1s;">
                        <div class="text-slate-400 text-xs font-bold uppercase mb-1">Pesanan Selesai</div>
                        <div class="text-3xl font-black text-white">1,240+</div>
                        <div class="w-full bg-slate-700 h-1 mt-3 rounded-full overflow-hidden">
                            <div class="bg-lime-400 h-full w-[85%]"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION (Modern Grid) -->
    <section id="features" class="py-32 bg-navy-950 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20" data-aos="fade-up">
                <h2 class="text-lime-400 font-bold tracking-widest uppercase text-sm mb-3">Teknologi Kami</h2>
                <h3 class="text-4xl lg:text-5xl font-black text-white">Bukan Sekadar Toko Online.</h3>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-card p-10 rounded-3xl hover:-translate-y-2 transition duration-300 group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-20 h-20 rounded-2xl bg-linear-to-br from-lime-400/20 to-lime-600/5 flex items-center justify-center mb-8 border border-lime-500/20 group-hover:border-lime-400 transition">
                        <i data-lucide="monitor" class="text-lime-400 w-10 h-10"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-white mb-4">Studio Desain Web</h4>
                    <p class="text-slate-400 leading-relaxed">
                        Lupakan software berat. Desain jersey tim langsung di browser dengan editor visual kami yang intuitif dan real-time.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-card p-10 rounded-3xl hover:-translate-y-2 transition duration-300 group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-20 h-20 rounded-2xl bg-linear-to-br from-accent-cyan/20 to-blue-600/5 flex items-center justify-center mb-8 border border-accent-cyan/20 group-hover:border-accent-cyan transition">
                        <i data-lucide="cpu" class="text-accent-cyan w-10 h-10"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-white mb-4">Smart Manufacturing</h4>
                    <p class="text-slate-400 leading-relaxed">
                        Sistem terintegrasi langsung dengan mesin produksi. Status pesanan diupdate otomatis saat bahan dipotong hingga dikirim.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-card p-10 rounded-3xl hover:-translate-y-2 transition duration-300 group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-20 h-20 rounded-2xl bg-linear-to-br from-accent-purple/20 to-purple-600/5 flex items-center justify-center mb-8 border border-accent-purple/20 group-hover:border-accent-purple transition">
                        <i data-lucide="bot" class="text-accent-purple w-10 h-10"></i>
                    </div>
                    <h4 class="text-2xl font-bold text-white mb-4">AI Assistant Support</h4>
                    <p class="text-slate-400 leading-relaxed">
                        Bingung soal bahan atau ukuran? Tanya Chuibot, asisten AI kami yang siap menjawab pertanyaanmu 24/7.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- PROCESS / HOW IT WORKS (Timeline) -->
    <section id="process" class="py-32 bg-navy-900 border-y border-white/5 relative overflow-hidden">
        <!-- Background Accents -->
        <div class="absolute left-0 top-1/2 w-96 h-96 bg-lime-500/5 rounded-full blur-[100px] -translate-y-1/2"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                
                <div data-aos="fade-right">
                    <h2 class="text-4xl lg:text-5xl font-black text-white mb-8">
                        DARI LAYAR HP <br>
                        <span class="text-gradient">LANGSUNG KE LAPANGAN</span>
                    </h2>
                    
                    <div class="space-y-10">
                        <div class="flex gap-6 group">
                            <div class="shrink-0 w-12 h-12 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xl font-black text-lime-400 group-hover:bg-lime-400 group-hover:text-navy-950 transition">1</div>
                            <div>
                                <h4 class="text-xl font-bold text-white mb-2">Pilih Base Model</h4>
                                <p class="text-slate-400">Pilih dari ratusan template profesional (Futsal, Basket, E-Sport).</p>
                            </div>
                        </div>
                        <div class="flex gap-6 group">
                            <div class="shrink-0 w-12 h-12 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xl font-black text-lime-400 group-hover:bg-lime-400 group-hover:text-navy-950 transition">2</div>
                            <div>
                                <h4 class="text-xl font-bold text-white mb-2">Kustomisasi Total</h4>
                                <p class="text-slate-400">Ganti warna, upload logo tim, dan atur nama pemain di Canvas Editor.</p>
                            </div>
                        </div>
                        <div class="flex gap-6 group">
                            <div class="shrink-0 w-12 h-12 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xl font-black text-lime-400 group-hover:bg-lime-400 group-hover:text-navy-950 transition">3</div>
                            <div>
                                <h4 class="text-xl font-bold text-white mb-2">Checkout & Pantau</h4>
                                <p class="text-slate-400">Bayar via QRIS. Duduk santai sambil memantau progres produksi real-time.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative" data-aos="fade-left">
                    <div class="absolute inset-0 bg-linear-to-r from-lime-500/20 to-transparent rounded-full blur-3xl"></div>
                    <img src="https://i.pinimg.com/736x/e3/55/d4/e355d4ae15476e5eba4d970a40afdaad.jpg" alt="Process" class="relative rounded-3xl border border-white/10 shadow-2xl transform rotate-3 hover:rotate-0 transition duration-500">
                    
                    <!-- Floating Stat -->
                    <div class="absolute -bottom-8 -left-8 glass-card p-6 rounded-2xl animate-float">
                        <div class="flex items-center gap-4">
                            <div class="bg-lime-400/20 p-3 rounded-full text-lime-400">
                                <i data-lucide="check-circle" width="32" height="32"></i>
                            </div>
                            <div>
                                <div class="text-white font-bold text-lg">Garansi 100%</div>
                                <div class="text-slate-400 text-sm">Jika salah cetak</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CATALOG SHOWCASE -->
    <section id="catalog" class="py-32 bg-navy-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-16" data-aos="fade-up">
                <div>
                    <h2 class="text-4xl font-black text-white mb-2">KOLEKSI UNGGULAN</h2>
                    <p class="text-slate-400">Desain paling populer yang siap dikustomisasi.</p>
                </div>
                <a href="#" class="hidden md:flex items-center gap-2 text-lime-400 font-bold hover:text-white transition">
                    LIHAT SEMUA <i data-lucide="arrow-right" width="16"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- PHP Loop for Products -->
                @foreach($products as $product)
                <div class="group cursor-pointer" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative rounded-3xl overflow-hidden aspect-3/4 mb-6 border border-white/5 bg-slate-900">
                        <div class="absolute inset-0 bg-linear-to-t from-navy-950 via-transparent to-transparent opacity-60 z-10"></div>
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 grayscale group-hover:grayscale-0">
                        
                        <!-- Badge -->
                        <div class="absolute top-4 left-4 z-20 bg-white/10 backdrop-blur px-4 py-1.5 rounded-full border border-white/10">
                            <span class="text-xs font-bold text-white tracking-widest uppercase">{{ $product['category'] }}</span>
                        </div>

                        <!-- Hover Action -->
                        <div class="absolute bottom-6 left-6 right-6 z-20 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition duration-300">
                            <button class="w-full py-4 bg-lime-400 text-navy-950 font-black rounded-xl hover:bg-lime-500 transition">
                                CUSTOM SEKARANG
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-bold text-white mb-1 group-hover:text-lime-400 transition">{{ $product['name'] }}</h3>
                            <p class="text-slate-500 text-sm">Base Material: Dryfit Milano</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-lime-400 font-bold text-lg">Rp {{ $product['price'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- BIG CTA -->
    <section class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-lime-500">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
            <div class="absolute right-0 top-0 w-[600px] h-[600px] bg-white/20 rounded-full blur-[100px] translate-x-1/3 -translate-y-1/3"></div>
        </div>
        
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10" data-aos="zoom-in">
            <h2 class="text-5xl md:text-6xl font-black text-navy-950 mb-8 tracking-tight">
                SIAP MENCETAK <br> SEJARAH BARU?
            </h2>
            <p class="text-xl text-navy-900 font-medium mb-12 max-w-2xl mx-auto">
                Jangan biarkan tim hebatmu tampil biasa saja. Buat identitas profesional yang membanggakan sekarang juga.
            </p>
            <div class="flex justify-center gap-6">
                <a href="#" class="px-10 py-5 bg-navy-950 text-white text-xl font-black rounded-full shadow-2xl hover:scale-105 transition duration-300">
                    BUAT JERSEY SEKARANG
                </a>
            </div>
        </div>
    </section>

    @endsection