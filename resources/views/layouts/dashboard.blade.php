<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Becks Apparel</title>
    
    <link rel="icon" href="{{ asset('images/Logo-Becks-Crop.png') }}" type="image/png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 950: '#020617', 900: '#0f172a', 800: '#1e293b' },
                        lime: { 400: '#a3e635', 500: '#84cc16' }
                    }
                }
            }
        }
    </script>
    
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-navy-950 font-sans antialiased text-slate-300" x-data="{ sidebarOpen: false, userDropdownOpen: false }">

    <nav class="fixed top-0 z-50 w-full bg-navy-900 border-b border-slate-800">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                
                <div class="flex items-center justify-start rtl:justify-end">
                    <button @click="sidebarOpen = !sidebarOpen" type="button" class="inline-flex items-center p-2 text-sm text-slate-400 rounded-lg sm:hidden hover:bg-navy-800 focus:outline-none focus:ring-2 focus:ring-slate-600">
                        <span class="sr-only">Open sidebar</span>
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    
                    <a href="{{ route('home') }}" class="flex ms-2 md:me-24 items-center gap-3">
                        <div class="relative p-1 rounded-md">
                            <div class="absolute -inset-0.5 bg-lime-400 rounded-md opacity-60 blur-sm"></div>
                            <img src="{{ asset('images/Logo-Becks-Crop.png') }}" class="h-8 w-auto relative z-10 rounded-sm" alt="Becks Logo">
                        </div>
                        <span class="self-center text-xl font-black whitespace-nowrap text-white tracking-widest hidden md:block">
                            BECKS<span class="text-lime-400">APPAREL</span>
                        </span>
                    </a>
                </div>

                <div class="flex items-center">
                    <div class="flex items-center ms-3 relative">
                        <div>
                            <button @click="userDropdownOpen = !userDropdownOpen" @click.away="userDropdownOpen = false" type="button" class="flex text-sm bg-navy-800 rounded-full focus:ring-4 focus:ring-slate-700" aria-expanded="false">
                                <span class="sr-only">Open user menu</span>
                                <div class="w-8 h-8 rounded-full bg-lime-400 flex items-center justify-center text-navy-950 font-bold border-2 border-navy-800">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </button>
                        </div>
                        
                        <div x-show="userDropdownOpen" 
                             x-transition
                             class="z-50 absolute right-0 top-10 my-4 text-base list-none bg-navy-900 divide-y divide-slate-700 rounded shadow-xl border border-slate-700 w-48" style="display: none;">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-white font-bold" role="none">{{ Auth::user()->name }}</p>
                                <p class="text-xs font-medium text-slate-400 truncate" role="none">{{ Auth::user()->email }}</p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-navy-800 hover:text-lime-400" role="menuitem">Halaman Utama</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-navy-800 hover:text-red-300 font-bold" role="menuitem">Sign out</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar" 
           :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
           class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-navy-900 border-r border-slate-800 sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-navy-900">
            <ul class="space-y-2 font-medium">
                
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-navy-800 hover:text-lime-400 group {{ Request::routeIs('dashboard') ? 'bg-navy-800 text-lime-400' : '' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>

                @if(auth()->user()->isAdmin())
                    
                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Master Data</span>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group {{ Request::routeIs('admin.users.*') ? 'bg-navy-800 text-lime-400' : '' }}">
                            <i data-lucide="users" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Manajemen User</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.products.index') }}" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group {{ Request::routeIs('admin.products.*') ? 'bg-navy-800 text-lime-400' : '' }}">
                            <i data-lucide="package" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Produk & Layanan</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="boxes" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Manajemen Stok</span>
                        </a>
                    </li>

                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Operasional</span>
                    </li>

                    <li>
                        <a href="{{ route ('admin.admin.transactions.index') }}" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="shopping-cart" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Transaksi / Pesanan</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="factory" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Status Produksi</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="truck" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Pengiriman & Resi</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="refresh-ccw" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Pengajuan Retur</span>
                        </a>
                    </li>

                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Finance & Report</span>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="file-text" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Invoice & Keuangan</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="bar-chart-3" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Laporan & Analitik</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="bot" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Chatbot Config</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->isManajemen())

                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-navy-800 hover:text-lime-400 group {{ Request::routeIs('dashboard') ? 'bg-navy-800 text-lime-400' : '' }}">
                            <i data-lucide="pie-chart" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="ms-3">Executive Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Keuangan & Laporan</span>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="trending-up" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Tren Pendapatan</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="banknote" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Laporan Penjualan</span>
                        </a>
                    </li>

                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Intelijen Bisnis</span>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="bar-chart-3" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Performa Produk</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="users" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Statistik Pelanggan</span>
                        </a>
                    </li>

                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Audit & Evaluasi</span>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="timer" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Efisiensi Produksi</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="alert-circle" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Tingkat Retur</span>
                        </a>
                    </li>

                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Akun</span>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="user" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Profil Saya</span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->isProduksi())

                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-navy-800 hover:text-lime-400 group {{ Request::routeIs('dashboard') ? 'bg-navy-800 text-lime-400' : '' }}">
                            <i data-lucide="activity" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="ms-3">Dashboard Produksi</span>
                        </a>
                    </li>
                    
                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Tahapan Produksi</span>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="printer" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Antrean Cetak</span>
                            <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-bold text-navy-950 bg-red-400 rounded-full">3</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="scissors" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Proses Jahit</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="clipboard-check" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Quality Control</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="package-check" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Siap Kirim</span>
                        </a>
                    </li>

                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Inventory & Bahan</span>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="layers" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Stok Bahan Baku</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="box" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Stok Barang Jadi</span>
                        </a>
                    </li>

                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Akun</span>
                    </li>
                    
                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="user" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Profil Saya</span>
                        </a>
                    </li>   
                @endif

                @if(auth()->user()->isPelanggan())
                
                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Aktivitas Belanja</span>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="shopping-bag" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Katalog Produk</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="package-search" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Pesanan Saya</span>
                            <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-bold text-navy-950 bg-lime-400 rounded-full">1</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="file-text" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Invoice & Riwayat</span>
                        </a>
                    </li>

                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Bantuan & Layanan</span>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="refresh-ccw" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Ajukan Retur</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="message-circle" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Pusat Bantuan</span>
                        </a>
                    </li>

                    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
                        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Akun Saya</span>
                    </li>

                    <li>
                        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
                            <i data-lucide="user-cog" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">Edit Profil</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64 mt-14">
        @yield('content')
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>