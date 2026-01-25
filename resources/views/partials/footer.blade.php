@include('partials.login-modal')

<footer class="bg-navy-950 border-t border-slate-800">
    <div class="mx-auto w-full max-w-7xl p-4 py-6 lg:py-8">
        
        <div class="md:flex md:justify-between">
            
            <div class="mb-6 md:mb-0 md:w-1/3">
                <a href="{{ route('home') }}" class="flex items-center gap-3 mb-4">
                    <div class="relative p-1 rounded-md">
                        <div class="absolute -inset-0.5 bg-lime-400 rounded-md opacity-60 blur-sm"></div>
                        <img src="{{ asset('images/Logo-Becks-Crop.png') }}" class="h-8 w-auto relative z-10 rounded-sm" alt="Becks Logo">
                    </div>
                    <span class="self-center text-2xl font-black whitespace-nowrap text-white tracking-widest">
                        BECKS<span class="text-lime-400">APPAREL</span>
                    </span>
                </a>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                    Platform manufaktur olahraga digital pertama yang menghubungkan kreativitas tim Anda dengan kualitas produksi standar internasional.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:gap-6 sm:grid-cols-2 md:w-2/3 md:justify-end md:flex md:gap-16">
                
                <div>
                    <h2 class="mb-6 text-sm font-bold text-white uppercase tracking-widest">Menu</h2>
                    <ul class="text-slate-400 font-medium space-y-3">
                        <li><a href="{{ route('home') }}" class="hover:text-lime-400 transition">Beranda</a></li>
                        <li><a href="{{ route('about.us') }}" class="hover:text-lime-400 transition">About Us</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-lime-400 transition">FAQ</a></li>
                        <li><a href="{{ route('terms.conditions') }}" class="hover:text-lime-400 transition">Terms & Conditions</a></li>
                        <li><a href="#" class="hover:text-lime-400 transition">Studio Desain</a></li>
                        <li><a href="#" class="hover:text-lime-400 transition">Katalog</a></li>
                    </ul>
                </div>

                <div>
                    <h2 class="mb-6 text-sm font-bold text-white uppercase tracking-widest">Hubungi Kami</h2>
                    <ul class="text-slate-400 font-medium space-y-4">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-lime-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-sm">Komplek Villa Bintaro Indah Blok D2 No. 18,<br>Ciputat, Tangerang Selatan</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-lime-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span class="text-sm">+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-lime-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="text-sm">becksapparel2018@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <hr class="my-6 border-slate-800 sm:mx-auto lg:my-8" />

        <div class="sm:flex sm:items-center sm:justify-between">
            <div class="text-sm text-slate-500 sm:text-center">
                <p>&copy; 2025 <a href="{{ route('home') }}" class="hover:underline hover:text-lime-400">Becks Apparel</a>. PT Bola Media Sportainment.</p>
                <p class="mt-1 text-xs">Project Work: Alfi, Alfred, Rifqi</p>
            </div>
            
            <div class="flex mt-4 sm:justify-center sm:mt-0 space-x-5">
                <a href="#" class="text-slate-400 hover:text-lime-400 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 4.9c.636-.247 1.363-.416 2.427-.465C8.901 4.341 9.256 4.329 11.685 4.329h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.825-.049.905-.039 1.354-.18 1.635-.285.42-.158.756-.367 1.189-.8.433-.433.642-.77.8-1.189.105-.28.246-.73.285-1.635.04-1.035.049-1.535.049-4.406v-.08c0-2.677-.01-3.174-.049-4.209-.039-.905-.18-1.354-.285-1.635-.158-.42-.367-.756-.8-1.189-.433-.433-.77-.642-1.189-.8-.28-.105-.73-.246-1.635-.285-1.035-.04-1.535-.049-4.406-.049h-.08zm4.112 4.298a.96.96 0 110 1.92.96.96 0 010-1.92zm-4.27 1.122a4.109 4.109 0 100 8.217 4.109 4.109 0 000-8.217zm0 1.802a2.307 2.307 0 110 4.614 2.307 2.307 0 010-4.614z" clip-rule="evenodd"/></svg>
                    <span class="sr-only">Instagram</span>
                </a>
                
                <a href="#" class="text-slate-400 hover:text-lime-400 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg>
                    <span class="sr-only">Facebook</span>
                </a>

                <a href="#" class="text-slate-400 hover:text-lime-400 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M13.6823 10.6218L20.2391 3H18.6854L12.9921 9.61788L8.44486 3H3.2002L10.0765 13.0074L3.2002 21H4.75404L10.7663 14.0113L15.5685 21H20.8131L13.6819 10.6218ZM11.5541 13.0956L10.8574 12.0991L5.31391 4.16971H7.70053L12.1742 10.5689L12.8709 11.5655L18.6861 19.8835H16.2995L11.5541 13.096V13.0956Z"/></svg>
                    <span class="sr-only">Twitter</span>
                </a>
            </div>
        </div>
    </div>
</footer>