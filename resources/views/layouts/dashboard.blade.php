<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Becks Apparel</title>
    
    <link rel="icon" href="{{ asset('images/Logo-Becks-Crop.png') }}" type="image/png">
     <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
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
<body class="bg-navy-950 font-sans antialiased text-slate-300" x-data="{ sidebarOpen: false, userDropdown: false }">

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

                <div class="flex items-center gap-3">
                    
                    <!-- Notification Bell -->
                    <div class="relative" x-data="{ notifDropdown: false }">
                        <button @click="notifDropdown = !notifDropdown" @click.away="notifDropdown = false" class="relative p-2 text-slate-400 hover:text-lime-400 focus:outline-none transition rounded-full hover:bg-navy-800">
                            <i data-lucide="bell" class="w-6 h-6"></i>
                            @if(auth()->user() && auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1 right-1 flex h-3 w-3 items-center justify-center">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 text-[8px] font-bold text-white items-center justify-center">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            </span>
                            @endif
                        </button>
                        
                        <div x-show="notifDropdown" x-transition class="z-50 absolute right-0 top-12 my-2 w-80 text-base bg-navy-900 border border-slate-700 rounded-lg shadow-xl" style="display: none;">
                            <div class="px-4 py-3 border-b border-slate-800 flex justify-between items-center bg-navy-900/50 rounded-t-lg">
                                <h3 class="font-bold text-white">Notifikasi</h3>
                                @if(auth()->user() && auth()->user()->unreadNotifications->count() > 0)
                                    <span class="text-xs font-bold text-lime-400">{{ auth()->user()->unreadNotifications->count() }} Baru</span>
                                @endif
                            </div>
                            <div class="max-h-64 overflow-y-auto custom-scrollbar divide-y divide-slate-800">
                                @if(auth()->user())
                                    @forelse(auth()->user()->notifications->take(5) as $notification)
                                        <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-navy-800 transition {{ $notification->unread() ? 'bg-navy-800/30' : '' }}">
                                            <div class="flex items-start gap-3">
                                                <div class="w-8 h-8 rounded-full flex-shrink-0 {{ $notification->unread() ? 'bg-lime-400/10 text-lime-400' : 'bg-slate-800 text-slate-500' }} flex items-center justify-center">
                                                    <i data-lucide="{{ isset($notification->data['type']) && $notification->data['type'] == 'new_order' ? 'shopping-cart' : 'info' }}" class="w-4 h-4"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold {{ $notification->unread() ? 'text-white' : 'text-slate-300' }}">{{ $notification->data['title'] ?? 'Pemberitahuan' }}</p>
                                                    <p class="text-xs text-slate-400 mt-0.5 line-clamp-2">{!! $notification->data['message'] ?? '' !!}</p>
                                                    <p class="text-[10px] text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="px-4 py-6 text-center text-slate-500 text-sm">
                                            <i data-lucide="bell-off" class="w-8 h-8 mx-auto mb-2 opacity-30"></i>
                                            Belum ada notifikasi baru
                                        </div>
                                    @endforelse
                                @endif
                            </div>
                            <div class="px-4 py-2 border-t border-slate-800 text-center bg-navy-900/50 rounded-b-lg">
                                <a href="#" class="text-xs font-bold text-lime-400 hover:text-white transition">Tandai Semua Dibaca</a>
                            </div>
                            
                            @php 
                                // Opsi: menandai dibaca saat list dropdown dibuka
                                // \Illuminate\Support\Facades\DB::table('notifications')->where('notifiable_id', auth()->id())->update(['read_at' => now()]);
                                // Untuk sekarang biarkan dulu
                            @endphp
                        </div>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="flex items-center relative">
                        <button @click="userDropdown = !userDropdown" @click.away="userDropdown = false" class="flex text-sm bg-navy-800 rounded-full focus:ring-4 focus:ring-slate-700">
                            <div class="w-8 h-8 rounded-full bg-lime-400 flex items-center justify-center text-navy-950 font-bold border-2 border-navy-800">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                        
                        <div x-show="userDropdown" x-transition class="z-50 absolute right-0 top-12 my-2 text-base list-none bg-navy-900 divide-y divide-slate-700 rounded shadow-xl border border-slate-700 w-48" style="display: none;">
                            <div class="px-4 py-3">
                                <p class="text-sm text-white font-bold truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs font-medium text-slate-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <ul class="py-1">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-navy-800 hover:text-red-300 font-bold transition">Keluar</button>
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
           class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-navy-900 border-r border-slate-800 sm:translate-x-0">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-navy-900">
            <ul class="space-y-2 font-medium">
                
                @include('layouts.sidebar-menu')

            </ul>
        </div>
    </aside>

    <div class="px-6 py-6 sm:ml-64 mt-16 min-h-screen">
    @yield('content')
</div>

    <!-- Global Loader Overlay -->
    <div id="global-loader" class="hidden">
        <div class="loader-container">
            <div class="spinner"></div>
            <p class="loader-text">Sedang memproses...</p>
        </div>
    </div>

</div>
    <script>
        lucide.createIcons();

        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('global-loader');

            // 1. Munculkan loader saat form dikirim (Submit)
            document.addEventListener('submit', function(e) {
                loader.classList.remove('hidden');
            });

            // 2. Munculkan loader saat berpindah halaman (Klik Link)
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && 
                    link.href && 
                    !link.hash && 
                    link.target !== '_blank' && 
                    !link.getAttribute('download') &&
                    link.getAttribute('href') !== '#' &&
                    link.href.startsWith(window.location.origin)) {
                    loader.classList.remove('hidden');
                }
            });

            // 3. Sembunyikan loader jika user kembali menggunakan tombol 'Back' browser
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    loader.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>