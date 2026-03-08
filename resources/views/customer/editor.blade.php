@extends('layouts.app')

@section('title', 'Kustomisasi Desain Anda - Becks Apparel')

@section('content')
<div class="min-h-screen bg-navy-900 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-black text-white">CANVAS <span class="text-lime-400">DESIGNER</span></h1>
            <p class="text-slate-400 mt-2">Kustomisasi produk <span class="text-white font-bold">{{ $product->name }}</span> dengan nama dan nomor kebanggaan Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Area Canvas (Kiri) -->
            <div class="lg:col-span-2 bg-navy-800 rounded-2xl border border-slate-700 p-6 flex flex-col items-center justify-center min-h-[600px] relative overflow-hidden shadow-2xl">
                <!-- Background Mockup Image (akan dimasukkan dari database nanti) -->
                @if($product->image)
                    <img id="mockup-img" src="{{ asset('storage/' . $product->image) }}" class="hidden">
                @endif
                
                <!-- Wrapper Canvas agar responsif -->
                <div id="canvas-wrapper" class="relative w-[500px] h-[600px] bg-slate-900 rounded-xl shadow-inner border border-slate-800 overflow-hidden">
                    <canvas id="tshirt-canvas"></canvas>
                </div>
                
                <!-- Panduan -->
                <div class="absolute bottom-4 left-0 right-0 text-center pointer-events-none">
                    <p class="text-slate-500 text-xs bg-navy-900/80 inline-block px-4 py-2 rounded-full backdrop-blur-sm border border-slate-700/50">Gunakan mouse/jari untuk menggeser, memutar, atau mengubah ukuran teks.</p>
                </div>
            </div>

            <!-- Panel Kontrol (Kanan) -->
            <div class="bg-navy-800 rounded-2xl border border-slate-700 shadow-xl overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-700 bg-navy-900/50">
                    <h3 class="font-bold text-white text-lg flex items-center gap-2">
                        <i data-lucide="settings-2" class="w-5 h-5 text-lime-400"></i> Tool Kustomisasi
                    </h3>
                </div>

                <div class="p-6 space-y-8 flex-1 overflow-y-auto">
                    
                    <!-- Tambah Teks Baru -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-slate-300">Tambahkan Teks</label>
                        <div class="flex gap-2">
                            <input type="text" id="text-input" placeholder="Tulis nama/nomor..." class="w-full bg-navy-900 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:border-lime-400 focus:outline-none focus:ring-1 focus:ring-lime-400 disabled:opacity-50 disabled:cursor-not-allowed">
                            <button id="add-text-btn" class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium px-4 py-2.5 rounded-lg transition shrink-0 flex items-center gap-2">
                                <i data-lucide="plus" class="w-4 h-4"></i> Teks
                            </button>
                        </div>
                    </div>
                    
                    <hr class="border-slate-700">

                    <!-- Pengaturan Objek yang Dipilih -->
                    <div id="selection-controls" class="space-y-6 opacity-30 pointer-events-none transition-opacity duration-300">
                        <h4 class="text-xs font-bold text-lime-400 uppercase tracking-widest">Pengaturan Teks Terpilih</h4>
                        
                        <!-- Font Family -->
                        <div class="space-y-2">
                            <label class="block text-sm text-slate-400">Pilih Font</label>
                            <select id="font-family" class="w-full bg-navy-900 border border-slate-700 rounded-lg px-3 py-2 text-white outline-none focus:border-lime-400">
                                <option value="Arial">Arial (Default)</option>
                                <option value="'Courier New', Courier, monospace">Courier (Klasik)</option>
                                <option value="'Impact', sans-serif">Impact (Bold/Tebal)</option>
                                <option value="'Trebuchet MS', sans-serif">Trebuchet (Sporty)</option>
                            </select>
                        </div>
                        
                        <!-- Warna -->
                        <div class="space-y-3">
                            <label class="block text-sm text-slate-400">Warna Teks</label>
                            <div class="flex gap-3">
                                <!-- Preset Colors -->
                                <button class="color-btn w-8 h-8 rounded-full bg-white border-2 border-slate-300 focus:outline-none focus:ring-2 focus:ring-lime-400 focus:ring-offset-2 focus:ring-offset-navy-800" data-color="#FFFFFF"></button>
                                <button class="color-btn w-8 h-8 rounded-full bg-black border border-slate-700 focus:outline-none focus:ring-2 focus:ring-lime-400 focus:ring-offset-2 focus:ring-offset-navy-800" data-color="#000000"></button>
                                <button class="color-btn w-8 h-8 rounded-full bg-red-600 border border-red-700 focus:outline-none focus:ring-2 focus:ring-lime-400 focus:ring-offset-2 focus:ring-offset-navy-800" data-color="#DC2626"></button>
                                <button class="color-btn w-8 h-8 rounded-full bg-blue-600 border border-blue-700 focus:outline-none focus:ring-2 focus:ring-lime-400 focus:ring-offset-2 focus:ring-offset-navy-800" data-color="#2563EB"></button>
                                <button class="color-btn w-8 h-8 rounded-full bg-yellow-400 border border-yellow-500 focus:outline-none focus:ring-2 focus:ring-lime-400 focus:ring-offset-2 focus:ring-offset-navy-800" data-color="#FACC15"></button>
                                
                                <!-- Custom Color Picker -->
                                <div class="relative ml-auto">
                                    <input type="color" id="custom-color" value="#a3e635" class="w-8 h-8 p-0 cursor-pointer rounded overflow-hidden">
                                </div>
                            </div>
                        </div>

                        <!-- Opsi Hapus -->
                        <div class="pt-2">
                            <button id="delete-btn" class="w-full py-2 bg-red-500/10 hover:bg-red-500/20 text-red-500 border border-red-500/20 rounded-lg text-sm font-bold flex justify-center items-center gap-2 transition">
                                <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus Elemen Terpilih
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Add to Cart -->
                <div class="p-6 bg-navy-900/80 border-t border-slate-700">
                    <form id="save-design-form" action="{{ route('cart.addDesign', $product->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4 space-y-2">
                            <label class="block text-sm font-medium text-slate-300">Pilih Ukuran Kaos/Jersey</label>
                            <select name="size" required class="w-full bg-navy-950 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:border-lime-400 focus:outline-none">
                                <option value="">-- Pilih Ukuran --</option>
                                <option value="S">Small (S)</option>
                                <option value="M">Medium (M)</option>
                                <option value="L">Large (L)</option>
                                <option value="XL">Extra Large (XL)</option>
                                <option value="XXL">Double XL (XXL)</option>
                            </select>
                        </div>

                        <!-- Data tersembunyi untuk dikirim ke backend -->
                        <input type="hidden" name="design_json" id="design_json">
                        <input type="hidden" name="preview_image" id="preview_image">
                        <input type="hidden" name="quantity" value="1">
                        
                        <button type="submit" id="save-btn" class="w-full bg-lime-400 hover:bg-lime-500 text-navy-950 font-black py-4 rounded-xl shadow-[0_0_20px_rgba(163,230,53,0.3)] transition transform hover:-translate-y-1 flex justify-center items-center gap-2 relative overflow-hidden group">
                            <span class="relative z-10 flex items-center gap-2">
                                <i data-lucide="shopping-cart" class="w-5 h-5"></i> SIMPAN DESAIN & KE KERANJANG
                            </span>
                            <div class="absolute inset-0 h-full w-full outline-none transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300 bg-lime-500 z-0"></div>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Load Fabric.js via CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Canvas
        const canvas = new fabric.Canvas('tshirt-canvas', {
            width: 500,
            height: 600,
            backgroundColor: '#1E293B' // navy-800
        });

        // Setup elemen DOM
        const textInput = document.getElementById('text-input');
        const addTextBtn = document.getElementById('add-text-btn');
        const fontFamilySelect = document.getElementById('font-family');
        const colorBtns = document.querySelectorAll('.color-btn');
        const customColorInput = document.getElementById('custom-color');
        const deleteBtn = document.getElementById('delete-btn');
        const selectionControls = document.getElementById('selection-controls');
        const form = document.getElementById('save-design-form');

        // ==== 1. MEMUAT GAMBAR MOCKUP (BACKGROUND) ====
        const mockupImgElement = document.getElementById('mockup-img');
        if (mockupImgElement) {
            fabric.Image.fromURL(mockupImgElement.src, function(img) {
                // Skala gambar agar pas di canvas (misal lebar 400px)
                const scale = 400 / img.width;
                img.set({
                    left: 50, // di tengah-tengah canvas 500px -> (500-400)/2
                    top: 50,
                    scaleX: scale,
                    scaleY: scale,
                    selectable: false, // Background tidak boleh digeser user
                    evented: false     // Abaikan event klik pada background
                });
                canvas.add(img);
                canvas.sendToBack(img);
                
                // Set area yang boleh di-edit (bounding box imajiner)
                // Ini optional, tapi bagus agar text tidak keluar dari kaos
            });
        }

        // ==== 2. MENAMBAHKAN TEKS ====
        addTextBtn.addEventListener('click', function() {
            const textContent = textInput.value.trim();
            if(!textContent) return;

            const newText = new fabric.IText(textContent, {
                left: 250, // tengah x
                top: 200,  // agak atas
                fontFamily: 'Arial',
                fill: '#FFFFFF',
                fontSize: 40,
                originX: 'center',
                originY: 'center',
                fontWeight: 'bold',
                transparentCorners: false,
                cornerColor: '#a3e635',
                cornerStrokeColor: '#1e293b',
                borderColor: '#a3e635',
                cornerSize: 12,
                padding: 10,
                cornerStyle: 'circle',
                borderDashArray: [3, 3]
            });

            canvas.add(newText);
            canvas.setActiveObject(newText);
            canvas.renderAll();
            
            textInput.value = ''; // bersihkan input
        });

        // Trigger tambah teks saat tekan Enter
        textInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addTextBtn.click();
            }
        });

        // ==== 3. MANAJEMEN EVENT KLIK (SELEKSI OBJEK) ====
        // Munculkan / sembunyikan menu pengaturan saat objek diklik
        canvas.on('selection:created', handleSelection);
        canvas.on('selection:updated', handleSelection);
        canvas.on('selection:cleared', handleDeselection);
        
        // Update input tipe jika objek teks di-edit dua kali
        canvas.on('text:changed', function(opt) {
             // Opsional: sinkronisasi jika butuh
        });

        function handleSelection(e) {
            const activeObj = e.selected[0];
            if (activeObj && (activeObj.type === 'i-text' || activeObj.type === 'text')) {
                // Tampilkan menu
                selectionControls.classList.remove('opacity-30', 'pointer-events-none');
                
                // Set nilai Dropdown Font sama dengan properti objek
                fontFamilySelect.value = activeObj.fontFamily;
                
                // Set nilai Color Picker
                customColorInput.value = activeObj.fill;
            }
        }

        function handleDeselection() {
            // Sembunyikan menu
            selectionControls.classList.add('opacity-30', 'pointer-events-none');
        }

        // ==== 4. FUNGSI EDIT TERHADAP OBJEK TERPILIH ====
        // Ganti Font
        fontFamilySelect.addEventListener('change', function() {
            const activeObj = canvas.getActiveObject();
            if (activeObj) {
                activeObj.set('fontFamily', this.value);
                canvas.renderAll();
            }
        });

        // Ganti Warna dari Preset
        colorBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const color = this.getAttribute('data-color');
                customColorInput.value = color; // sync piker
                
                const activeObj = canvas.getActiveObject();
                if (activeObj) {
                    activeObj.set('fill', color);
                    canvas.renderAll();
                }
            });
        });

        // Ganti Warna dari Picker
        customColorInput.addEventListener('input', function() {
            const activeObj = canvas.getActiveObject();
            if (activeObj) {
                activeObj.set('fill', this.value);
                canvas.renderAll();
            }
        });

        // Delete Objek
        deleteBtn.addEventListener('click', function() {
            const activeObj = canvas.getActiveObject();
            if (activeObj) {
                canvas.remove(activeObj);
                canvas.discardActiveObject();
            }
        });

        // Support Delete pakai keyboard (Backspace / Delete)
        window.addEventListener('keydown', function(e) {
            if(e.key === 'Delete' || e.key === 'Backspace') {
                // Jangan hapus kalau user lagi ketik di input box
                if(document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') return;
                
                const activeObj = canvas.getActiveObject();
                if (activeObj && !activeObj.isEditing) { // jangan hapus objek dika lagi mode edit i-text
                    e.preventDefault();
                    canvas.remove(activeObj);
                    canvas.discardActiveObject();
                }
            }
        });

        // ==== 5. SIMPAN KE FORM ====
        form.addEventListener('submit', function(e) {
            // Hilangkan "kotak putus-putus seleksi" sebelum di-screenshot agar bersih
            canvas.discardActiveObject();
            canvas.renderAll();

            // Ekspor JSON
            const json = JSON.stringify(canvas.toJSON());
            document.getElementById('design_json').value = json;

            // Ekspor Gambar Preview (base64 PNG)
            // Kualitas dikurangi sedikit dan dikalikan resolusi standar
            const dataURL = canvas.toDataURL({
                format: 'png',
                quality: 0.8,
                multiplier: 1 // 1 = 500x600 px. Bisa dinaikkan kalau mau lebih HD
            });
            document.getElementById('preview_image').value = dataURL;
        });

    });
</script>
@endsection
