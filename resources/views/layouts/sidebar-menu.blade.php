{{-- MENU UMUM --}}
<li>
    <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-navy-800 hover:text-lime-400 group {{ Request::routeIs('dashboard') ? 'bg-navy-800 text-lime-400' : '' }}">
        <i data-lucide="layout-dashboard" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
        <span class="ms-3">Dashboard</span>
    </a>
</li>

{{-- MENU ADMIN --}}
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
        <a href="{{ route('admin.orders.index') }}" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group {{ Request::routeIs('admin.orders.*') ? 'bg-navy-800 text-lime-400' : '' }}">
            <i data-lucide="shopping-cart" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Pesanan & Verifikasi</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="truck" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Pengiriman (Resi)</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="undo-2" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Kelola Retur</span>
        </a>
    </li>

    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Inventori</span>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="layers" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Bahan Mentah</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="boxes" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Stok Produk & Variasi</span>
        </a>
    </li>

    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Layanan Pelanggan</span>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="message-square" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Chatbot & Broadcast</span>
        </a>
    </li>

    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Keuangan & Analisis</span>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="file-text" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Invoice & Keuangan</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="pie-chart" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Laporan Penjualan</span>
        </a>
    </li>
@endif

{{-- MENU PIMPINAN (MANAJEMEN) --}}
@if(auth()->user()->isManajemen())
    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Eksekutif</span>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="trending-up" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Laporan Keuangan</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="activity" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Evaluasi Produksi</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="bar-chart-3" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Laporan Stok</span>
        </a>
    </li>
@endif

{{-- MENU PRODUKSI --}}
@if(auth()->user()->isProduksi())
    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Produksi</span>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="printer" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Antrean Produksi</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="clipboard-edit" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Penggunaan Bahan</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="history" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Log Produksi</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="layers" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Inventori Bahan</span>
        </a>
    </li>
@endif

{{-- MENU PELANGGAN --}}
@if(auth()->user()->isPelanggan())
    <li class="pt-4 mt-4 space-y-2 border-t border-slate-800">
        <span class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan</span>
    </li>
    <li>
        <a href="{{ route('customer.orders') }}" class="flex items-center p-2 text-slate-300 rounded-lg hover:bg-navy-800 hover:text-lime-400 group">
            <i data-lucide="package-search" class="w-5 h-5 transition duration-75 group-hover:text-lime-400"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Pesanan Saya</span>
        </a>
    </li>
@endif