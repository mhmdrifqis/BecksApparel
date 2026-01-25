@extends('layouts.dashboard')

@section('title', 'Tambah User Baru')

@section('content')

    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.users.index') }}" class="bg-navy-800 text-slate-300 hover:text-white p-2 rounded-lg transition border border-slate-700">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Tambah User Baru</h1>
            <p class="text-slate-400 text-sm">Silakan isi formulir berikut untuk menambahkan pengguna baru.</p>
        </div>
    </div>

    <div class="w-full bg-navy-900 border border-slate-800 rounded-xl p-6 lg:p-8 shadow-xl">
        
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                
                <div class="space-y-6">
                    <h3 class="text-lime-400 font-bold text-sm uppercase tracking-wider border-b border-slate-800 pb-2 mb-4">
                        Informasi Akun
                    </h3>

                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2">NAMA LENGKAP</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition"
                               placeholder="Contoh: Budi Santoso">
                        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2">EMAIL ADDRESS</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition"
                               placeholder="email@contoh.com">
                        @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2">NOMOR TELEPON</label>
                        <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required
                               class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition"
                               placeholder="0812xxxxxx">
                        @error('nomor_telepon') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-lime-400 font-bold text-sm uppercase tracking-wider border-b border-slate-800 pb-2 mb-4">
                        Akses & Keamanan
                    </h3>

                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2">ROLE AKUN</label>
                        <select name="role_id" required
                                class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition cursor-pointer">
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2">PASSWORD</label>
                        <input type="password" name="password" required
                               class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition"
                               placeholder="••••••••">
                        @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-slate-400 text-sm font-bold mb-2">KONFIRMASI PASSWORD</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition"
                               placeholder="••••••••">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 border-t border-slate-800 pt-6">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-3 rounded-lg text-slate-400 font-bold hover:text-white hover:bg-slate-800 transition">
                   Batal
                </a>
                <button type="submit" 
                        class="bg-lime-400 hover:bg-lime-500 text-navy-950 font-black px-8 py-3 rounded-lg transition shadow-lg shadow-lime-400/20 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> SIMPAN DATA
                </button>
            </div>

        </form>
    </div>

@endsection