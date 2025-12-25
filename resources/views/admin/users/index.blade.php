@extends('layouts.app')

@section('title', 'User Management - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-950 pt-32 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-black text-white mb-2">User Management</h1>
                <p class="text-slate-400">Kelola semua pengguna sistem</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="px-6 py-3 bg-lime-400 hover:bg-lime-500 text-navy-950 font-black rounded-xl transition transform hover:scale-105 shadow-lg shadow-lime-400/20 flex items-center gap-2">
                <i data-lucide="user-plus"></i> Tambah User
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-lime-400/10 border border-lime-400/30 rounded-xl text-lime-400">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-400/10 border border-red-400/30 rounded-xl text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <!-- Users Table -->
        <div class="glass-card rounded-3xl overflow-hidden border border-white/10">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-navy-900/50 border-b border-white/10">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Nomor Telepon</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Tanggal Daftar</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($users as $user)
                            <tr class="hover:bg-navy-900/30 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-white">{{ $user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-400">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-400">{{ $user->nomor_telepon }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                            @if($user->isPimpinan()) bg-purple-500/20 text-purple-400 border border-purple-400/30
                                            @elseif($user->isAdmin()) bg-blue-500/20 text-blue-400 border border-blue-400/30
                                            @else bg-lime-500/20 text-lime-400 border border-lime-400/30
                                            @endif">
                                            {{ $user->getRoleDisplayName() }}
                                        </span>
                                    @else
                                        <span class="text-slate-500 text-xs">No Role</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-500">{{ $user->created_at->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-lime-400 hover:text-lime-300 transition">
                                            <i data-lucide="edit" class="w-5 h-5"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 transition">
                                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    Tidak ada user ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-white/10">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) window.lucide.createIcons();
    });
</script>
@endsection

