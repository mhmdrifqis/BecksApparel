       {{-- Include login modal partial --}}
    @include('partials.login-modal')
   
   <!-- FOOTER -->
    <footer class="bg-navy-950 pt-24 pb-12 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-12 gap-12 mb-16">
                <!-- Brand -->
                <div class="md:col-span-5">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="relative p-1.5 rounded-md"> 
                            <div class="absolute -inset-1 bg-lime-400 rounded-md opacity-60 group-hover:opacity-100 transition duration-500 shadow-sm"></div>
                            <img src="{{ asset('images/Logo-Becks-Crop.png') }}" alt="Becks Apparel" class="h-10 w-auto relative z-10 rounded-sm ">
                        </div>
                        <span class="font-black text-2xl text-white tracking-widest">BECKS<span class="text-lime-400">APPAREL</span></span>
                    </div>
                    <p class="text-slate-400 leading-relaxed mb-8 max-w-sm">
                        Platform manufaktur olahraga digital pertama yang menghubungkan kreativitas tim Anda dengan kualitas produksi standar internasional.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-lime-400 hover:text-navy-950 transition"><i data-lucide="instagram" width="18"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-lime-400 hover:text-navy-950 transition"><i data-lucide="facebook" width="18"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-lime-400 hover:text-navy-950 transition"><i data-lucide="twitter" width="18"></i></a>
                    </div>
                </div>

                <!-- Links -->
                <div class="md:col-span-3">
                    <h4 class="text-white font-bold uppercase tracking-widest mb-8">Menu</h4>
                    <ul class="space-y-4 text-slate-400">
                        <li><a href="#" class="hover:text-lime-400 transition">Beranda</a></li>
                        <li><a href="{{ route('about.us') }}" class="hover:text-lime-400 transition">About Us</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-lime-400 transition">FAQ</a></li>
                        <li><a href="{{ route('terms.conditions') }}" class="hover:text-lime-400 transition">Terms and Conditions</a></li>
                        <li><a href="#" class="hover:text-lime-400 transition">Studio Desain</a></li>
                        <li><a href="#" class="hover:text-lime-400 transition">Katalog</a></li>
                        <li><a href="#" class="hover:text-lime-400 transition">Tracking Order</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="md:col-span-4">
                    <h4 class="text-white font-bold uppercase tracking-widest mb-8">Hubungi Kami</h4>
                    <ul class="space-y-6 text-slate-400">
                        <li class="flex gap-4 items-start">
                            <i data-lucide="map-pin" class="text-lime-400 shrink-0 mt-1"></i>
                            <span>Komplek Villa Bintaro Indah Blok D2 No. 18,<br>Ciputat, Tangerang Selatan</span>
                        </li>
                        <li class="flex gap-4 items-center">
                            <i data-lucide="phone" class="text-lime-400 shrink-0"></i>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex gap-4 items-center">
                            <i data-lucide="mail" class="text-lime-400 shrink-0"></i>
                            <span>becksapparel2018@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500">
                <p>&copy; 2025 Becks Apparel. PT Bola Media Sportainment.</p>
                <p>Project Work: Alfi, Alfred, Rifqi</p>
            </div>
        </div>
</footer>