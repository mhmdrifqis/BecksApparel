<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Becks Apparel - The Future of Custom Sportswear</title>
     <link rel="icon" href="{{ asset('images/Logo-Becks-Crop.png') }}" type="image/png">

    <!-- 1. Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 950: '#020617', 900: '#0f172a', 800: '#1e293b' },
                        lime: { 400: '#a3e635', 500: '#84cc16', 600: '#65a30d' },
                        accent: { cyan: '#06b6d4', purple: '#8b5cf6' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Montserrat', 'sans-serif'], // Font untuk Headings
                    },
                    backgroundImage: {
                        'hero-pattern': "url('https://www.transparenttextures.com/patterns/cubes.png')",
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- 2. Google Fonts (Montserrat untuk kesan Megah) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Montserrat:ital,wght@0,700;0,900;1,900&display=swap" rel="stylesheet">

    <!-- 3. AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- 4. Alpine.js & Lucide Icons -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Project styles -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- Login app (moved to public JS) -->
    <script src="{{ asset('js/login-app.js') }}"></script>
</head>
<body x-data="loginApp()" class="bg-navy-950 text-slate-200 antialiased overflow-x-hidden selection:bg-lime-400 selection:text-navy-950">

    <!-- NAVBAR (Glassmorphism) -->
    <nav class="fixed w-full z-50 transition-all duration-300 glass" x-data="{ scrolled: false, mobileOpen: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-24">
                
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 cursor-pointer group" data-aos="fade-right">
                    <div class="relative p-1.5 rounded-md">
                        <div class="absolute -inset-1 bg-lime-400 rounded-md opacity-60 group-hover:opacity-100 transition duration-500 shadow-sm"></div>
                        <img src="{{ asset('images/Logo-Becks-Crop.png') }}" alt="Becks Apparel" class="h-10 w-auto relative z-10 rounded-sm">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-black text-2xl text-white tracking-widest">BECKS<span class="text-lime-400">APPAREL</span></span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-10" data-aos="fade-down" data-aos-delay="100">
                    <a href="#home" class="text-sm font-bold text-white hover:text-lime-400 transition tracking-wide">HOME</a>
                    <a href="#features" class="text-sm font-bold text-white hover:text-lime-400 transition tracking-wide">FITUR</a>
                    <a href="#process" class="text-sm font-bold text-white hover:text-lime-400 transition tracking-wide">CARA KERJA</a>
                    <a href="#catalog" class="text-sm font-bold text-white hover:text-lime-400 transition tracking-wide">KATALOG</a>
                </div>

                <!-- CTA Button -->
               <div class="hidden lg:flex items-center gap-6" data-aos="fade-left">
                    @if(session('user'))
                        @php $role = session('user.role') ?? null; @endphp
                        <span class="text-sm font-bold text-white">Hi, {{ session('user.name') }}</span>
                        <a href="{{ $role === 'customer' ? route('customer.dashboard') : ($role === 'production' ? route('production.dashboard') : route('admin.dashboard')) }}" class="text-sm font-bold text-white hover:text-lime-400 transition">DASHBOARD</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-bold text-white hover:text-red-400 transition">LOGOUT</button>
                        </form>
                    @else
                        <a href="#" @click.prevent="openLogin" class="text-sm font-bold text-white hover:text-lime-400 transition cursor-pointer">LOGIN</a>
                    @endif

                    <a href="#" class="relative group px-8 py-3 bg-transparent overflow-hidden rounded-full">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-br from-lime-400 to-lime-600 group-hover:from-lime-500 group-hover:to-lime-700 transition-all duration-300"></span>
                        <span class="relative text-navy-950 font-black tracking-wide flex items-center gap-2">
                            MULAI DESAIN <i data-lucide="arrow-right" width="18"></i>
                        </span>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden">
                    <button @click="mobileOpen = !mobileOpen" class="text-white p-2 hover:text-lime-400 transition">
                        <i data-lucide="menu" x-show="!mobileOpen"></i>
                        <i data-lucide="x" x-show="mobileOpen" style="display: none;"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Dropdown -->
        <div x-show="mobileOpen" x-transition class="lg:hidden bg-navy-900 border-t border-slate-800 absolute w-full glass">
            <div class="px-6 py-8 space-y-4">
                <a href="#home" class="block text-white font-bold text-lg">HOME</a>
                <a href="#features" class="block text-slate-400 font-bold text-lg">FITUR</a>
                <a href="#process" class="block text-slate-400 font-bold text-lg">CARA KERJA</a>
                <a href="#catalog" class="block text-slate-400 font-bold text-lg">KATALOG</a>
                <a href="#" class="block w-full text-center mt-8 bg-lime-400 text-navy-950 py-4 rounded-xl font-black text-xl">BUAT CUSTOM SEKARANG</a>
            </div>
        </div>
    </nav>

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

    <!-- FOOTER -->
    <footer class="bg-navy-950 pt-24 pb-12 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-12 gap-12 mb-16">
                <!-- Brand -->
                <div class="md:col-span-5">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="relative p-1.5 rounded-md"> 
                            <div class="absolute -inset-1 bg-lime-400 rounded-md opacity-60 group-hover:opacity-100 transition duration-500 shadow-sm"></div>
                            <img src="{{ asset('images/Logo-Becks-Crop.png') }}" alt="Becks Apparel" class="h-10 w-auto relative z-10 rounded-sm ">
                        </div>
                        <span class="font-black text-2xl text-white tracking-widest">BECKS<span class="text-lime-400">APPAREL</span></span>
                    </div>
                    <p class="text-slate-400 leading-relaxed mb-8 max-w-sm">
                        Platform manufaktur olahraga digital pertama yang menghubungkan kreativitas tim Anda dengan kualitas produksi standar internasional.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-lime-400 hover:text-navy-950 transition"><i data-lucide="instagram" width="18"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-lime-400 hover:text-navy-950 transition"><i data-lucide="facebook" width="18"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-lime-400 hover:text-navy-950 transition"><i data-lucide="twitter" width="18"></i></a>
                    </div>
                </div>

                <!-- Links -->
                <div class="md:col-span-3">
                    <h4 class="text-white font-bold uppercase tracking-widest mb-8">Menu</h4>
                    <ul class="space-y-4 text-slate-400">
                        <li><a href="#" class="hover:text-lime-400 transition">Beranda</a></li>
                        <li><a href="#" class="hover:text-lime-400 transition">Studio Desain</a></li>
                        <li><a href="#" class="hover:text-lime-400 transition">Katalog</a></li>
                        <li><a href="#" class="hover:text-lime-400 transition">Tracking Order</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="md:col-span-4">
                    <h4 class="text-white font-bold uppercase tracking-widest mb-8">Hubungi Kami</h4>
                    <ul class="space-y-6 text-slate-400">
                        <li class="flex gap-4 items-start">
                            <i data-lucide="map-pin" class="text-lime-400 shrink-0 mt-1"></i>
                            <span>Komplek Villa Bintaro Indah Blok D2 No. 18,<br>Ciputat, Tangerang Selatan</span>
                        </li>
                        <li class="flex gap-4 items-center">
                            <i data-lucide="phone" class="text-lime-400 shrink-0"></i>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex gap-4 items-center">
                            <i data-lucide="mail" class="text-lime-400 shrink-0"></i>
                            <span>becksapparel2018@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500">
                <p>&copy; 2025 Becks Apparel. PT Bola Media Sportainment.</p>
                <p>Project Work: Alfi, Alfred, Rifqi</p>
            </div>
        </div>
    </footer>

    <!-- Init Libraries -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init Icons
        lucide.createIcons();
        
        // Init Animations
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
        });
    </script>
    
    {{-- Include login modal partial --}}
    @include('partials.login-modal')
</body>
</html>