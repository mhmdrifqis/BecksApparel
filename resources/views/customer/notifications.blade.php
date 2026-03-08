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
            
            @forelse(auth()->user()->notifications as $notification)
            <div class="{{ $notification->unread() ? 'bg-navy-900 border-l-4 border-lime-400 p-5 rounded-r-xl shadow-xl' : 'bg-navy-900/40 border border-slate-800 p-5 rounded-xl shadow-sm' }} hover:bg-navy-800 transition group relative" data-aos="fade-up">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full {{ $notification->unread() ? 'bg-lime-400/10 text-lime-400' : 'bg-slate-800 text-slate-500' }} flex items-center justify-center">
                            @if(isset($notification->data['type']) && $notification->data['type'] == 'status_update')
                                <i data-lucide="package" class="w-6 h-6"></i>
                            @else
                                <i data-lucide="bell" class="w-6 h-6"></i>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold {{ $notification->unread() ? 'text-white group-hover:text-lime-400' : 'text-slate-300 group-hover:text-white' }} transition">{{ $notification->data['title'] ?? 'Pemberitahuan' }}</h3>
                            <span class="text-xs text-slate-500 font-medium">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-slate-400 text-sm mt-1 leading-relaxed">
                            {!! $notification->data['message'] ?? '' !!}
                        </p>
                        @if(isset($notification->data['url']))
                        <div class="mt-4">
                            <a href="{{ $notification->data['url'] }}" class="inline-flex items-center text-xs font-bold bg-navy-800 text-slate-300 px-4 py-2 rounded hover:bg-lime-400 hover:text-navy-950 transition gap-2">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                Lihat Detail
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @if($notification->unread())
                    <div class="absolute top-5 right-5 w-2.5 h-2.5 bg-lime-400 rounded-full shadow-[0_0_10px_rgba(163,230,53,0.5)]"></div>
                @endif
            </div>
            @empty
            <div class="text-center py-12 text-slate-500">
                <i data-lucide="bell-off" class="w-16 h-16 mx-auto mb-4 opacity-30"></i>
                <h3 class="text-xl font-bold text-white mb-2">Tidak ada notifikasi</h3>
                <p>Anda belum menerima pemberitahuan apa pun sejauh ini.</p>
            </div>
            @endforelse

            @php 
                // Mark as read after viewing
                auth()->user()->unreadNotifications->markAsRead();
            @endphp
        </div>
    </div>
</div>
@endsection