<nav class="bg-navy-900 fixed w-full z-50 top-0 start-0 border-b border-slate-800" 
     x-data="{ mobileOpen: false }">
    
    <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
        
        <a href="{{ route('home') }}" class="flex items-center gap-3 rtl:space-x-reverse">
            <div class="relative p-1 rounded-md">
                <div class="absolute -inset-0.5 bg-lime-400 rounded-md opacity-60 blur-sm"></div>
                <img src="{{ asset('images/Logo-Becks-Crop.png') }}" class="h-8 w-auto relative z-10 rounded-sm" alt="Becks Logo">
            </div>
            <span class="self-center text-xl font-black whitespace-nowrap text-white tracking-widest">
                BECKS<span class="text-lime-400">APPAREL</span>
            </span>
        </a>

        <div class="flex md:order-2 space-x-3 md:space-x-4 rtl:space-x-reverse items-center">
            
            @auth
                <div class="hidden md:flex items-center gap-4">
                    <span class="text-sm font-bold text-slate-300">Hi, {{ Auth::user()->name }}</span>
                    
                    <a href="{{ route('dashboard') }}" class="text-sm font-bold text-white hover:text-lime-400 transition">
    DASHBOARD
</a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-red-400 hover:text-red-300 transition">LOGOUT</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" 
                   class="text-navy-950 bg-lime-400 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-800 font-bold rounded-lg text-sm px-5 py-2.5 text-center transition-colors shadow-lg shadow-lime-400/20">
                    LOGIN
                </a>
            @endauth

            <button @click="mobileOpen = !mobileOpen" 
                    type="button" 
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-slate-400 rounded-lg md:hidden hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-600">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>

        <div :class="{'block': mobileOpen, 'hidden': !mobileOpen}" 
             class="items-center justify-between w-full md:flex md:w-auto md:order-1" 
             id="navbar-sticky">
            
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-bold border border-slate-800 rounded-lg bg-navy-800 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
    
                <li>
                    <a href="/" 
                    class="block py-2 px-3 rounded md:p-0 transition {{ Request::is('/') ? 'text-white bg-lime-600 md:bg-transparent md:text-lime-400' : 'text-slate-300 hover:bg-navy-700 md:hover:bg-transparent md:hover:text-lime-400' }}" 
                    aria-current="page">
                    HOME
                    </a>
                </li>

                <li>
                    <a href="/gallery" 
                    class="block py-2 px-3 rounded md:p-0 transition {{ Request::is('gallery*') ? 'text-white bg-lime-600 md:bg-transparent md:text-lime-400' : 'text-slate-300 hover:bg-navy-700 md:hover:bg-transparent md:hover:text-lime-400' }}">
                    GALLERY
                    </a>
                </li>

                <li>
                    <a href="#features" class="block py-2 px-3 text-slate-300 rounded hover:bg-navy-700 md:hover:bg-transparent md:hover:text-lime-400 md:p-0 transition">FITUR</a>
                </li>

                <li>
                    <a href="#process" class="block py-2 px-3 text-slate-300 rounded hover:bg-navy-700 md:hover:bg-transparent md:hover:text-lime-400 md:p-0 transition">CARA KERJA</a>
                </li>

                <li>
                    <a href="#catalog" class="block py-2 px-3 text-slate-300 rounded hover:bg-navy-700 md:hover:bg-transparent md:hover:text-lime-400 md:p-0 transition">KATALOG</a>
                </li>

                @auth
                    <li class="md:hidden pt-4 border-t border-slate-700 mt-2">
                        <span class="block px-3 text-xs text-slate-500 uppercase">User Menu</span>
                        <a href="{{ route('dashboard') }}" class="block py-2 px-3 text-white">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 px-3 text-red-400">Logout</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>

    </div>
</nav>