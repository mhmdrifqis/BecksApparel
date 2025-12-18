<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - Becks Apparel</title>
    <link rel="icon" href="{{ asset('images/Logo-Becks-Crop.png') }}" type="image/png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 950: '#020617', 900: '#0f172a', 800: '#1e293b' },
                        lime: { 400: '#a3e635', 500: '#84cc16' }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- App Logic (Must be defined before Alpine loads or use defer correctly) -->
    <script>
        function customerApp() {
            return {
                activeTab: 'home',
                menuItems: [
                    { id: 'home', label: 'Dashboard', icon: 'layout-dashboard' },
                    { id: 'design', label: 'Studio Desain', icon: 'palette' },
                    { id: 'orders', label: 'Pesanan Saya', icon: 'shopping-bag' },
                    { id: 'settings', label: 'Pengaturan', icon: 'settings' }
                ],
                jerseyConfig: {
                    color: '#1e293b', // Default Navy
                    name: 'ALFI',
                    number: '10'
                },
                colors: ['#1e293b', '#dc2626', '#166534', '#2563eb', '#ffffff', '#ea580c'],
                
                init() {
                    // Re-init icons when tab changes
                    this.$watch('activeTab', () => {
                        setTimeout(() => lucide.createIcons(), 50);
                    });
                    // Re-init icons when sidebar toggles
                    this.$watch('sidebarOpen', () => {
                        setTimeout(() => lucide.createIcons(), 50);
                    });
                },
                // Sidebar state: true = expanded, false = collapsed
                sidebarOpen: true,
                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                    try { localStorage.setItem('becks_sidebar', this.sidebarOpen ? '1' : '0'); } catch(e){}
                },
                saveDesign() {
                    // Gunakan alert browser bawaan atau modal custom
                    // alert('Desain berhasil disimpan! Mengarahkan ke pembayaran...');
                    console.log('Desain disimpan');
                    this.activeTab = 'orders';
                }
            }
        }

        function chatbot() {
            return {
                open: false,
                input: '',
                messages: [],
                send() {
                    if(!this.input) return;
                    this.messages.push({ text: this.input, sender: 'user' });
                    
                    const userInput = this.input.toLowerCase();
                    this.input = '';

                    // Simulasi AI Response
                    setTimeout(() => {
                        let reply = "Maaf, saya bot demo. Silakan hubungi admin WA.";
                        if(userInput.includes('harga')) reply = "Harga mulai Rp 125.000 kak!";
                        if(userInput.includes('lama')) reply = "Estimasi produksi 14 hari kerja.";
                        
                        this.messages.push({ text: reply, sender: 'bot' });
                        // Scroll to bottom
                        setTimeout(() => {
                            const el = document.getElementById('chatLogs');
                            if(el) el.scrollTop = el.scrollHeight;
                        }, 50);
                    }, 1000);
                }
            }
        }
    </script>

    <!-- Alpine.js (Add defer to ensure DOM is ready) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a3e635; }
        
        .glass-panel {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="bg-navy-950 text-slate-200 font-sans overflow-hidden" x-data="customerApp()">

    <div class="flex h-screen">
        
        <!-- SIDEBAR (minimizable) -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-navy-900 border-r border-slate-800 flex-col hidden md:flex z-20 transition-all duration-300">
            <div class="h-20 flex items-center justify-between border-b border-slate-800 px-3">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/Logo-Becks-Crop.png') }}" class="w-8 h-8" alt="Logo" onerror="this.src='https://via.placeholder.com/32'">
                    <span class="font-bold text-xl text-white tracking-wide" x-show="sidebarOpen">BECKS<span class="text-lime-400">APPAREL</span></span>
                </div>
                <button @click="toggleSidebar()" class="p-2 rounded-md text-slate-300 hover:text-white">
                    <i x-show="sidebarOpen" data-lucide="chevrons-left" class="w-5 h-5"></i>
                    <i x-show="!sidebarOpen" data-lucide="chevrons-right" class="w-5 h-5"></i>
                </button>
            </div>

            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <template x-for="item in menuItems" :key="item.id">
                    <button @click="activeTab = item.id"
                        :class="activeTab === item.id ? 'bg-lime-400 text-navy-950 font-bold shadow-[0_0_15px_rgba(163,230,53,0.3)]' : 'text-slate-400 hover:bg-slate-800 hover:text-white'"
                        class="flex items-center gap-3 w-full p-3 rounded-xl transition-all duration-300">
                        <i :data-lucide="item.icon" width="20"></i>
                        <span x-show="sidebarOpen" x-text="item.label"></span>
                    </button>
                </template>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full p-3 rounded-xl text-slate-400 hover:text-red-400 hover:bg-red-500/10 transition">
                        <i data-lucide="log-out" width="20"></i>
                        <span x-show="sidebarOpen">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col relative h-full overflow-hidden">
            
            <!-- HEADER MOBILE & DESKTOP -->
            <header class="h-20 bg-navy-900/80 backdrop-blur-md border-b border-slate-800 flex items-center justify-between px-6 sticky top-0 z-10">
                <div class="flex items-center gap-4 md:hidden">
                    <img src="{{ asset('images/Logo-Becks-Crop.png') }}" class="w-8 h-8" alt="Logo" onerror="this.src='https://via.placeholder.com/32'">
                </div>
                
                <h2 class="text-xl font-bold text-white hidden md:block" x-text="activeTab === 'dashboard' ? 'Dashboard' : (menuItems.find(i => i.id === activeTab)?.label || 'Menu')"></h2>

                <div class="flex items-center gap-6">
                    <div class="relative cursor-pointer">
                        <i data-lucide="bell" class="text-slate-400 hover:text-white transition"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                    </div>
                    <!-- Link to landing page (preserve session) -->
                    <a href="{{ route('home') }}" class="hidden md:inline-block bg-lime-400 text-navy-950 px-3 py-2 rounded-md font-bold hover:brightness-95 transition">HOME</a>
                    <div class="flex items-center gap-3 pl-6 border-l border-slate-700">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-white">Alfi Ardiansyah</p>
                            <p class="text-xs text-lime-400">Pelanggan #CUST-001</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-slate-700 border-2 border-lime-400 p-0.5 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name=Alfi+Ardiansyah&background=random" class="rounded-full w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </header>

            <!-- CONTENT BODY -->
            <div class="flex-1 overflow-y-auto p-6 scroll-smooth" x-data>
                
                <!-- TAB: BERANDA -->
                <div x-show="activeTab === 'home'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <!-- Hero Banner -->
                    <div class="relative rounded-3xl overflow-hidden bg-linear-to-r from-lime-500 to-emerald-600 p-8 md:p-12 mb-8 shadow-2xl">
                        <div class="relative z-10 max-w-2xl">
                            <span class="bg-black/20 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-4 inline-block">Selamat Datang Kembali</span>
                            <h1 class="text-4xl md:text-5xl font-black text-white mb-4 italic">WUJUDKAN IDENTITAS TIM KAMU.</h1>
                            <p class="text-navy-950 font-medium text-lg mb-8 max-w-lg">Desain jersey impianmu sekarang dengan teknologi 2D Canvas kami. Cepat, Mudah, dan Berkualitas.</p>
                            <button @click="activeTab = 'design'" class="bg-navy-950 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:scale-105 transition flex items-center gap-2">
                                <i data-lucide="palette"></i> Mulai Desain Sekarang
                            </button>
                        </div>
                        <div class="absolute right-0 top-0 h-full w-1/2 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-30 mix-blend-overlay"></div>
                        <img src="https://images.unsplash.com/photo-1522778119026-d647f0565c6a?auto=format&fit=crop&q=80" class="absolute right-0 top-0 h-full w-2/3 object-cover opacity-20 mask-image-gradient">
                    </div>

                    <!-- Active Order Widget -->
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2"><i data-lucide="clock" class="text-lime-400"></i> Pesanan Aktif</h3>
                    <div class="bg-navy-900 border border-slate-700 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between gap-6 hover:border-lime-500/50 transition cursor-pointer" @click="activeTab = 'orders'">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-slate-800 rounded-xl flex items-center justify-center border border-slate-700">
                                <i data-lucide="shirt" class="text-blue-400 w-8 h-8"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-lg">Jersey Futsal "Garuda FC"</h4>
                                <p class="text-slate-400 text-sm">Invoice: #INV-2025-001</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                    <span class="text-xs font-bold text-yellow-500 uppercase">Tahap Produksi (Jahit)</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-slate-400 hover:text-white transition">
                            <span>Lacak Detail</span>
                            <i data-lucide="chevron-right"></i>
                        </div>
                    </div>
                </div>

                <!-- TAB: STUDIO DESAIN (CUSTOMIZER) -->
                <div x-show="activeTab === 'design'" class="h-full flex flex-col lg:flex-row gap-6">
                    <!-- Canvas Area -->
                    <div class="flex-1 bg-navy-900 border border-slate-700 rounded-2xl relative flex items-center justify-center p-8 overflow-hidden min-h-[500px]">
                        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
                        
                        <!-- Jersey SVG Visualization -->
                        <div class="relative w-full max-w-md transition-all duration-500 transform hover:scale-105">
                            <svg viewBox="0 0 500 500" class="w-full h-full drop-shadow-2xl">
                                <!-- Base Jersey -->
                                <path d="M150 50 L350 50 L420 150 L380 180 L350 140 L350 450 L150 450 L150 140 L120 180 L80 150 Z" 
                                      :fill="jerseyConfig.color" stroke="none" class="transition-colors duration-300"/>
                                
                                <!-- Collar & Accents -->
                                <path d="M200 50 Q250 100 300 50" fill="none" stroke="#a3e635" stroke-width="5" />
                                <line x1="120" y1="180" x2="80" y2="150" stroke="#a3e635" stroke-width="2" />
                                <line x1="380" y1="180" x2="420" y2="150" stroke="#a3e635" stroke-width="2" />
                                
                                <!-- User Custom Text -->
                                <text x="50%" y="220" text-anchor="middle" 
                                      :fill="jerseyConfig.color === '#ffffff' ? 'black' : 'white'" 
                                      font-size="45" font-family="Arial, sans-serif" font-weight="bold" letter-spacing="4"
                                      x-text="jerseyConfig.name"></text>
                                
                                <text x="50%" y="380" text-anchor="middle" 
                                      :fill="jerseyConfig.color === '#ffffff' ? 'black' : 'white'" 
                                      font-size="140" font-family="Arial, sans-serif" font-weight="bold" 
                                      stroke="rgba(0,0,0,0.2)" stroke-width="2"
                                      x-text="jerseyConfig.number"></text>
                            </svg>
                        </div>

                        <!-- Floating Price -->
                        <div class="absolute top-6 right-6 glass-panel px-4 py-2 rounded-xl text-right">
                            <p class="text-xs text-slate-400">Estimasi Biaya</p>
                            <p class="text-xl font-bold text-lime-400">Rp 135.000</p>
                        </div>
                    </div>

                    <!-- Tools Panel -->
                    <div class="w-full lg:w-96 bg-navy-900 border border-slate-700 rounded-2xl p-6 flex flex-col gap-6 overflow-y-auto">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2"><i data-lucide="sliders"></i> Konfigurasi</h3>
                        
                        <!-- Color Picker -->
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase mb-3 block">Warna Dasar</label>
                            <div class="flex flex-wrap gap-3">
                                <template x-for="color in colors" :key="color">
                                    <button @click="jerseyConfig.color = color"
                                        class="w-10 h-10 rounded-full border-2 transition-transform hover:scale-110"
                                        :class="jerseyConfig.color === color ? 'border-lime-400 ring-2 ring-lime-400/20' : 'border-slate-600'"
                                        :style="`background-color: ${color}`">
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- Text Inputs -->
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase mb-2 block">Nama Punggung</label>
                                <input type="text" x-model="jerseyConfig.name" maxlength="10" 
                                       class="w-full bg-navy-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition"
                                       placeholder="Contoh: RONALDO">
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <label class="text-xs font-bold text-slate-400 uppercase mb-2 block">Nomor</label>
                                    <input type="number" x-model="jerseyConfig.number" maxlength="2" 
                                           class="w-full bg-navy-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition"
                                           placeholder="07">
                                </div>
                                <div class="flex-1">
                                    <label class="text-xs font-bold text-slate-400 uppercase mb-2 block">Ukuran</label>
                                    <select class="w-full bg-navy-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-lime-400 transition">
                                        <option>S</option>
                                        <option>M</option>
                                        <option selected>L</option>
                                        <option>XL</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto pt-6 border-t border-slate-800">
                            <button @click="saveDesign()" class="w-full bg-lime-500 hover:bg-lime-600 text-navy-950 font-black py-4 rounded-xl flex items-center justify-center gap-2 transition shadow-lg shadow-lime-500/20">
                                <i data-lucide="shopping-cart"></i> SIMPAN & PESAN
                            </button>
                        </div>
                    </div>
                </div>

                <!-- TAB: LACAK PESANAN -->
                <div x-show="activeTab === 'orders'" class="max-w-4xl mx-auto space-y-6">
                    <h2 class="text-2xl font-bold text-white mb-6">Status Pesanan Saya</h2>
                    
                    <!-- Order Card -->
                    <div class="bg-navy-900 border border-slate-700 rounded-2xl overflow-hidden">
                        <div class="p-6 border-b border-slate-800 flex flex-wrap justify-between items-start gap-4">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="bg-slate-800 text-slate-400 px-3 py-1 rounded-lg text-xs font-mono border border-slate-700">#INV-2025-001</span>
                                    <span class="bg-yellow-500/20 text-yellow-500 px-3 py-1 rounded-lg text-xs font-bold uppercase border border-yellow-500/20 animate-pulse">Sedang Produksi</span>
                                </div>
                                <h3 class="text-xl font-bold text-white">Jersey Futsal "Garuda FC" (12 Pcs)</h3>
                                <p class="text-sm text-slate-400 mt-1">Estimasi Selesai: <span class="text-white font-bold">14 Des 2025</span></p>
                            </div>
                            <button class="text-sm border border-slate-600 px-4 py-2 rounded-lg hover:bg-slate-800 transition">Lihat Invoice</button>
                        </div>

                        <!-- Tracking Timeline -->
                        <div class="p-8 bg-navy-950/50">
                            <div class="relative">
                                <!-- Progress Bar Background -->
                                <div class="h-1.5 bg-slate-800 rounded-full mb-10 overflow-hidden relative top-5 mx-8">
                                    <!-- Active Progress (60%) -->
                                    <div class="h-full bg-lime-500 w-[60%] rounded-full shadow-[0_0_10px_#84cc16]"></div>
                                </div>
                                
                                <div class="grid grid-cols-4 gap-2 text-center relative z-10">
                                    <!-- Step 1 -->
                                    <div class="flex flex-col items-center group">
                                        <div class="w-12 h-12 bg-lime-500 rounded-full flex items-center justify-center text-navy-950 border-4 border-navy-900 shadow-lg mb-3">
                                            <i data-lucide="check" width="20"></i>
                                        </div>
                                        <p class="text-white font-bold text-sm">Pesanan Dibuat</p>
                                        <p class="text-xs text-slate-500 mt-1">10 Des, 09:00</p>
                                    </div>
                                    <!-- Step 2 -->
                                    <div class="flex flex-col items-center group">
                                        <div class="w-12 h-12 bg-lime-500 rounded-full flex items-center justify-center text-navy-950 border-4 border-navy-900 shadow-lg mb-3">
                                            <i data-lucide="dollar-sign" width="20"></i>
                                        </div>
                                        <p class="text-white font-bold text-sm">Terbayar</p>
                                        <p class="text-xs text-slate-500 mt-1">10 Des, 09:15</p>
                                    </div>
                                    <!-- Step 3 (Active) -->
                                    <div class="flex flex-col items-center group">
                                        <div class="w-12 h-12 bg-navy-900 border-2 border-lime-500 text-lime-500 rounded-full flex items-center justify-center shadow-[0_0_15px_rgba(163,230,53,0.3)] mb-3 relative">
                                            <i data-lucide="scissors" width="20" class="animate-pulse"></i>
                                            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-lime-400 opacity-75"></span>
                                              <span class="relative inline-flex rounded-full h-3 w-3 bg-lime-500"></span>
                                            </span>
                                        </div>
                                        <p class="text-lime-400 font-bold text-sm">Produksi</p>
                                        <p class="text-xs text-slate-500 mt-1">Sedang Berlangsung</p>
                                    </div>
                                    <!-- Step 4 -->
                                    <div class="flex flex-col items-center opacity-50">
                                        <div class="w-12 h-12 bg-slate-800 rounded-full flex items-center justify-center text-slate-500 border-4 border-navy-900 mb-3">
                                            <i data-lucide="truck" width="20"></i>
                                        </div>
                                        <p class="text-slate-400 font-bold text-sm">Pengiriman</p>
                                        <p class="text-xs text-slate-500 mt-1">Menunggu</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Live Log Update -->
                        <div class="p-6 bg-navy-900 border-t border-slate-800">
                            <h4 class="text-xs font-bold text-slate-400 uppercase mb-4 flex items-center gap-2"><i data-lucide="activity"></i> Log Aktivitas Produksi</h4>
                            <div class="space-y-4 pl-4 border-l border-slate-700">
                                <div class="relative">
                                    <div class="absolute -left-[21px] top-1 w-3 h-3 bg-blue-500 rounded-full border-2 border-navy-900"></div>
                                    <p class="text-sm text-white">Bahan kain dipotong dan masuk antrian jahit.</p>
                                    <p class="text-xs text-slate-500">Baru saja - Oleh Tim Produksi A</p>
                                </div>
                                <div class="relative opacity-60">
                                    <div class="absolute -left-[21px] top-1 w-3 h-3 bg-slate-600 rounded-full border-2 border-navy-900"></div>
                                    <p class="text-sm text-white">Pembayaran via QRIS berhasil diverifikasi.</p>
                                    <p class="text-xs text-slate-500">10 Des, 09:15 - Sistem</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: SETTINGS (Placeholder) -->
                <div x-show="activeTab === 'settings'" class="max-w-4xl mx-auto">
                    <h2 class="text-2xl font-bold text-white mb-6">Pengaturan Akun</h2>
                    <div class="bg-navy-900 border border-slate-700 rounded-2xl p-8 text-center text-slate-400">
                        <i data-lucide="settings" class="mx-auto mb-4 w-12 h-12 opacity-50"></i>
                        <p>Fitur pengaturan profil akan segera hadir.</p>
                    </div>
                </div>

            </div>
        </main>

        <!-- CHATBOT WIDGET (GEMINI AI) -->
        <div x-data="chatbot()" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
            <div x-show="open" x-transition class="bg-navy-900 border border-slate-700 w-80 h-96 rounded-2xl shadow-2xl mb-4 flex flex-col overflow-hidden">
                <div class="bg-lime-500 p-4 flex justify-between items-center text-navy-950">
                    <span class="font-bold flex items-center gap-2"><i data-lucide="bot" width="18"></i> CS Otomatis</span>
                    <button @click="open = false"><i data-lucide="x" width="18"></i></button>
                </div>
                <div class="flex-1 p-4 overflow-y-auto space-y-3 bg-navy-950" id="chatLogs">
                    <div class="flex gap-2">
                        <div class="bg-slate-800 p-3 rounded-xl rounded-tl-none text-xs text-slate-300 border border-slate-700">
                            Halo Alfi! Ada yang bisa saya bantu tentang pesananmu?
                        </div>
                    </div>
                    <template x-for="(msg, index) in messages" :key="index">
                        <div :class="msg.sender === 'user' ? 'flex flex-row-reverse' : 'flex'">
                            <div class="p-3 rounded-xl text-xs max-w-[80%]" 
                                 :class="msg.sender === 'user' ? 'bg-lime-500 text-navy-950 rounded-tr-none' : 'bg-slate-800 text-slate-300 rounded-tl-none border border-slate-700'"
                                 x-text="msg.text"></div>
                        </div>
                    </template>
                </div>
                <form @submit.prevent="send" class="p-3 bg-navy-900 border-t border-slate-700 flex gap-2">
                    <input x-model="input" type="text" placeholder="Ketik pesan..." class="flex-1 bg-navy-950 border border-slate-700 rounded-lg px-3 text-xs text-white focus:border-lime-400 focus:outline-none">
                    <button type="submit" class="bg-lime-500 p-2 rounded-lg text-navy-950"><i data-lucide="send" width="14"></i></button>
                </form>
            </div>
            <button @click="open = !open" class="bg-lime-500 hover:bg-lime-400 text-navy-950 p-4 rounded-full shadow-lg transition-transform hover:scale-110">
                <i data-lucide="message-square" width="24"></i>
            </button>
        </div>

    </div>

    <!-- Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>