<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Becks Apparel</title>
    
    <!-- 1. Favicon -->
    <link rel="icon" href="{{ asset('images/Logo-Becks-Crop.png') }}" type="image/png">

    <!-- 2. Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 950: '#020617', 900: '#0f172a', 800: '#1e293b' },
                        lime: { 400: '#a3e635', 500: '#84cc16' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Montserrat', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fadeIn': 'fadeIn 0.5s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'scale(0.95)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- 3. Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Project styles -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- 5. Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Login app script (centralized) -->
    <script src="{{ asset('js/login-app.js') }}"></script>
</head>
<body class="font-sans antialiased h-screen overflow-hidden">

    <!-- OVERLAY BACKGROUND (Kesan Popup) -->
    <div class="fixed inset-0 backdrop-overlay z-0"></div>

    <!-- MAIN CONTAINER (Centered Modal) -->
    <div class="fixed inset-0 flex items-center justify-center p-4 z-10" 
         x-data="loginApp()">
        
        <!-- CLOSE BUTTON (X) - Menuju Landing Page -->
        <a href="{{ url('/') }}" class="absolute top-6 right-6 text-slate-400 hover:text-white transition-transform hover:rotate-90 z-50 p-2 bg-black/30 rounded-full backdrop-blur">
            <i data-lucide="x" class="w-8 h-8"></i>
        </a>

        <!-- MODAL CARD -->
        <div class="w-full max-w-5xl grid lg:grid-cols-2 bg-navy-900 rounded-3xl overflow-hidden shadow-2xl border border-white/10 animate-fadeIn relative">
            
            <!-- KIRI: FORM LOGIN -->
            <div class="p-8 lg:p-12 flex flex-col justify-center bg-navy-950 relative">
                
                <!-- Header -->
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="relative inline-flex items-center">
                            <span class="absolute -inset-1 rounded-md bg-lime-400 opacity-100 "></span>
                            <img src="{{ asset('images/Logo-Becks-Crop.png') }}" class="w-8 h-8 object-contain relative z-10" alt="Logo">
                        </div>
                        <span class="font-black text-2xl text-white tracking-widest">BECKS<span class="text-lime-400">APPAREL</span></span>
                    </div>
                    
                    <!-- DINAMIS: Teks Selamat Datang berubah sesuai Role -->
                    <h1 class="text-3xl font-black text-white mb-2 leading-tight">
                        Selamat Datang,<br>
                        <span x-text="roles[activeRole].label" class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-green-400 transition-all duration-300"></span>
                    </h1>
                    <p class="text-slate-400 text-sm">Silakan masukkan kredensial akun Anda.</p>
                </div>

                <!-- ROLE SELECTOR -->
                <p class="text-xs font-bold text-slate-500 uppercase mb-3">Pilih Peran (Ubah Tipe Login)</p>
                <div class="grid grid-cols-3 gap-3 mb-8">
                    <template x-for="(role, key) in roles" :key="key">
                        <button 
                            @click="setRole(key)"
                            :class="activeRole === key ? 'border-lime-400 bg-lime-400/10 text-white' : 'border-slate-800 bg-slate-900/50 text-slate-500 hover:border-slate-600'"
                            class="flex flex-col items-center justify-center p-3 rounded-xl border transition-all duration-300 hover:bg-slate-800">
                            <i :data-lucide="role.icon" :class="activeRole === key ? 'text-lime-400' : 'text-slate-500'" width="20" class="mb-2"></i>
                            <span class="text-[10px] font-bold uppercase tracking-wide" x-text="role.shortName"></span>
                        </button>
                    </template>
                </div>

                <!-- FORM INPUT MANUAL -->
                <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="role" :value="activeRole" />
                    @if(session('error'))
                        <div class="text-red-400 text-sm">{{ session('error') }}</div>
                    @endif
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase">Email Address</label>
                        <div class="relative group">
                            <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                            <!-- INPUT MANUAL (Kosong by default) -->
                            <input type="email" name="email" x-model="email" required
                                class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition" 
                                placeholder="Ketikan email anda...">
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-xs font-bold text-slate-300 uppercase">Password</label>
                            <a href="#" class="text-xs text-lime-400 hover:underline">Lupa password?</a>
                        </div>
                        <div class="relative group">
                            <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                            <!-- INPUT MANUAL (Kosong by default) -->
                            <input type="password" name="password" x-model="password" required
                                class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" 
                        class="w-full bg-lime-400 hover:bg-lime-500 text-navy-950 font-black text-lg py-4 rounded-xl shadow-lg shadow-lime-400/20 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2 mt-4">
                        <span>MASUK SEKARANG</span>
                        <i data-lucide="arrow-right" width="20"></i>
                    </button>
                </form>
            </div>

            <!-- KANAN: VISUAL / PROMO -->
            <div class="hidden lg:flex flex-col relative bg-navy-800 overflow-hidden">
                <!-- Background Image -->
                <div class="absolute inset-0">
                    <img src="https://i.pinimg.com/1200x/15/23/05/15230562cbe539dfcabd0bcc87e1a37d.jpg" 
                         class="w-full h-full object-cover opacity-50 mix-blend-overlay">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-900 via-transparent to-transparent"></div>
                </div>

                <div class="relative z-10 flex-1 flex flex-col justify-between p-12">
                    <div class="flex justify-end">
                        <div class="bg-white/10 backdrop-blur border border-white/10 px-4 py-1.5 rounded-full flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            <span class="text-xs font-bold text-white">System Operational</span>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-3xl font-black text-white mb-4 leading-tight">
                            "Desain Jersey<br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-green-400">Semudah Bermain Game."</span>
                        </h2>
                        <p class="text-slate-400 text-sm leading-relaxed mb-8">
                            Bergabunglah dengan ribuan tim yang telah mempercayakan identitas visual mereka pada teknologi manufaktur digital kami.
                        </p>
                        
                        <!-- Mini Stats -->
                        <div class="flex gap-6 border-t border-white/10 pt-6">
                            <div>
                                <p class="text-xl font-bold text-white">12k+</p>
                                <p class="text-xs text-slate-500 uppercase">Jersey Dicetak</p>
                            </div>
                            <div>
                                <p class="text-xl font-bold text-white">4.9/5</p>
                                <p class="text-xs text-slate-500 uppercase">Rating Mitra</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- login-app.js initializes icons and handles loginApp -->
    
</body>
</html>