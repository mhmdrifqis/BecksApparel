@extends('layouts.app')

@section('title', 'Invoice & Pembayaran - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl md:text-3xl font-black text-white">RIWAYAT <span class="text-lime-400">INVOICE</span></h1>
            <button class="text-sm text-slate-400 hover:text-white flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
        </div>

        <div class="bg-navy-800 rounded-xl border border-slate-700 overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-navy-900 text-slate-400 uppercase text-xs font-bold border-b border-slate-700">
                        <tr>
                            <th class="px-6 py-4">No. Invoice</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Total Belanja</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        
                        {{-- CONTOH DATA DUMMY (Nanti diganti @forelse) --}}
                        <tr class="hover:bg-navy-700/50 transition">
                            <td class="px-6 py-4 font-medium text-white">INV-20260220-001</td>
                            <td class="px-6 py-4">20 Feb 2026</td>
                            <td class="px-6 py-4 font-bold text-white">Rp 1.500.000</td>
                            <td class="px-6 py-4">
                                <span class="bg-green-500/10 text-green-400 border border-green-500/20 px-2.5 py-0.5 rounded-full text-xs font-bold">
                                    LUNAS
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="#" class="text-lime-400 hover:text-lime-300 font-bold text-xs border border-lime-400 rounded px-3 py-1.5 hover:bg-lime-400 hover:text-navy-900 transition">
                                    Download PDF
                                </a>
                            </td>
                        </tr>

                        <tr class="hover:bg-navy-700/50 transition">
                            <td class="px-6 py-4 font-medium text-white">INV-20260218-045</td>
                            <td class="px-6 py-4">18 Feb 2026</td>
                            <td class="px-6 py-4 font-bold text-white">Rp 750.000</td>
                            <td class="px-6 py-4">
                                <span class="bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-2.5 py-0.5 rounded-full text-xs font-bold">
                                    PENDING
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="#" class="text-white bg-lime-600 hover:bg-lime-500 font-bold text-xs rounded px-3 py-1.5 transition">
                                    Bayar Sekarang
                                </a>
                            </td>
                        </tr>
                        {{-- END CONTOH DATA --}}

                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-slate-700 flex justify-between items-center text-xs text-slate-400">
                <span>Menampilkan 2 dari 2 data</span>
                <div class="flex gap-2">
                    <button class="px-3 py-1 bg-navy-900 rounded border border-slate-600 hover:bg-slate-700">Prev</button>
                    <button class="px-3 py-1 bg-navy-900 rounded border border-slate-600 hover:bg-slate-700">Next</button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection