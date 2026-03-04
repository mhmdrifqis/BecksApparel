@extends('layouts.app')

@section('title', 'Notifikasi - Becks Apparel')

@section('content')
<div class="pt-28 pb-12 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4" data-aos="fade-down">
            <div>
                <h1 class="text-3xl font-black text-white tracking-tight flex items-center gap-3">
                    <i data-lucide="bell" class="text-lime-400 w-8 h-8"></i>
                    NOTIFIKASI
                </h1>
                <p class="text-slate-400 mt-1">Informasi terbaru mengenai pesanan dan akun Anda.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="text-sm font-bold text-slate-400 hover:text-lime-400 transition flex items-center gap-2 bg-navy-900/50 px-4 py-2 rounded-lg border border-slate-800">
                    <i data-lucide="check-check" class="w-4 h-4"></i>
                    Tandai Semua Dibaca
                </button>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="space-y-4">
            
            <!-- Notification Item: Unread (Order Update) -->
            <div class="bg-navy-900 border-l-4 border-lime-400 p-5 rounded-r-xl shadow-xl hover:bg-navy-800 transition group relative" data-aos="fade-up">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-lime-400/10 flex items-center justify-center text-lime-400">
                            <i data-lucide="package" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-white group-hover:text-lime-400 transition">Pesanan Sedang Diproses</h3>
                            <span class="text-xs text-slate-500 font-medium">Baru saja</span>
                        </div>
                        <p class="text-slate-400 text-sm mt-1 leading-relaxed">
                            Pesanan Anda <span class="text-white font-semibold">#ORD-1005</span> telah memasuki tahap produksi (<span class="text-lime-400">Proses Jahit</span>). Kami akan mengabari Anda saat siap dikirim.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('customer.orders') }}" class="inline-flex items-center text-xs font-bold bg-navy-800 text-slate-300 px-4 py-2 rounded hover:bg-lime-400 hover:text-navy-950 transition gap-2">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                Lihat Pesanan
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Unread Indicator -->
                <div class="absolute top-5 right-5 w-2.5 h-2.5 bg-lime-400 rounded-full shadow-[0_0_10px_rgba(163,230,53,0.5)]"></div>
            </div>

            <!-- Notification Item: Read (Payment) -->
            <div class="bg-navy-900/40 border border-slate-800 p-5 rounded-xl shadow-sm hover:bg-navy-800/60 transition group" data-aos="fade-up" data-aos-delay="100">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center text-slate-500">
                            <i data-lucide="credit-card" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-slate-300 group-hover:text-white transition">Pembayaran Dikonfirmasi</h3>
                            <span class="text-xs text-slate-500 font-medium">2 jam lalu</span>
                        </div>
                        <p class="text-slate-500 text-sm mt-1">
                            Pembayaran untuk invoice <span class="text-slate-300 font-semibold">INV-20260120-001</span> telah berhasil diverifikasi. Pesanan Anda segera diteruskan ke tim produksi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Notification Item: Promo -->
            <div class="bg-navy-900/40 border border-slate-800 p-5 rounded-xl shadow-sm hover:bg-navy-800/60 transition group" data-aos="fade-up" data-aos-delay="200">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-accent-purple/10 flex items-center justify-center text-accent-purple">
                            <i data-lucide="megaphone" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-slate-300 group-hover:text-white transition">Promo Jersey Tim Futsal!</h3>
                            <span class="text-xs text-slate-500 font-medium">Kemarin</span>
                        </div>
                        <p class="text-slate-500 text-sm mt-1">
                            Dapatkan diskon 15% untuk pemesanan minimal 12 stel. Gunakan kode promo: <span class="text-accent-purple font-bold">TEAMBECKS</span> saat checkout.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection