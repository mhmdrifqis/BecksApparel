@extends('layouts.app')

@section('title', 'Edit User - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-950 pt-32 pb-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition mb-6">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                <span>Kembali ke Daftar User</span>
            </a>
            <h1 class="text-4xl font-black text-white mb-2">Edit User</h1>
            <p class="text-slate-400">Perbarui informasi user dan role</p>
        </div>

        <!-- Form Card -->
        <div class="glass-card rounded-3xl p-8 border border-white/10">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="p-4 bg-red-400/10 border border-red-400/30 rounded-xl">
                        <ul class="list-disc list-inside space-y-1 text-sm text-red-400">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Name -->
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2 uppercase tracking-wide">Nama Lengkap</label>
                    <div class="relative group">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus
                            class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition @error('name') border-red-400 @enderror" 
                            placeholder="Masukkan nama lengkap...">
                    </div>
                    @error('name')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2 uppercase tracking-wide">Email Address</label>
                    <div class="relative group">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition @error('email') border-red-400 @enderror" 
                            placeholder="Masukkan email...">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2 uppercase tracking-wide">Nomor Telepon</label>
                    <div class="relative group">
                        <i data-lucide="phone" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                        <input type="tel" name="nomor_telepon" value="{{ old('nomor_telepon', $user->nomor_telepon) }}" required maxlength="15"
                            class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition @error('nomor_telepon') border-red-400 @enderror" 
                            placeholder="081234567890">
                    </div>
                    @error('nomor_telepon')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2 uppercase tracking-wide">Role</label>
                    <div class="relative group">
                        <i data-lucide="shield" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition z-10" width="18"></i>
                        <select name="role_id" required
                            class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition appearance-none @error('role_id') border-red-400 @enderror">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none" width="18"></i>
                    </div>
                    @error('role_id')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password (Optional) -->
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2 uppercase tracking-wide">Password Baru (Opsional)</label>
                    <p class="text-xs text-slate-500 mb-2">Kosongkan jika tidak ingin mengubah password</p>
                    <div class="relative group">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                        <input type="password" name="password" autocomplete="new-password"
                            class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition @error('password') border-red-400 @enderror"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-bold text-slate-300 mb-2 uppercase tracking-wide">Konfirmasi Password Baru</label>
                    <div class="relative group">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-lime-400 transition" width="18"></i>
                        <input type="password" name="password_confirmation" autocomplete="new-password"
                            class="w-full bg-navy-900 border border-slate-700 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-600 focus:outline-none focus:border-lime-400 focus:ring-1 focus:ring-lime-400 transition"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" 
                        class="flex-1 bg-lime-400 hover:bg-lime-500 text-navy-950 font-black text-lg py-4 rounded-xl shadow-lg shadow-lime-400/20 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Simpan Perubahan</span>
                        <i data-lucide="check" width="20"></i>
                    </button>
                    <a href="{{ route('admin.users.index') }}" 
                        class="px-8 py-4 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition flex items-center justify-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) window.lucide.createIcons();
    });
</script>
@endsection

