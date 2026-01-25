@extends('layouts.dashboard')

@section('title', 'User Management')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">User Management</h1>
            <p class="text-slate-400 text-sm">Kelola data pengguna aplikasi.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-lime-400 hover:bg-lime-500 text-navy-950 font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah User
        </a>
    </div>

    <div class="bg-navy-900 border border-slate-800 rounded-xl overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-slate-300">
                <thead class="bg-navy-950 text-slate-400 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Email / Telepon</th>
                        <th class="px-6 py-4">Tanggal Gabung</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($users as $user)
                    <tr class="hover:bg-navy-800/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-navy-800 border border-slate-700 flex items-center justify-center text-lime-400 font-bold text-xs">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-white">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->isAdmin())
                                <span class="bg-purple-500/10 text-purple-400 border border-purple-500/20 text-xs font-bold px-2 py-1 rounded">
                                    Admin
                                </span>

                            @elseif($user->isManajemen())
                                <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 text-xs font-bold px-2 py-1 rounded">
                                    Manajemen
                                </span>

                            @elseif($user->isProduksi())
                                <span class="bg-orange-500/10 text-orange-400 border border-orange-500/20 text-xs font-bold px-2 py-1 rounded">
                                    Tim Produksi
                                </span>

                            @else
                                <span class="bg-lime-500/10 text-lime-400 border border-lime-500/20 text-xs font-bold px-2 py-1 rounded">
                                    Pelanggan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-col">
                                <span>{{ $user->email }}</span>
                                <span class="text-xs text-slate-500">{{ $user->nomor_telepon ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                class="p-2 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white rounded-lg transition"
                                title="Edit User">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>

                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white rounded-lg transition"
                                            title="Hapus User">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data user.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $users->links() }} 
        </div>
    </div>

@endsection