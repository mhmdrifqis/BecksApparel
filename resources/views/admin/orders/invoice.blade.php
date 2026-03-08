@extends('layouts.dashboard')

@section('title', 'Cetak Invoice #' . $order->invoice_number)

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 gap-4">
        <a href="{{ route('admin.orders.invoices') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition group print:hidden">
            <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Riwayat
        </a>
        <div class="flex gap-3 print:hidden">
            @php
                $waMessage = "Halo " . $order->user->name . ",\n\nIni adalah informasi invoice untuk pesanan Anda di Becks Apparel.\n\nNomor Invoice: *" . $order->invoice_number . "*\nTotal Tagihan: *Rp " . number_format($order->total_amount, 0, ',', '.') . "*\nStatus Pesanan: *" . strtoupper($order->order_status) . "*\n\nTerima kasih telah berbelanja!";
                
                // Format phone number to start with 62 for wa.me API
                $rawPhone = $order->user->phone ?? '';
                $phone = preg_replace('/[^0-9]/', '', $rawPhone);
                if (str_starts_with($phone, '0')) {
                    $phone = '62' . substr($phone, 1);
                } elseif (str_starts_with($phone, '8')) {
                    $phone = '62' . $phone;
                }
                
                $waUrl = "https://wa.me/" . $phone . "?text=" . urlencode($waMessage);
            @endphp
            <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-4 py-2 rounded-lg transition shadow-lg shadow-emerald-500/20">
                <i data-lucide="message-circle" class="w-4 h-4"></i> Kirim ke WhatsApp
            </a>
            <button onclick="window.print()" class="inline-flex items-center gap-2 bg-lime-500 hover:bg-lime-400 text-navy-900 font-bold px-4 py-2 rounded-lg transition shadow-lg shadow-lime-500/20">
                <i data-lucide="printer" class="w-4 h-4"></i> Cetak PDF
            </button>
        </div>
    </div>

    <!-- Area Cetak -->
    <div class="bg-white text-slate-800 p-10 rounded-xl shadow-xl border border-slate-200" id="print-area">
        
        <!-- Header Invoice -->
        <div class="flex justify-between items-start border-b-2 border-slate-200 pb-8 mb-8">
            <div>
                <!-- Ganti bg jadi gelap sementara di print krn logo aslinya putih/terang -->
                <div class="bg-navy-900 p-3 rounded-lg inline-block mb-4">
                    <img src="{{ asset('images/Logo-Becks-Crop.png') }}" alt="Becks Apparel Logo" class="h-8">
                </div>
                <h1 class="text-3xl font-black text-navy-900">INVOICE</h1>
                <p class="text-slate-500 font-bold mt-1">#{{ $order->invoice_number }}</p>
                <div class="mt-4">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 uppercase tracking-widest">
                        LUNAS
                    </span>
                </div>
            </div>
            
            <div class="text-right text-sm">
                <h3 class="font-bold text-navy-900 text-lg mb-1">PT Becks Apparel Indonesia</h3>
                <p class="text-slate-500">Jl. Contoh Alamat No. 123<br>Jakarta Selatan, 12345<br>becksapparel@example.com<br>+62 812 3456 7890</p>
            </div>
        </div>

        <!-- Info Pengirim/Penerima -->
        <div class="grid grid-cols-2 gap-8 mb-8 text-sm">
            <div>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-xs mb-2">Ditagihkan Kepada</p>
                <h4 class="font-bold text-navy-900 text-base">{{ $order->user->name }}</h4>
                <p class="text-slate-500 mt-1">{{ $order->user->email }}<br>{{ $order->user->phone }}</p>
                <p class="text-slate-500 mt-2">{{ $order->shipping_address }}</p>
            </div>
            <div class="text-right">
                <div class="grid grid-cols-2 gap-2 text-right">
                    <div class="text-slate-400 font-bold text-xs uppercase tracking-widest">Tanggal Pemesanan</div>
                    <div class="font-bold text-navy-900">{{ $order->created_at->format('d M Y') }}</div>
                    
                    <div class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Tanggal Lunas</div>
                    <div class="font-bold text-navy-900 mt-2">{{ $order->payment && $order->payment->paid_at ? \Carbon\Carbon::parse($order->payment->paid_at)->format('d M Y') : '-' }}</div>
                    
                    <div class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Status Pesanan</div>
                    <div class="font-bold text-navy-900 mt-2 uppercase">{{ $order->order_status }}</div>
                    
                    @if($order->tracking_number)
                    <div class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">Nomor Resi</div>
                    <div class="font-bold text-navy-900 mt-2">{{ $order->tracking_number }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabel Item -->
        <table class="w-full text-left text-sm mb-8">
            <thead>
                <tr class="bg-slate-100 text-slate-600 uppercase text-xs">
                    <th class="px-4 py-3 font-bold rounded-l-lg">Deskripsi Produk</th>
                    <th class="px-4 py-3 font-bold text-center">Qty</th>
                    <th class="px-4 py-3 font-bold text-right">Harga Satuan</th>
                    <th class="px-4 py-3 font-bold text-right rounded-r-lg">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @php $subtotal = 0; @endphp
                @foreach($order->items as $item)
                @php $subtotal += ($item->price * $item->quantity); @endphp
                <tr>
                    <td class="px-4 py-4">
                        <p class="font-bold text-navy-900">
                            {{ $item->product ? $item->product->name : 'Produk Tidak Tersedia' }}
                            @if($item->design_id)
                                <span class="text-[10px] font-bold bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded uppercase ml-1">Kustom</span>
                            @endif
                        </p>
                        <p class="text-slate-500 text-xs mt-1">Ukuran: {{ $item->size ?? '-' }}</p>
                        @if($item->custom_note)
                            <p class="text-slate-500 text-xs italic mt-1">Catatan: "{{ $item->custom_note }}"</p>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-center font-bold text-navy-900">{{ $item->quantity }}</td>
                    <td class="px-4 py-4 text-right text-slate-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-4 text-right font-bold text-navy-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Ringkasan Total -->
        <div class="flex justify-end mb-12">
            <div class="w-1/2">
                <div class="flex justify-between py-2 text-sm text-slate-600 border-b border-slate-100">
                    <span>Subtotal</span>
                    <span class="font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 text-sm text-slate-600 border-b border-slate-100">
                    <span>Ongkos Kirim / Lainnya</span>
                    <span class="font-bold">Rp 0</span>
                </div>
                <!-- Jika ada diskon atau tambahan biaya bisa diletakkan di sini -->
                <div class="flex justify-between mt-4 items-center bg-slate-50 p-4 rounded-lg">
                    <span class="font-bold text-navy-900 uppercase">Total Dibayar</span>
                    <span class="text-2xl font-black text-lime-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t-2 border-slate-200 pt-8 text-center text-slate-500 text-xs">
            <p>Terima kasih atas pesanan Anda. Jika Anda memiliki pertanyaan terkait invoice ini, silakan hubungi becksapparel@example.com.</p>
            <p class="mt-2 font-bold text-slate-400">© {{ date('Y') }} Becks Apparel. Semua hak dilindungi.</p>
        </div>

    </div>
</div>

<style>
    @media print {
        @page { margin: 0; }
        body { 
            background-color: white !important; 
            margin: 0 !important;
            padding: 0 !important;
        }
        .print\:hidden { display: none !important; }
        nav, footer, aside, header { display: none !important; }
        #print-area { box-shadow: none !important; border: none !important; margin: 0 !important; padding: 0 !important; max-width: 100% !important; border-radius: 0 !important; }
        .sm\:ml-64 { margin-left: 0 !important; }
        .mt-16 { margin-top: 0 !important; padding-top: 0 !important; }
        .max-w-4xl { max-width: 100% !important; }
        .p-10 { padding: 40px !important; } /* keep inner padding for the print area */
    }
</style>

@endsection
