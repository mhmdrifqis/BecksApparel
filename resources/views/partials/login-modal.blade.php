<!-- Login Modal Partial - included into welcome.blade.php -->
<div x-show="showLogin" x-cloak class="fixed inset-0 z-50 flex items-center justify-center" aria-hidden="true">
    <!-- Overlay -->
    <div @click="closeLogin()" class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>

    <!-- Modal Card -->
    <div class="relative w-full max-w-4xl mx-4 lg:mx-0 bg-navy-900 rounded-3xl overflow-hidden shadow-2xl border border-white/10 z-50">
        <div class="grid lg:grid-cols-2">
            <!-- Left: Login Form -->
            <div class="p-8 lg:p-12 flex flex-col justify-center bg-navy-950">
                <a @click.prevent="closeLogin()" class="absolute top-6 right-6 text-slate-400 hover:text-white z-50 p-2 bg-black/30 rounded-full backdrop-blur cursor-pointer">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </a>

                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="relative inline-flex items-center">
                            <span class="absolute -inset-1 rounded-md bg-lime-400"></span>
                            <img src="{{ asset('images/Logo-Becks-Crop.png') }}" class="w-8 h-8 object-contain relative z-10" alt="Logo">
                        </div>
                        <span class="font-black text-2xl text-white tracking-widest">BECKS<span class="text-lime-400">APPAREL</span></span>
                    </div>

                    <h1 class="text-3xl font-black text-white mb-2 leading-tight">
                        Selamat Datang,<br>
                        <span x-text="roles[activeRole].label" class="text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-green-400"></span>
                    </h1>
                    <p class="text-slate-400 text-sm">Silakan masukkan kredensial akun Anda.</p>
                </div>

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

                <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="role" :value="activeRole" />
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase">Email Address</label>
                        <div class="relative group">
                            <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
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

            <!-- Right: Promo Visual (optional) -->
            <div class="hidden lg:flex flex-col relative bg-navy-800 overflow-hidden">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- icons initialisation handled by global JS (login-app.js) -->
