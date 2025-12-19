@extends('layouts.app')

@section('title', 'About Us - Becks Apparel')

@section('content')
<section class="min-h-screen bg-navy-950 pt-32 pb-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl lg:text-6xl font-black text-white mb-6" data-aos="fade-up">
                Tentang <span class="text-gradient">Becks Apparel</span>
            </h1>
            <p class="text-lg text-slate-400 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                Platform manufaktur olahraga digital pertama yang menghubungkan kreativitas tim Anda dengan kualitas produksi standar internasional.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-12 mb-16">
            <div class="glass p-8 rounded-xl" data-aos="fade-right">
                <h2 class="text-2xl font-bold text-white mb-6">Visi Kami</h2>
                <p class="text-slate-400 leading-relaxed">
                    Menjadi platform terdepan dalam industri manufaktur olahraga digital di Indonesia, memberikan kemudahan dan inovasi bagi tim olahraga untuk menciptakan jersey impian mereka dengan teknologi terkini dan kualitas premium.
                </p>
            </div>

            <div class="glass p-8 rounded-xl" data-aos="fade-left">
                <h2 class="text-2xl font-bold text-white mb-6">Misi Kami</h2>
                <ul class="text-slate-400 space-y-3">
                    <li>• Menghubungkan kreativitas dengan teknologi produksi</li>
                    <li>• Memberikan pengalaman desain yang intuitif dan real-time</li>
                    <li>• Menjamin kualitas produk dengan standar internasional</li>
                    <li>• Mendukung perkembangan olahraga di Indonesia</li>
                </ul>
            </div>
        </div>

        <div class="glass p-8 rounded-xl" data-aos="fade-up">
            <h2 class="text-2xl font-bold text-white mb-8 text-center">Mengapa Memilih Becks Apparel?</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-lime-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="palette" class="text-navy-950" width="24"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Canvas Interaktif</h3>
                    <p class="text-slate-400 text-sm">Desain jersey Anda secara real-time dengan tools yang mudah digunakan.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-lime-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="zap" class="text-navy-950" width="24"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Produksi Cepat</h3>
                    <p class="text-slate-400 text-sm">Proses produksi yang efisien dengan tracking order real-time.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-lime-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="shield" class="text-navy-950" width="24"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Kualitas Premium</h3>
                    <p class="text-slate-400 text-sm">Material dan jahitan dengan standar kualitas internasional.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection