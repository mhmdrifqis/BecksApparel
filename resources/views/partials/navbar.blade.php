<nav class="bg-navy-900 fixed w-full z-[90] top-0 start-0 border-b border-slate-800" 
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

        <div class="flex md:order-2 items-center gap-3 sm:gap-6">
            
            <div class="hidden md:flex items-center bg-navy-800 rounded-sm px-3 py-1.5 w-48 lg:w-64 border border-slate-700 hover:border-lime-400/50 transition group">
                <input type="text" placeholder="Cari Produk..." class="bg-transparent border-none text-sm w-full focus:ring-0 p-0 text-slate-300 placeholder-slate-500 group-hover:placeholder-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 group-hover:text-lime-400 transition"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>

            <div class="flex items-center gap-4 sm:gap-5 text-white">

                @auth
                <!-- Notifikasi -->
                <a href="{{ route('customer.notifications') }}" class="hover:text-lime-400 transition relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-[9px] font-bold text-white items-center justify-center">{{ auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count() }}</span>
                    </span>
                    @endif
                </a>
                @endauth

                <a href="{{ route('customer.cart') }}" class="hover:text-lime-400 transition relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </a>

                @if (Route::has('login'))
                    @auth
                        <div class="relative" x-data="{ dropdownOpen: false }">
                            
                            <button @click="dropdownOpen = !dropdownOpen" @click.outside="dropdownOpen = false" 
                                    class="flex items-center gap-1 hover:text-lime-400 transition focus:outline-none">
                                
                                <div class="relative">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-navy-900 bg-lime-400 transform translate-x-1/4 -translate-y-1/4"></span>
                                </div>
                                
                                <svg class="w-3 h-3 ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="dropdownOpen" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 z-50 w-60 origin-top-right rounded-md bg-navy-800 shadow-xl ring-1 ring-black ring-opacity-5 border border-slate-700 focus:outline-none" 
                                 style="display: none;">
                                
                                <div class="py-1">
                                    <div class="px-4 py-3 border-b border-slate-700 bg-navy-900/50">
                                        <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Akun Saya</p>
                                        <p class="text-sm font-bold text-white truncate mt-0.5">{{ Auth::user()->name }}</p>
                                    </div>

                                    <a href="{{ route('customer.orders') }}" class="group flex items-center px-4 py-2.5 text-sm text-slate-300 hover:bg-navy-700 hover:text-white transition">
                                        <svg class="w-5 h-5 mr-3 text-slate-500 group-hover:text-lime-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        Pesanan Saya
                                    </a>

                                    <a href="{{ route('customer.profile') }}" class="group flex items-center px-4 py-2.5 text-sm text-slate-300 hover:bg-navy-700 hover:text-white transition">
                                        <svg class="w-5 h-5 mr-3 text-slate-500 group-hover:text-lime-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Profil Saya
                                    </a>

                                    <a href="{{ route('products.index') }}" class="group flex items-center px-4 py-2.5 text-sm text-slate-300 hover:bg-navy-700 hover:text-white transition">
                                        <svg class="w-5 h-5 mr-3 text-slate-500 group-hover:text-lime-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                        Custom Jersey
                                    </a>

                                    <a href="{{ route('customer.returns') }}" class="group flex items-center px-4 py-2.5 text-sm text-slate-300 hover:bg-navy-700 hover:text-white transition">
                                        <svg class="w-5 h-5 mr-3 text-slate-500 group-hover:text-lime-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        Retur Barang
                                    </a>

                                    <a href="{{ route('customer.wishlist') }}" class="group flex items-center px-4 py-2.5 text-sm text-slate-300 hover:bg-navy-700 hover:text-white transition">
                                        <svg class="w-5 h-5 mr-3 text-slate-500 group-hover:text-lime-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        Wishlist
                                    </a>

                                    <div class="border-t border-slate-700 my-1"></div>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="group flex w-full items-center px-4 py-2.5 text-sm text-red-400 hover:bg-navy-700 hover:text-red-300 transition">
                                            <svg class="w-5 h-5 mr-3 text-red-500/70 group-hover:text-red-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @else
                        <a href="{{ route('login') }}" class="hover:text-lime-400 transition relative" title="Masuk / Daftar">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </a>
                    @endauth
                @endif

                <button @click="mobileOpen = !mobileOpen" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-slate-400 rounded-lg md:hidden hover:bg-navy-800 focus:outline-none focus:ring-2 focus:ring-slate-600 ml-1">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>

            </div>
        </div>

        <div :class="{'block': mobileOpen, 'hidden': !mobileOpen}" class="items-center justify-between w-full md:flex md:w-auto md:order-1 hidden" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-bold border border-slate-800 rounded-lg bg-navy-800 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                <li>
                    <a href="{{ route('home') }}" class="block py-2 px-3 rounded md:p-0 transition {{ Request::is('/') ? 'text-white md:text-lime-400' : 'text-slate-300 hover:text-lime-400' }}">HOME</a>
                </li>
                <li>
                    <a href="{{ route('gallery') }}" class="block py-2 px-3 rounded md:p-0 transition {{ Request::is('gallery*') ? 'text-white md:text-lime-400' : 'text-slate-300 hover:text-lime-400' }}">GALLERY</a>
                </li>
                <li>
                    <a href="{{ route('catalog') }}" class="block py-2 px-3 rounded md:p-0 transition {{ Request::is('catalog*') ? 'text-white md:text-lime-400' : 'text-slate-300 hover:text-lime-400' }}">KATALOG</a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="block py-2 px-3 rounded md:p-0 transition {{ Request::is('products*') ? 'text-white md:text-lime-400' : 'text-slate-300 hover:text-lime-400' }}">PRODUK</a>
                </li>
                <li>
                    <a href="{{ route('features') }}" class="block py-2 px-3 rounded md:p-0 transition {{ Request::is('features*') ? 'text-white md:text-lime-400' : 'text-slate-300 hover:text-lime-400' }}">FITUR</a>
                </li>
                
            </ul>
        </div>

    </div>
</nav>