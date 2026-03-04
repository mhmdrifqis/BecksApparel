<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Becks Apparel</title>
    <link rel="icon" href="{{ asset('images/Logo-Becks-Crop.png') }}" type="image/png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 950: '#020617', 900: '#0f172a', 800: '#1e293b', 700: '#334155' },
                        lime: { 400: '#a3e635', 500: '#84cc16' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-navy-950 font-sans text-slate-300 antialiased selection:bg-lime-400 selection:text-navy-900">

    @include('partials.navbar')

    <div class="pt-28 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        
        <!-- Header Section -->
        <div class="mb-8 border-b border-slate-800 pb-6">
            <h1 class="text-3xl font-black text-white tracking-tight">Pengaturan Profil</h1>
            <p class="text-slate-400 mt-2">Kelola informasi akun pribadi dan alamat pengiriman Anda untuk memudahkan proses pemesanan.</p>
        </div>

        <!-- Notification -->
        @if(session('status'))
            <div class="mb-8 bg-lime-400/10 border border-lime-400/20 text-lime-400 px-5 py-4 rounded-xl flex items-center gap-3 animate-fadeIn" role="alert">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
                <span class="font-semibold">{{ session('status') }}</span>
            </div>
        @endif

        <form action="{{ route('customer.profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column: Account Info & Password -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Account Card -->
                    <div class="bg-navy-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <i data-lucide="user" class="w-5 h-5 text-lime-400"></i>
                            Informasi Akun
                        </h2>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition placeholder-slate-600">
                                @error('name') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition placeholder-slate-600">
                                @error('email') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Nomor Telepon (Akun)</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition placeholder-slate-600">
                                @error('phone') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password Card -->
                    <div class="bg-navy-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
                        <h2 class="text-xl font-bold text-white mb-2 flex items-center gap-2">
                            <i data-lucide="lock" class="w-5 h-5 text-lime-400"></i>
                            Keamanan
                        </h2>
                        <p class="text-xs text-slate-500 mb-6">Kosongkan jika tidak ingin mengubah password.</p>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Password Baru</label>
                                <input type="password" name="password" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition placeholder-slate-600" placeholder="••••••••">
                                @error('password') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition placeholder-slate-600" placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Address Info -->
                <div class="lg:col-span-2">
                    <div class="bg-navy-900 border border-slate-800 rounded-2xl p-6 shadow-xl h-full flex flex-col">
                        <h2 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-5 h-5 text-lime-400"></i>
                            Alamat Pengiriman Utama
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 flex-1">
                            <div class="md:col-span-1">
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Nama Penerima</label>
                                <input type="text" name="recipient_name" value="{{ old('recipient_name', $address->recipient_name ?? $user->name) }}" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition">
                                @error('recipient_name') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-1">
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">No. Telepon Penerima</label>
                                <input type="text" name="address_phone" value="{{ old('address_phone', $address->phone ?? $user->phone) }}" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition">
                                @error('address_phone') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                            <div><label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Provinsi</label><input type="text" name="province" value="{{ old('province', $address->province ?? '') }}" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition">@error('province') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror</div>
                            <div><label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Kota / Kabupaten</label><input type="text" name="city" value="{{ old('city', $address->city ?? '') }}" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition">@error('city') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror</div>
                            <div><label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Kecamatan</label><input type="text" name="district" value="{{ old('district', $address->district ?? '') }}" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition">@error('district') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror</div>
                            <div><label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Kode Pos</label><input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition">@error('postal_code') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror</div>
                            <div class="md:col-span-2"><label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Alamat Lengkap</label><textarea name="full_address" rows="3" class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-3 text-white focus:border-lime-400 focus:ring-1 focus:ring-lime-400 outline-none transition">{{ old('full_address', $address->full_address ?? '') }}</textarea>@error('full_address') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror</div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-slate-800 flex justify-end gap-4">
                            <a href="{{ route('home') }}" class="px-6 py-3 rounded-xl border border-slate-600 text-slate-300 font-bold hover:bg-slate-800 hover:text-white transition duration-300 flex items-center justify-center">
                                Batal
                            </a>
                            <button type="submit" class="bg-lime-400 hover:bg-lime-500 text-navy-950 font-black text-lg py-3 px-10 rounded-xl shadow-lg shadow-lime-400/20 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex items-center gap-2">
                                <i data-lucide="save" class="w-5 h-5"></i>
                                SIMPAN PERUBAHAN
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>