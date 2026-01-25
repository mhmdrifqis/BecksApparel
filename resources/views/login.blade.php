<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Becks Apparel</title>
    
    <link rel="icon" href="{{ asset('images/Logo-Becks-Crop.png') }}" type="image/png">

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
                        'fadeIn': 'fadeIn 0.5s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'scale(0.95)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-navy-950 min-h-screen relative">

    <div class="fixed inset-0 z-0 opacity-20 pointer-events-none">
         </div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">

            <a href="{{ url('/') }}" class="absolute top-6 right-6 text-slate-400 hover:text-white transition-transform hover:rotate-90 z-50 p-2 bg-black/30 rounded-full backdrop-blur cursor-pointer">
                <i data-lucide="x" class="w-8 h-8"></i>
            </a>

            <div class="w-full max-w-5xl grid lg:grid-cols-2 bg-navy-900 rounded-3xl overflow-hidden shadow-2xl border border-white/10 animate-fadeIn relative my-8">
                
                <div class="p-8 lg:p-12 flex flex-col justify-center bg-navy-950 relative">
                    
                    <div class="mb-8">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="relative inline-flex items-center">
                                <span class="absolute -inset-1 rounded-md bg-lime-400 opacity-100 blur-sm"></span>
                                <img src="{{ asset('images/Logo-Becks-Crop.png') }}" class="w-8 h-8 object-contain relative z-10" alt="Logo">
                            </div>
                            <span class="font-black text-2xl text-white tracking-widest">BECKS<span class="text-lime-400">APPAREL</span></span>
                        </div>
                        
                        <h1 class="text-3xl font-black text-white mb-2 leading-tight">
                            Selamat Datang Kembali
                        </h1>
                        <p class="text-slate-400 text-sm">Silakan masukkan kredensial akun Anda untuk melanjutkan.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        
                        @if(session('status'))
                            <div class="mb-4 text-sm text-lime-400 bg-lime-400/10 border border-lime-400/30 rounded-xl p-3">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="mb-4 text-sm text-red-400 bg-red-400/10 border border-red-400/30 rounded-xl p-3">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-2 uppercase">Email Address</label>
                            <div class="relative group">
                                <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition @error('email') border-red-400 @enderror" 
                                    placeholder="Ketikan email anda...">
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-xs font-bold text-slate-300 uppercase">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs text-lime-400 hover:underline">Lupa password?</a>
                                @endif
                            </div>
                            <div class="relative group">
                                <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                                <input type="password" name="password" required autocomplete="current-password"
                                    class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition @error('password') border-red-400 @enderror"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded bg-navy-900 border-slate-700 text-lime-400 focus:ring-lime-400 focus:ring-offset-navy-900 w-4 h-4">
                            <label for="remember_me" class="ml-2 text-sm text-slate-400 cursor-pointer select-none">Ingat saya</label>
                        </div>

                        <button type="submit" 
                            class="w-full bg-lime-400 hover:bg-lime-500 text-navy-950 font-black text-lg py-4 rounded-xl shadow-lg shadow-lime-400/20 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex items-center justify-center gap-2 mt-4">
                            <span>MASUK SEKARANG</span>
                            <i data-lucide="arrow-right" width="20"></i>
                        </button>

                        <div class="text-center mt-4">
                            <p class="text-sm text-slate-400">
                                Belum punya akun? 
                                <a href="{{ route('register') }}" class="text-lime-400 hover:text-lime-500 font-bold underline">Daftar sekarang</a>
                            </p>
                        </div>
                    </form>
                </div>

                <div class="hidden lg:flex flex-col relative bg-navy-800 overflow-hidden">
                    <div class="absolute inset-0">
                        <img src="{{ asset('images/login-bg.jpg') }}" 
                             onerror="this.src='https://images.unsplash.com/photo-1517466787929-bc90951d0974?q=80&w=1000&auto=format&fit=crop'"
                             class="w-full h-full object-cover opacity-50 mix-blend-overlay"
                             alt="Background">
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
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>