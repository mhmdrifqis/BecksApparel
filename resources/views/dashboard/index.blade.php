@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Dashboard Overview</h1>
        <p class="text-slate-400">Selamat datang kembali, <span class="text-lime-400 font-bold">{{ Auth::user()->name }}</span>!</p>
    </div>

    <div class="p-4 border-2 border-slate-800 border-dashed rounded-lg bg-navy-900/50">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
            <div class="flex items-center justify-center h-24 rounded bg-navy-800 hover:bg-navy-700 transition border border-slate-800">
                <p class="text-2xl text-slate-500 group-hover:text-lime-400">
                    <i data-lucide="bar-chart-3" class="w-8 h-8"></i>
                </p>
            </div>
            <div class="flex items-center justify-center h-24 rounded bg-navy-800 hover:bg-navy-700 transition border border-slate-800">
                <p class="text-2xl text-slate-500">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </p>
            </div>
            <div class="flex items-center justify-center h-24 rounded bg-navy-800 hover:bg-navy-700 transition border border-slate-800">
                <p class="text-2xl text-slate-500">
                    <i data-lucide="shopping-bag" class="w-8 h-8"></i>
                </p>
            </div>
        </div>

        <div class="flex items-center justify-center h-48 mb-4 rounded bg-navy-800 border border-slate-800">
            <p class="text-slate-500 flex flex-col items-center gap-2">
                <i data-lucide="line-chart" class="w-10 h-10"></i>
                <span class="text-sm font-medium">Chart Area Placeholder</span>
            </p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div class="flex items-center justify-center h-24 rounded bg-navy-800 border border-slate-800">
                <p class="text-2xl text-slate-500">+</p>
            </div>
            <div class="flex items-center justify-center h-24 rounded bg-navy-800 border border-slate-800">
                <p class="text-2xl text-slate-500">+</p>
            </div>
            <div class="flex items-center justify-center h-24 rounded bg-navy-800 border border-slate-800">
                <p class="text-2xl text-slate-500">+</p>
            </div>
            <div class="flex items-center justify-center h-24 rounded bg-navy-800 border border-slate-800">
                <p class="text-2xl text-slate-500">+</p>
            </div>
        </div>

        <div class="flex items-center justify-center h-48 mb-4 rounded bg-navy-800 border border-slate-800">
            <p class="text-2xl text-slate-500">+</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center justify-center h-28 rounded bg-navy-800 border border-slate-800">
                <p class="text-2xl text-slate-500">+</p>
            </div>
            <div class="flex items-center justify-center h-28 rounded bg-navy-800 border border-slate-800">
                <p class="text-2xl text-slate-500">+</p>
            </div>
            <div class="flex items-center justify-center h-28 rounded bg-navy-800 border border-slate-800">
                <p class="text-2xl text-slate-500">+</p>
            </div>
            <div class="flex items-center justify-center h-28 rounded bg-navy-800 border border-slate-800">
                <p class="text-2xl text-slate-500">+</p>
            </div>
        </div>

    </div>
@endsection