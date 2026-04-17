@extends('layouts.app')

@section('title', 'Admin Chat Monitoring - Becks Apparel')

@section('content')
<div class="min-h-screen pt-28 pb-12 px-4 sm:px-6 lg:px-8 bg-navy-950">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-black text-white leading-tight">CHAT <span class="text-gradient">DASHBOARD</span></h1>
                <p class="text-slate-400 mt-2">Monitoring percakapan customer dan kontrol asisten AI secara real-time.</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 glass hover:bg-white/5 text-white rounded-xl transition border border-white/10 flex items-center gap-2">
                    <i data-lucide="layout-dashboard"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- React Component Mount Point: Chat Monitoring -->
        <div id="chat-admin" class="mb-16"></div>

        <div class="mb-8">
            <h2 class="text-3xl font-black text-white leading-tight uppercase">BOT <span class="text-gradient">INTELLIGENCE</span></h2>
            <p class="text-slate-400 mt-2">Kelola otak chatbot di sini.</p>
        </div>
        
        <!-- React Component Mount Point: Intent Manager -->
        <div id="intent-manager"></div>
        
    </div>
</div>
@endsection
