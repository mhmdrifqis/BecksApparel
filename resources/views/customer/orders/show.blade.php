@extends('layouts.app')

@section('title', 'Invoice ' . $order->invoice_number)

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Nav -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between sm:items-center gap-4 print:hidden">
            <a href="{{ route('customer.orders') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-lime-400 font-bold text-sm uppercase tracking-wider transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Pesanan Saya
            </a>

            @if(in_array($order->payment_status, ['paid', 'awaiting_verification']))
            <button onclick="window.print()" class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-white font-bold px-4 py-2 rounded-lg transition border border-slate-700 shadow-lg shadow-slate-900/50">
                <i data-lucide="printer" class="w-4 h-4 text-lime-400"></i> Cetak / Unduh Bukti
            </button>
            @endif
        </div>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 print:hidden">
            <div>
                <h1 class="text-3xl font-black text-white">INVOICE</h1>
                <p class="text-slate-400 text-lg">#{{ $order->invoice_number }}</p>
            </div>
            <div class="flex gap-3">
                @if($order->payment_status === 'pending')
                    <span class="bg-yellow-500/20 text-yellow-500 border border-yellow-500/50 px-4 py-2 rounded-full font-bold text-sm tracking-widest uppercase">Menunggu Pembayaran</span>
                @elseif($order->payment_status === 'paid')
                    <span class="bg-lime-500/20 text-lime-400 border border-lime-500/50 px-4 py-2 rounded-full font-bold text-sm tracking-widest uppercase">Lunas</span>
                @else
                    <span class="bg-red-500/20 text-red-400 border border-red-500/50 px-4 py-2 rounded-full font-bold text-sm tracking-widest uppercase">{{ $order->payment_status }}</span>
                @endif
            </div>
        </div>

        @if(session('status'))
            <div class="bg-lime-500/20 border border-lime-500/30 text-lime-400 px-6 py-4 rounded-xl mb-8 font-medium print:hidden">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-navy-800 rounded-2xl border border-slate-700 overflow-hidden shadow-xl" id="print-area">
            
            <!-- Area Cetak: Meniru persis layout invoice admin -->
            <div class="print-only-content text-slate-800 bg-white p-10 hidden print:block">
                <!-- Header Invoice Print -->
                <div class="flex justify-between items-start border-b-2 border-slate-200 pb-8 mb-8">
                    <div>
                        <div class="bg-navy-900 p-3 rounded-lg inline-block mb-4">
                            <img src="{{ asset('images/Logo-Becks-Crop.png') }}" alt="Becks Apparel Logo" class="h-8">
                        </div>
                        <h1 class="text-3xl font-black text-navy-900">INVOICE</h1>
                        <p class="text-slate-500 font-bold mt-1">#{{ $order->invoice_number }}</p>
                        <div class="mt-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 uppercase tracking-widest">
                                {{ $order->payment_status === 'paid' ? 'LUNAS' : strtoupper($order->payment_status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-right text-sm">
                        <h3 class="font-bold text-navy-900 text-lg mb-1">PT Becks Apparel Indonesia</h3>
                        <p class="text-slate-500">Jl. Contoh Alamat No. 123<br>Jakarta Selatan, 12345<br>becksapparel@example.com<br>+62 812 3456 7890</p>
                    </div>
                </div>

                <!-- Info Pengirim/Penerima Print -->
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

                <!-- Tabel Item Print -->
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
                        @php $subtotalRaw2 = 0; @endphp
                        @foreach($order->items as $item)
                        @php $subtotalRaw2 += ($item->price * $item->quantity); @endphp
                        <tr>
                            <td class="px-4 py-4">
                                <p class="font-bold text-navy-900">
                                    {{ $item->product ? $item->product->name : 'Produk Tidak Tersedia' }}
                                    @if($item->design_id)
                                        <span class="text-[10px] font-bold bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded uppercase ml-1">Kustom</span>
                                    @endif
                                </p>
                                <p class="text-slate-500 text-xs mt-1">Ukuran: {{ $item->size ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-4 text-center font-bold text-navy-900">{{ $item->quantity }}</td>
                            <td class="px-4 py-4 text-right text-slate-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-4 text-right font-bold text-navy-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Ringkasan Total Print -->
                <div class="flex justify-end mb-12">
                    <div class="w-1/2">
                        <div class="flex justify-between py-2 text-sm text-slate-600 border-b border-slate-100">
                            <span>Subtotal</span>
                            <span class="font-bold">Rp {{ number_format($subtotalRaw2, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mt-4 items-center bg-slate-50 p-4 rounded-lg">
                            <span class="font-bold text-navy-900 uppercase">Total Dibayar</span>
                            <span class="text-2xl font-black text-lime-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Print -->
                <div class="border-t-2 border-slate-200 pt-8 text-center text-slate-500 text-xs mt-auto">
                    <p>Terima kasih atas pesanan Anda. Jika Anda memiliki pertanyaan terkait invoice ini, silakan hubungi becksapparel@example.com.</p>
                    <p class="mt-2 font-bold text-slate-400">© {{ date('Y') }} Becks Apparel. Semua hak dilindungi.</p>
                </div>
            </div>

            <!-- TAMPILAN WEB (NON-PRINT) -->
            <div class="print:hidden">
                <!-- Info Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 p-8 gap-8 border-b border-slate-700">
                    <div>
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Ditagihkan Kepada:</h3>
                        <p class="text-white font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-slate-300 mt-2 whitespace-pre-line">{{ $order->shipping_address }}</p>
                    </div>
                    <div class="sm:text-right">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Tanggal Pesanan:</h3>
                        <p class="text-white font-medium mb-6">{{ $order->created_at->translatedFormat('l, d F Y H:i') }}</p>
                        
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Status Pesanan:</h3>
                        <p class="text-white font-medium capitalize">{{ $order->order_status }}</p>
                        
                        @if($order->tracking_number)
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mt-6 mb-2">Nomor Resi:</h3>
                        <p class="text-lime-400 font-mono tracking-wider font-bold text-lg">{{ $order->tracking_number }}</p>
                        @endif
                    </div>
                </div>

                <!-- Items Section -->
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-700">
                                    <th class="pb-4 pt-2 px-4 text-sm font-bold text-slate-400 uppercase tracking-widest">Produk</th>
                                    <th class="pb-4 pt-2 px-4 text-sm font-bold text-slate-400 uppercase tracking-widest text-center">Qty</th>
                                    <th class="pb-4 pt-2 px-4 text-sm font-bold text-slate-400 uppercase tracking-widest text-right">Harga</th>
                                    <th class="pb-4 pt-2 px-4 text-sm font-bold text-slate-400 uppercase tracking-widest text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @php $subtotalRaw = 0; @endphp
                                @foreach($order->items as $item)
                                @php $subtotalRaw += ($item->price * $item->quantity); @endphp
                                <tr class="group">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-4">
                                            @if($item->design_id && $item->design && $item->design->preview_image)
                                                <img src="{{ asset('storage/' . $item->design->preview_image) }}" alt="Custom Design" class="w-12 h-12 rounded object-contain bg-slate-800 border border-slate-700">
                                            @elseif($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="img" class="w-12 h-12 rounded object-cover border border-slate-700">
                                            @endif
                                            <div>
                                                <p class="text-white font-bold">{{ $item->product ? $item->product->name : 'Produk Dihapus' }}</p>
                                                <p class="text-slate-400 text-xs mt-0.5">Size: {{ $item->size ?? '-' }}</p>
                                                @if($item->design_id)
                                                    <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 uppercase tracking-wider">Desain Kustom</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center text-slate-300">{{ $item->quantity }}</td>
                                    <td class="py-4 px-4 text-right text-slate-300">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="py-4 px-4 text-right text-white font-medium">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div class="mt-8 flex justify-end">
                        <div class="w-full sm:w-1/2 lg:w-1/3 space-y-3">
                            <div class="flex justify-between text-slate-400 text-sm">
                                <span>Subtotal</span>
                                <span class="text-white">Rp {{ number_format($subtotalRaw, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-slate-700 pt-3 flex justify-between items-center mt-3">
                                <span class="text-white font-bold text-lg">Total Tagihan</span>
                                <span class="text-lime-400 font-black text-2xl">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Action -->
                @if(in_array($order->payment_status, ['pending', 'rejected']))
                <div class="bg-navy-950 p-8 border-t border-slate-700">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-6">
                        <div class="text-center sm:text-left">
                            @if($order->payment_status === 'rejected')
                                <h3 class="text-red-400 font-bold mb-1">MOHON MAAF, PEMBAYARAN DITOLAK</h3>
                                <p class="text-slate-400 text-sm">Bukti pembayaran Anda sebelumnya <span class="text-red-400 font-bold">tidak valid</span> atau ditolak oleh admin. Silakan unggah ulang bukti yang benar.</p>
                            @else
                                <h3 class="text-white font-bold mb-1">Segera Lakukan Pembayaran</h3>
                                <p class="text-slate-400 text-sm">Transfer sejumlah <span class="text-lime-400 font-bold">Rp {{ number_format($order->total_amount ?? $order->total_price, 0, ',', '.') }}</span> ke rekening BCA 123456789 a.n PT Becks Apparel.</p>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('customer.payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-center gap-4 bg-navy-900 border border-slate-700 p-4 rounded-xl">
                        @csrf
                        <div class="flex-1 w-full">
                            <label class="block text-sm font-medium text-slate-300 mb-2">Upload Bukti Transfer (JPG/PNG)</label>
                            <input type="file" name="payment_proof" accept="image/*" required class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-lime-500/10 file:text-lime-400 hover:file:bg-lime-500/20">
                            @error('payment_proof')
                                <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full sm:w-auto mt-4 sm:mt-0 px-8 py-3 bg-lime-500 hover:bg-lime-400 text-navy-900 font-black rounded-lg shadow-lg shadow-lime-500/20 transition transform hover:-translate-y-1 self-end">
                            KIRIM BUKTI
                        </button>
                    </form>
                </div>
                @elseif($order->payment_status === 'awaiting_verification')
                <div class="bg-navy-950 p-8 border-t border-slate-700 text-center">
                    <i data-lucide="clock" class="w-12 h-12 text-yellow-500 mx-auto mb-4"></i>
                    <h3 class="text-white font-bold text-xl mb-2">Bukti Pembayaran Sedang Diverifikasi</h3>
                    <p class="text-slate-400">Terima kasih telah melakukan pembayaran. Tim admin kami sedang mengecek mutasi masuk. Pesanan Anda akan diproses setelah pembayaran terverifikasi.</p>
                </div>
                @endif
            </div>

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
        .bg-navy-900, .bg-navy-800, .bg-navy-950 { background-color: white !important; color: black !important; }
        .text-white, .text-slate-400, .text-slate-300 { color: black !important; }
        .border-slate-700 { border-color: #e2e8f0 !important; }
        .min-h-screen { min-height: 0 !important; padding: 0 !important; }
        #print-area { box-shadow: none !important; border: none !important; margin: 0 !important; max-width: 100% !important; border-radius: 0 !important;}
        .print-only-content { display: block !important; }
    }
</style>
@endsection
