@extends('layouts.dashboard')

@section('title', 'Resi & Pengiriman Massal')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Resi Pengiriman Massal</h1>
            <p class="text-slate-400 text-sm">Input nomor resi pengiriman untuk beberapa pesanan sekaligus.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-lime-400/10 border border-lime-400/20 text-lime-400 rounded-lg flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('info'))
        <div class="mb-4 p-4 bg-sky-400/10 border border-sky-400/20 text-sky-400 rounded-lg flex items-center gap-2">
            <i data-lucide="info" class="w-5 h-5"></i>
            {{ session('info') }}
        </div>
    @endif

    <div class="bg-navy-900 border border-slate-800 rounded-xl overflow-hidden shadow-lg">
        <form action="{{ route('admin.orders.bulkShipping') }}" method="POST">
            @csrf
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-slate-300">
                    <thead class="bg-navy-950 text-slate-400 uppercase text-xs font-bold">
                        <tr>
                            <th class="px-6 py-4">Invoice & Tanggal</th>
                            <th class="px-6 py-4">Detail Pelanggan</th>
                            <th class="px-6 py-4">Item (Kustom)</th>
                            <th class="px-6 py-4">Input Nomor Resi (Tracking Number)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse($orders as $order)
                        <tr class="hover:bg-navy-800/50 transition">
                            <td class="px-6 py-4 align-top">
                                <a href="{{ route('admin.orders.show', $order->id) }}" target="_blank" class="block font-bold text-lime-400 hover:text-lime-300 text-sm transition">
                                    {{ $order->invoice_number }}
                                </a>
                                <span class="text-xs text-slate-500 block mt-1">Order: {{ $order->created_at->format('d M Y') }}</span>
                                <span class="px-2 py-0.5 mt-2 inline-block rounded text-[10px] font-bold uppercase border 
                                    {{ $order->order_status == 'production' ? 'text-purple-400 bg-purple-500/10 border-purple-500/20' : 'text-blue-400 bg-blue-500/10 border-blue-500/20' }}">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 align-top">
                                <p class="text-sm font-bold text-white">{{ $order->user->name }}</p>
                                <p class="text-xs text-slate-400 mt-1">{{ rtrim(substr($order->user->address, 0, 40), ',') ?? 'Alamat belum lengkap' }}...</p>
                            </td>

                            <td class="px-6 py-4 align-top">
                                <ul class="space-y-2">
                                    @foreach($order->items as $item)
                                        <li class="text-xs flex items-start gap-2">
                                            <span class="font-bold text-slate-300">{{ $item->quantity }}x</span>
                                            <div>
                                                <span class="text-slate-400">{{ $item->product ? $item->product->name : 'Item' }}</span>
                                                @if($item->design_id)
                                                    <span class="inline-block ml-1 px-1.5 py-0.5 bg-indigo-500/20 text-indigo-300 text-[9px] uppercase font-bold rounded">Kustom</span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>

                            <td class="px-6 py-4 align-top min-w-[250px]">
                                <input type="text" 
                                       name="tracking_numbers[{{ $order->id }}]" 
                                       value="{{ old('tracking_numbers.' . $order->id, $order->tracking_number) }}"
                                       class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-2.5 text-white text-sm focus:border-lime-400 focus:outline-none focus:ring-1 focus:ring-lime-400 transition placeholder-slate-600"
                                       placeholder="Contoh: JP1234567890">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-slate-500">
                                <i data-lucide="package-check" class="w-16 h-16 mx-auto mb-4 opacity-50 text-lime-500"></i>
                                <p class="text-lg font-bold text-white mb-1">Semua Pesanan Sudah Dikirim!</p>
                                <p class="text-sm">Saat ini tidak ada pesanan aktif yang menunggu resi pengiriman.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Sticky Footer Action -->
            @if($orders->count() > 0)
            <div class="px-6 py-5 bg-navy-950/80 border-t border-slate-800 flex items-center justify-between sticky bottom-0 backdrop-blur-md">
                <div class="text-sm text-slate-400">
                    Menampilkan <span class="font-bold text-white">{{ $orders->count() }}</span> pesanan siap kirim.
                </div>
                <button type="submit" class="bg-lime-500 hover:bg-lime-400 text-navy-900 font-bold px-6 py-2.5 rounded-lg transition shadow-lg shadow-lime-500/20 flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan & Kirim Semua
                </button>
            </div>
            @endif
        </form>
    </div>

@endsection
