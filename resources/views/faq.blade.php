@extends('layouts.app')

@section('title', 'FAQ - Becks Apparel')

@section('content')
<section class="min-h-screen bg-navy-950 pt-32 pb-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl lg:text-6xl font-black text-white mb-6" data-aos="fade-up">
                Frequently Asked <span class="text-gradient">Questions</span>
            </h1>
            <p class="text-lg text-slate-400 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                Temukan jawaban untuk pertanyaan umum tentang layanan Becks Apparel.
            </p>
        </div>

        <div class="space-y-6">
            <div class="glass p-6 rounded-xl" data-aos="fade-up">
                <h3 class="text-xl font-bold text-white mb-4">Bagaimana cara memesan jersey custom?</h3>
                <p class="text-slate-400 leading-relaxed">
                    Anda dapat memesan jersey custom melalui platform kami. Pilih template, gunakan canvas interaktif untuk mendesain, lalu lakukan pembayaran. Tim kami akan memproses pesanan Anda dalam 3-5 hari kerja.
                </p>
            </div>

            <div class="glass p-6 rounded-xl" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-xl font-bold text-white mb-4">Berapa lama waktu produksi?</h3>
                <p class="text-slate-400 leading-relaxed">
                    Waktu produksi standar adalah 7-10 hari kerja setelah desain final disetujui. Untuk pesanan urgent, kami menyediakan layanan express dengan biaya tambahan.
                </p>
            </div>

            <div class="glass p-6 rounded-xl" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-xl font-bold text-white mb-4">Apakah ada jaminan kualitas?</h3>
                <p class="text-slate-400 leading-relaxed">
                    Ya, semua produk kami menggunakan material premium dengan standar kualitas internasional. Kami memberikan garansi 1 tahun untuk cacat produksi.
                </p>
            </div>

            <div class="glass p-6 rounded-xl" data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-xl font-bold text-white mb-4">Bagaimana cara tracking pesanan?</h3>
                <p class="text-slate-400 leading-relaxed">
                    Setelah pesanan dikonfirmasi, Anda akan menerima nomor tracking melalui email. Anda dapat memantau status pesanan secara real-time di halaman Tracking Order.
                </p>
            </div>

            <div class="glass p-6 rounded-xl" data-aos="fade-up" data-aos-delay="400">
                <h3 class="text-xl font-bold text-white mb-4">Apakah bisa request desain custom?</h3>
                <p class="text-slate-400 leading-relaxed">
                    Tentu! Platform kami dirancang untuk memberikan kebebasan penuh dalam mendesain. Jika Anda memiliki desain khusus, tim desainer kami siap membantu mewujudkannya.
                </p>
            </div>

            <div class="glass p-6 rounded-xl" data-aos="fade-up" data-aos-delay="500">
                <h3 class="text-xl font-bold text-white mb-4">Metode pembayaran apa yang tersedia?</h3>
                <p class="text-slate-400 leading-relaxed">
                    Kami menerima pembayaran melalui transfer bank, e-wallet (GoPay, OVO, Dana), dan kartu kredit. Semua transaksi dijamin aman dengan enkripsi SSL.
                </p>
            </div>
        </div>

        <div class="text-center mt-16" data-aos="fade-up">
            <p class="text-slate-400 mb-6">Masih ada pertanyaan?</p>
            <a href="#" class="px-8 py-4 bg-lime-400 hover:bg-lime-500 text-navy-950 text-lg font-bold rounded-xl transition transform hover:scale-105">
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection