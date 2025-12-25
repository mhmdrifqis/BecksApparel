<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Becks Apparel</title>
    
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
</head>
<body class="font-sans antialiased h-screen overflow-hidden">

    <!-- OVERLAY BACKGROUND (Kesan Popup) -->
    <div class="fixed inset-0 backdrop-overlay z-0"></div>

    <!-- MAIN CONTAINER (Centered Modal) -->
    <div class="fixed inset-0 flex items-center justify-center p-4 z-10">
        
        <!-- CLOSE BUTTON (X) - Menuju Landing Page -->
        <a href="{{ url('/') }}" class="absolute top-6 right-6 text-slate-400 hover:text-white transition-transform hover:rotate-90 z-50 p-2 bg-black/30 rounded-full backdrop-blur">
            <i data-lucide="x" class="w-8 h-8"></i>
        </a>

        <!-- MODAL CARD -->
        <div class="w-full max-w-5xl grid lg:grid-cols-2 bg-navy-900 rounded-3xl overflow-hidden shadow-2xl border border-white/10 animate-fadeIn relative">
            
            <!-- KIRI: FORM REGISTER -->
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
                    
                    <h1 class="text-3xl font-black text-white mb-2 leading-tight">
                        Buat Akun Baru
                    </h1>
                    <p class="text-slate-400 text-sm">Daftarkan diri Anda untuk mulai membuat jersey impian.</p>
                </div>

                <!-- FORM REGISTER -->
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Validation Errors -->
                    @if($errors->any())
                        <div class="mb-4 text-sm text-red-400 bg-red-400/10 border border-red-400/30 rounded-xl p-3">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Name -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase">Nama Lengkap</label>
                        <div class="relative group">
                            <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition @error('name') border-red-400 @enderror" 
                                placeholder="Masukkan nama lengkap...">
                        </div>
                        @error('name')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase">Email Address</label>
                        <div class="relative group">
                            <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition @error('email') border-red-400 @enderror" 
                                placeholder="Masukkan email...">
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase">Nomor Telepon</label>
                        <div class="relative group">
                            <i data-lucide="phone" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                            <input type="tel" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required autocomplete="tel" maxlength="15"
                                class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition @error('nomor_telepon') border-red-400 @enderror" 
                                placeholder="081234567890">
                        </div>
                        @error('nomor_telepon')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase">Password</label>
                        <div class="relative group">
                            <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                            <input type="password" name="password" required autocomplete="new-password"
                                class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition @error('password') border-red-400 @enderror"
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase">Konfirmasi Password</label>
                        <div class="relative group">
                            <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                            <input type="password" name="password_confirmation" required autocomplete="new-password"
                                class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" 
                        class="w-full bg-lime-400 hover:bg-lime-500 text-navy-950 font-black text-lg py-4 rounded-xl shadow-lg shadow-lime-400/20 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2 mt-4">
                        <span>DAFTAR SEKARANG</span>
                        <i data-lucide="arrow-right" width="20"></i>
                    </button>

                    <div class="text-center mt-4">
                        <p class="text-sm text-slate-400">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-lime-400 hover:text-lime-500 font-bold underline">Masuk sekarang</a>
                        </p>
                    </div>
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
                            "Bergabunglah dengan<br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-green-400">Komunitas Kreator."</span>
                        </h2>
                        <p class="text-slate-400 text-sm leading-relaxed mb-8">
                            Mulai perjalanan Anda dalam menciptakan identitas visual yang unik untuk tim Anda. Daftar sekarang dan dapatkan akses ke semua fitur premium.
                        </p>
                        
                        <!-- Mini Stats -->
                        <div class="flex gap-6 border-t border-white/10 pt-6">
                            <div>
                                <p class="text-xl font-bold text-white">12k+</p>
                                <p class="text-xs text-slate-500 uppercase">Pengguna Aktif</p>
                            </div>
                            <div>
                                <p class="text-xl font-bold text-white">4.9/5</p>
                                <p class="text-xs text-slate-500 uppercase">Rating Kepuasan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
    
</body>
</html>

