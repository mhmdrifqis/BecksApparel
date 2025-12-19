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
                    <a href="/" class="text-sm font-bold text-white hover:text-lime-400 transition tracking-wide">HOME</a>
                    <a href="/gallery" class="text-sm font-bold text-white hover:text-lime-400 transition tracking-wide">GALLERY</a>
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

                    <a href="/features/ai-design" class="relative group px-8 py-3 bg-transparent overflow-hidden rounded-full">
                        <span class="absolute inset-0 w-full h-full bg-linear-to-br from-lime-400 to-lime-600 group-hover:from-lime-500 group-hover:to-lime-700 transition-all duration-300"></span>
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
                <a href="/gallery" class="block text-white font-bold text-lg">GALLERY</a>
                <a href="#features" class="block text-slate-400 font-bold text-lg">FITUR</a>
                <a href="#process" class="block text-slate-400 font-bold text-lg">CARA KERJA</a>
                <a href="#catalog" class="block text-slate-400 font-bold text-lg">KATALOG</a>
                <a href="/design" class="block w-full text-center mt-8 bg-lime-400 text-navy-950 py-4 rounded-xl font-black text-xl">BUAT CUSTOM SEKARANG</a>
            </div>
        </div>
    </nav>