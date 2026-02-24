@extends('layouts.app')

@section('title', 'Custom Jersey - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-black text-white mb-4 tracking-wide">
                DESAIN <span class="text-lime-400">JERSEY IMPIANMU</span>
            </h1>
            <p class="text-slate-400 max-w-2xl mx-auto">
                Wujudkan kreativitasmu menjadi nyata. Pilih metode desain yang paling cocok untuk tim atau komunitasmu.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="group bg-navy-800 border border-slate-700 rounded-xl p-8 hover:border-lime-400 transition duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 bg-lime-500 text-navy-900 text-xs font-bold px-3 py-1 rounded-bl-lg">POPULER</div>
                
                <div class="w-16 h-16 bg-navy-900 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition">
                    <svg class="w-8 h-8 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                
                <h3 class="text-xl font-bold text-white mb-3">Gunakan 3D Configurator</h3>
                <p class="text-slate-400 mb-6 text-sm leading-relaxed">
                    Pilih pola dasar, ubah warna sesuka hati, tambahkan logo dan nama punggung secara real-time dengan tampilan 3D.
                </p>
                
                <button class="w-full bg-lime-500 text-navy-900 font-bold py-3 rounded-lg hover:bg-lime-400 transition">
                    Mulai Desain Sekarang
                </button>
            </div>

            <div class="group bg-navy-800 border border-slate-700 rounded-xl p-8 hover:border-slate-500 transition duration-300">
                <div class="w-16 h-16 bg-navy-900 rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition">
                    <svg class="w-8 h-8 text-slate-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                </div>
                
                <h3 class="text-xl font-bold text-white mb-3">Upload Desain Sendiri</h3>
                <p class="text-slate-400 mb-6 text-sm leading-relaxed">
                    Sudah punya file mentahan (Corel/AI/PSD)? Upload file desainmu di sini dan tim kami akan melakukan review.
                </p>
                
                <button class="w-full bg-transparent border border-slate-500 text-slate-300 font-bold py-3 rounded-lg hover:bg-slate-700 hover:text-white transition">
                    Upload File
                </button>
            </div>

        </div>

        <div class="mt-16">
            <h2 class="text-2xl font-bold text-white mb-6">Inspirasi Desain</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="aspect-square bg-navy-800 rounded-lg overflow-hidden">
                    <img src="https://placehold.co/400x400/1a202c/FFF?text=Jersey+1" alt="Inspirasi" class="w-full h-full object-cover opacity-70 hover:opacity-100 transition">
                </div>
                <div class="aspect-square bg-navy-800 rounded-lg overflow-hidden">
                    <img src="https://placehold.co/400x400/1a202c/FFF?text=Jersey+2" alt="Inspirasi" class="w-full h-full object-cover opacity-70 hover:opacity-100 transition">
                </div>
                <div class="aspect-square bg-navy-800 rounded-lg overflow-hidden">
                    <img src="https://placehold.co/400x400/1a202c/FFF?text=Jersey+3" alt="Inspirasi" class="w-full h-full object-cover opacity-70 hover:opacity-100 transition">
                </div>
                <div class="aspect-square bg-navy-800 rounded-lg overflow-hidden">
                    <img src="https://placehold.co/400x400/1a202c/FFF?text=Jersey+4" alt="Inspirasi" class="w-full h-full object-cover opacity-70 hover:opacity-100 transition">
                </div>
            </div>
        </div>

    </div>
</div>
@endsection