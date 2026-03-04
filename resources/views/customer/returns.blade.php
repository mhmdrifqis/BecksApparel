@extends('layouts.app')

@section('title', 'Ajukan Retur - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-black text-white mb-2">AJUKAN <span class="text-lime-400">PENGEMBALIAN</span></h1>
            <p class="text-slate-400 text-sm">Barang tidak sesuai atau cacat produksi? Isi formulir di bawah ini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-2">
                <div class="bg-navy-800 rounded-xl p-6 border border-slate-700 shadow-lg">
                    <form action="#" method="POST" enctype="multipart/form-data"> @csrf
                        
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-white mb-2">Pilih Pesanan</label>
                            <select class="w-full bg-navy-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-lime-400 focus:border-lime-400 block p-2.5">
                                <option selected>Pilih Nomor Invoice...</option>
                                <option value="1">INV-20260220-001 (Jersey Full Print)</option>
                                <option value="2">INV-20260218-045 (Kaos Polos)</option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-white mb-2">Alasan Pengembalian</label>
                            <textarea rows="4" class="block p-2.5 w-full text-sm text-white bg-navy-900 rounded-lg border border-slate-600 focus:ring-lime-400 focus:border-lime-400" placeholder="Jelaskan detail kerusakan atau ketidaksesuaian barang..."></textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-white mb-2">Upload Foto/Video Bukti</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-600 border-dashed rounded-lg cursor-pointer bg-navy-900 hover:bg-navy-700 hover:border-lime-400 transition">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-3 text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="text-xs text-slate-400"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                        <p class="text-xs text-slate-500">SVG, PNG, JPG (MAX. 5MB)</p>
                                    </div>
                                    <input id="dropzone-file" type="file" class="hidden" />
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="w-full text-navy-900 bg-lime-400 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-lime-800 font-bold rounded-lg text-sm px-5 py-3 text-center transition">
                            Kirim Pengajuan
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-1">
                <div class="bg-navy-800 rounded-xl p-6 border border-slate-700 mb-6">
                    <h3 class="text-white font-bold mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Syarat & Ketentuan
                    </h3>
                    <ul class="text-xs text-slate-400 space-y-2 list-disc list-inside">
                        <li>Maksimal pengajuan 3x24 jam setelah barang diterima.</li>
                        <li>Wajib menyertakan video unboxing.</li>
                        <li>Label harga/tag jangan dilepas.</li>
                        <li>Barang belum pernah dicuci atau dipakai aktivitas berat.</li>
                    </ul>
                </div>

                <div class="bg-navy-800 rounded-xl p-6 border border-slate-700">
                    <h3 class="text-white font-bold mb-3 text-sm">Riwayat Retur</h3>
                    <div class="text-center py-4">
                        <p class="text-xs text-slate-500 italic">Belum ada riwayat pengajuan.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection