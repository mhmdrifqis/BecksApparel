@extends('layouts.app')

@section('title', 'Jersey Customizer - Beck\'s Apparel')

@section('content')

{{-- ============================================================ --}}
{{-- HEAD EXTRAS (injected into layout via stack or direct embed) --}}
{{-- ============================================================ --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    const IS_LOGGED_IN = @json(Auth::check());
    const LOGIN_URL = "{{ route('login') }}";
    
    // UPDATE THIS: Use the route name and pass the $product variable from your controller
    // This will generate something like "/cart/add-design/5"
    const SAVE_DESIGN_URL = "{{ route('cart.addDesign', $product->id) }}"; 
</script>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    navy: { 950: '#020617', 900: '#0f172a', 800: '#1e293b' },
                    lime: { 400: '#a3e635', 500: '#84cc16' },
                },
                fontFamily: { sans: ['Inter', 'sans-serif'] },
            }
        }
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&family=Montserrat:wght@700;900&display=swap" rel="stylesheet">

<style>
    .glass-card { background:rgba(15,23,42,0.6); backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,0.08); }
    .btn-primary { background:linear-gradient(135deg,#a3e635 0%,#84cc16 100%); color:#020617; font-weight:900; transition:all 0.3s; }
    .btn-primary:hover { box-shadow:0 0 30px rgba(163,230,53,0.4); transform:translateY(-2px); }
    .btn-primary:disabled { opacity:0.4; cursor:not-allowed; transform:none; box-shadow:none; }
    .btn-secondary { background:rgba(163,230,53,0.08); border:1.5px solid rgba(163,230,53,0.25); color:#a3e635; transition:all 0.3s; }
    .btn-secondary:hover { border-color:#a3e635; background:rgba(163,230,53,0.15); transform:translateY(-2px); }
    .section-collapse { overflow:hidden; transition:max-height 0.35s cubic-bezier(0.4,0,0.2,1),opacity 0.25s; max-height:0; opacity:0; }
    .section-collapse.open { max-height:9999px; opacity:1; }
    canvas { max-width:100%; height:auto !important; }
    .toast { position:fixed; bottom:2rem; right:2rem; padding:0.9rem 1.4rem; border-radius:0.75rem; font-weight:700; font-size:0.8rem; z-index:9999; transform:translateY(100px); opacity:0; transition:all 0.35s cubic-bezier(0.34,1.56,0.64,1); pointer-events:none; max-width:320px; }
    .toast.show { transform:translateY(0); opacity:1; }
    .toast-success { background:#a3e635; color:#020617; }
    .toast-error { background:#ef4444; color:white; }
    .toast-info { background:#06b6d4; color:#020617; }
    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:rgba(255,255,255,0.03); }
    ::-webkit-scrollbar-thumb { background:rgba(163,230,53,0.3); border-radius:2px; }
    ::-webkit-scrollbar-thumb:hover { background:rgba(163,230,53,0.6); }
    #logo-upload::file-selector-button { background:rgba(168,85,247,0.15); color:#a855f7; font-weight:700; border:none; padding:6px 12px; border-radius:6px; cursor:pointer; font-size:11px; transition:background 0.2s; margin-right:8px; }
    #logo-upload::file-selector-button:hover { background:rgba(168,85,247,0.28); }
    .swatch-btn.active { outline:2.5px solid #a3e635; outline-offset:2px; border-color:white !important; }
    #view-front canvas, #view-back canvas { filter:drop-shadow(0 0 24px rgba(163,230,53,0.15)); }
</style>

{{-- ============================================================ --}}
{{-- LOADING OVERLAY & TOAST                                       --}}
{{-- ============================================================ --}}
<div id="loading-overlay" class="fixed inset-0 z-[9999] flex-col items-center justify-center hidden" style="background:rgba(2,6,23,0.85);backdrop-filter:blur(8px);">
    <div class="w-12 h-12 border-4 rounded-full animate-spin" style="border-color:#0f172a; border-top-color:#a3e635;"></div>
    <p id="loading-text" class="mt-4 text-sm font-bold tracking-widest uppercase text-white animate-pulse">Memproses...</p>
</div>

<div id="toast" class="toast"></div>

{{-- ============================================================ --}}
{{-- MAIN PAGE WRAPPER (Code 2 layout structure)                   --}}
{{-- ============================================================ --}}
<div class="min-h-screen bg-navy-900 pt-6 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Page Header (Code 2 style) --}}
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-white">JERSEY <span class="text-lime-400">CUSTOMIZER</span></h1>
                <p class="text-slate-400 mt-1">Kustomisasi jersey Anda dengan nama, nomor, logo, dan warna pilihan.</p>
            </div>
            {{-- Top Action Buttons (from Code 1 navbar) --}}
            <div class="flex gap-2 flex-wrap">
                <button id="btn-bulk-export" class="btn-secondary px-3 py-2 rounded-lg text-xs font-bold flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Bulk Roster
                </button>
                <button id="btn-export-json" class="btn-secondary px-3 py-2 rounded-lg text-xs font-bold flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export JSON
                </button>
                <button id="btn-export-img" class="btn-secondary px-3 py-2 rounded-lg text-xs font-bold flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Download
                </button>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- TWO-COLUMN GRID (Code 2: lg:grid-cols-3)                      --}}
        {{-- ============================================================ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ======================================================== --}}
            {{-- LEFT COLUMN: CANVAS AREA (lg:col-span-2) — Code 2 layout  --}}
            {{-- ======================================================== --}}
            <div class="lg:col-span-2 bg-navy-800 rounded-2xl border border-slate-700 p-6 flex flex-col items-center justify-center min-h-[600px] relative overflow-hidden shadow-2xl">

                {{-- Front/Back View Toggle (from Code 1) --}}
                <div class="absolute top-4 left-1/2 -translate-x-1/2 z-20 flex gap-1 p-1 rounded-full" style="background:rgba(15,23,42,0.85);border:1px solid rgba(255,255,255,0.1);backdrop-filter:blur(12px);">
                    <button class="view-btn px-4 py-1.5 rounded-full text-xs font-bold transition flex items-center gap-1.5" data-view="front" style="background:#a3e635;color:#020617;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Front
                    </button>
                    <button class="view-btn px-4 py-1.5 rounded-full text-xs font-bold transition flex items-center gap-1.5 text-slate-400" data-view="back">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        Back
                    </button>
                </div>

                {{-- Canvas: Front View --}}
                <div id="view-front" class="flex items-center justify-center w-full pt-12 overflow-auto" style="background:linear-gradient(135deg,rgba(30,41,59,0.2),rgba(15,23,42,0.3));">
                    <div class="rounded-xl overflow-hidden" style="border:1px solid rgba(163,230,53,0.2);">
                        <canvas id="fabric-canvas-front" width="500" height="680"></canvas>
                    </div>
                </div>

                {{-- Canvas: Back View --}}
                <div id="view-back" style="display:none;" class="items-center justify-center w-full pt-12 overflow-auto" style="background:linear-gradient(135deg,rgba(30,41,59,0.2),rgba(15,23,42,0.3));">
                    <div class="rounded-xl overflow-hidden" style="border:1px solid rgba(6,182,212,0.2);">
                        <canvas id="fabric-canvas-back" width="500" height="680"></canvas>
                    </div>
                </div>

                {{-- Canvas Guide (Code 2 style) --}}
                <div class="absolute bottom-4 left-0 right-0 text-center pointer-events-none">
                    <p class="text-slate-500 text-xs bg-navy-900/80 inline-block px-4 py-2 rounded-full backdrop-blur-sm border border-slate-700/50">
                        Drag/resize logo di canvas · Tekan <kbd style="background:rgba(255,255,255,0.08);padding:1px 5px;border-radius:3px;">Delete</kbd> untuk hapus logo
                    </p>
                </div>
            </div>

            {{-- ======================================================== --}}
            {{-- RIGHT COLUMN: CONTROL PANEL (Code 2 layout)               --}}
            {{-- ======================================================== --}}
            <div class="bg-navy-800 rounded-2xl border border-slate-700 shadow-xl overflow-hidden flex flex-col">

                {{-- Panel Header (Code 2 style) --}}
                <div class="p-5 border-b border-slate-700 bg-navy-900/50">
                    <h3 class="font-bold text-white text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-lime-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                        Tool Kustomisasi
                    </h3>
                </div>

                {{-- Scrollable controls area --}}
                <div class="p-4 space-y-3 flex-1 overflow-y-auto">

                    {{-- ---- PRODUCT CONFIG ACCORDION ---- --}}
                    <div class="rounded-xl overflow-hidden" style="border:1px solid rgba(255,255,255,0.08)">
                        <button class="section-toggle w-full flex justify-between items-center p-3.5 font-bold text-white text-sm" style="background:rgba(255,255,255,0.05);" data-section="config">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="#a3e635" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                                Product Config
                            </span>
                            <span class="toggle-icon font-black text-base" style="color:#a3e635;">−</span>
                        </button>
                        <div id="section-config" class="section-collapse open p-4 space-y-4" style="background:rgba(30,41,59,0.4);border-top:1px solid rgba(255,255,255,0.05);">
                            <div>
                                <label class="text-xs font-bold uppercase tracking-wider" style="color:#a3e635;">Jersey Type</label>
                                <select id="jersey-category" class="w-full mt-1.5 p-2.5 rounded-lg text-white text-sm focus:outline-none transition" style="background:#0f172a;border:1px solid rgba(255,255,255,0.1);">
                                    <option value="o-neck" selected>O-Neck</option>
                                    <option value="v-neck">V-Neck</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase tracking-wider" style="color:#a3e635;">Collar Style</label>
                                <div id="collar-style-buttons" class="grid grid-cols-2 sm:grid-cols-3 gap-2 mt-1.5"></div>
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase tracking-wider" style="color:#a3e635;">Base Size</label>
                                <select id="jersey-size" class="w-full mt-1.5 p-2.5 rounded-lg text-white text-sm focus:outline-none" style="background:#0f172a;border:1px solid rgba(255,255,255,0.1);">
                                    <option value="s">Small</option>
                                    <option value="m" selected>Medium</option>
                                    <option value="l">Large</option>
                                    <option value="xl">XL</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- ---- COLORS & PATTERNS ACCORDION ---- --}}
                    <div class="rounded-xl overflow-hidden" style="border:1px solid rgba(255,255,255,0.08)">
                        <button class="section-toggle w-full flex justify-between items-center p-3.5 font-bold text-white text-sm" style="background:rgba(255,255,255,0.05);" data-section="colors">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="#06b6d4" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
                                Colors & Patterns
                            </span>
                            <span class="toggle-icon font-black text-base" style="color:#06b6d4;">−</span>
                        </button>
                        <div id="section-colors" class="section-collapse open p-4 space-y-4" style="background:rgba(30,41,59,0.4);border-top:1px solid rgba(255,255,255,0.05);">
                            <div>
                                <label class="text-xs font-bold uppercase tracking-wider block mb-2" style="color:#06b6d4;">Body Color</label>
                                <div id="body-colors" class="flex flex-wrap gap-2"></div>
                                <input type="color" id="body-custom-color" value="#1a3a8f" class="mt-2 w-full h-8 rounded cursor-pointer" style="border:1px solid rgba(255,255,255,0.1);">
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase tracking-wider block mb-2" style="color:#06b6d4;">Sleeves Color</label>
                                <div id="sleeve-colors" class="flex flex-wrap gap-2"></div>
                                <input type="color" id="sleeve-custom-color" value="#c8102e" class="mt-2 w-full h-8 rounded cursor-pointer" style="border:1px solid rgba(255,255,255,0.1);">
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase tracking-wider block mb-2" style="color:#06b6d4;">Collar Color</label>
                                <div id="collar-colors" class="flex flex-wrap gap-2"></div>
                                <input type="color" id="collar-custom-color" value="#f0f0f0" class="mt-2 w-full h-8 rounded cursor-pointer" style="border:1px solid rgba(255,255,255,0.1);">
                            </div>
                            <div>
                                <label class="text-xs font-bold uppercase tracking-wider block mb-1.5" style="color:#06b6d4;">Pattern Style</label>
                                <select id="pattern-select" class="w-full p-2.5 rounded-lg text-white text-sm focus:outline-none" style="background:#0f172a;border:1px solid rgba(255,255,255,0.1);">
                                    <option value="solid">Solid / Polos</option>
                                    <option value="stripe">Vertical Stripes</option>
                                    <option value="checkered">Checkered / Kotak</option>
                                    <option value="hoop">Horizontal Hoops</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- ---- LOGOS & GRAPHICS ACCORDION ---- --}}
                    <div class="rounded-xl overflow-hidden" style="border:1px solid rgba(255,255,255,0.08)">
                        <button class="section-toggle w-full flex justify-between items-center p-3.5 font-bold text-white text-sm" style="background:rgba(255,255,255,0.05);" data-section="logos">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="#a855f7" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                Logos & Graphics
                            </span>
                            <span class="toggle-icon font-black text-base" style="color:#a855f7;">+</span>
                        </button>
                        <div id="section-logos" class="section-collapse p-4 space-y-3" style="background:rgba(30,41,59,0.4);border-top:1px solid rgba(255,255,255,0.05);">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" style="color:#a855f7;">Upload Logo</label>
                                <input type="file" id="logo-upload" accept="image/*" class="w-full text-xs text-slate-400">
                                <div id="logo-preview" class="mt-2 hidden">
                                    <img id="logo-preview-img" src="" alt="preview" class="h-14 w-auto rounded object-contain p-1" style="border:1px solid rgba(255,255,255,0.1);background:rgba(255,255,255,0.04);">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" style="color:#a855f7;">Position</label>
                                <select id="logo-zone" class="w-full p-2.5 rounded-lg text-white text-sm focus:outline-none" style="background:#0f172a;border:1px solid rgba(255,255,255,0.1);">
                                    <option value="leftChest">Left Chest (Logo Klub)</option>
                                    <option value="rightChest">Right Chest (Apparel)</option>
                                    <option value="centerSponsor">Center (Sponsor)</option>
                                    <option value="sleeves">Sleeves</option>
                                </select>
                            </div>
                            <button id="btn-place-logo" class="btn-primary w-full py-2.5 rounded-lg text-xs font-bold flex items-center justify-center gap-2" disabled>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                Place on Jersey
                            </button>
                            <p class="text-xs text-center" style="color:#64748b;">💡 Drag & resize logo di canvas · Tekan <kbd style="background:rgba(255,255,255,0.08);padding:1px 4px;border-radius:3px;">Delete</kbd> untuk hapus</p>
                        </div>
                    </div>

                    {{-- ---- TEAM ROSTER ACCORDION ---- --}}
                    <div id="roster-panel-container" class="rounded-xl overflow-hidden" style="border:1px solid rgba(255,255,255,0.08)">
                        <button class="section-toggle w-full flex justify-between items-center p-3.5 font-bold text-white text-sm" style="background:rgba(255,255,255,0.05);" data-section="roster">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="#a3e635" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                Team Roster (Nameset)
                            </span>
                            <span class="toggle-icon font-black text-base" style="color:#a3e635;">+</span>
                        </button>
                        <div id="section-roster" class="section-collapse p-4 space-y-3" style="background:rgba(30,41,59,0.4);border-top:1px solid rgba(255,255,255,0.05);">
                            <div>
                                <label class="text-xs font-bold uppercase tracking-wider" style="color:#a3e635;">Editing Side</label>
                                <select id="roster-side" class="w-full mt-1.5 p-2 rounded-lg text-xs text-white focus:outline-none" style="background:#0f172a;border:1px solid rgba(255,255,255,0.1);">
                                    <option value="back">Back</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider" style="color:#a3e635;">Font</label>
                                    <select id="roster-font" class="w-full mt-1.5 p-2 rounded-lg text-xs text-white focus:outline-none" style="background:#0f172a;border:1px solid rgba(255,255,255,0.1);">
                                        <option value="Arial">Arial</option>
                                        <option value="Impact">Impact</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="'Courier New'">Courier</option>
                                        <option value="'Times New Roman'">Times</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider" style="color:#a3e635;">Color</label>
                                    <input type="color" id="roster-color" value="#FFFFFF" class="w-full mt-1.5 h-9 rounded cursor-pointer" style="border:1px solid rgba(255,255,255,0.1);">
                                </div>
                            </div>
                            <p class="text-xs" style="color:#64748b;">Preview menampilkan player pertama. Semua player dirender saat checkout.</p>
                            <button id="btn-add-player" class="w-full py-2 rounded-lg text-xs font-bold transition flex items-center justify-center gap-2" style="background:rgba(163,230,53,0.1);color:#a3e635;border:1px solid rgba(163,230,53,0.3);">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Add Player
                            </button>
                            <div id="roster-list" class="max-h-52 overflow-y-auto rounded-lg p-2 space-y-2" style="background:rgba(15,23,42,0.5);border:1px solid rgba(255,255,255,0.05);">
                                <p id="roster-empty" class="text-center text-xs py-3" style="color:#64748b;">No players added yet.</p>
                            </div>
                        </div>
                    </div>

                </div>{{-- end scrollable controls --}}

                {{-- ---- BOTTOM: ADD TO CART (Code 2 style) ---- --}}
                <div class="p-5 bg-navy-900/80 border-t border-slate-700">
                    <div class="mb-3 space-y-2">
                        <label class="block text-sm font-medium text-slate-300">Pilih Ukuran Jersey</label>
                        <select id="jersey-size-cart" class="w-full p-2.5 rounded-lg text-white text-sm focus:outline-none" style="background:#0f172a;border:1px solid rgba(255,255,255,0.1);">
                            <option value="">-- Pilih Ukuran --</option>
                            <option value="S">Small (S)</option>
                            <option value="M">Medium (M)</option>
                            <option value="L">Large (L)</option>
                            <option value="XL">Extra Large (XL)</option>
                            <option value="XXL">Double XL (XXL)</option>
                        </select>
                    </div>
                    <button id="btn-cart" class="btn-primary w-full py-3.5 rounded-xl text-sm font-black flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        SIMPAN DESAIN & KE KERANJANG
                    </button>
                </div>

            </div>{{-- end right column --}}

        </div>{{-- end grid --}}
    </div>{{-- end container --}}
</div>{{-- end min-h-screen --}}


{{-- ============================================================ --}}
{{-- SCRIPTS (all from Code 1, untouched)                          --}}
{{-- ============================================================ --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>

<script>
// ================================================================
// UTILITIES
// ================================================================
function toggleLoader(show, text = 'Memproses...') {
    const overlay = document.getElementById('loading-overlay');
    const textEl = document.getElementById('loading-text');
    if (!overlay) return;
    textEl.textContent = text;
    if (show) { overlay.classList.remove('hidden'); overlay.classList.add('flex'); }
    else { overlay.classList.add('hidden'); overlay.classList.remove('flex'); }
}

function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = `toast toast-${type} show`;
    clearTimeout(t._timer);
    t._timer = setTimeout(() => t.classList.remove('show'), 3200);
}

// ================================================================
// SVG PATH DATA
// ================================================================
const S = 1.2;
const BODY_X = 110, BODY_Y = 118;
const L_ARM_X = BODY_X - 51 * S, L_ARM_Y = BODY_Y + 37;
const R_ARM_X = BODY_X + 222.5 * S, R_ARM_Y = BODY_Y + 37;
const COLLAR_X = BODY_X + 240 * S / 2 - 102 * S / 2;
const COLLAR_Y = BODY_Y - 7 * S + 8;
const SHADE_BODY_X = BODY_X + 234.5, SHADE_BODY_Y = BODY_Y + 97;
const SHADE_L_ARM_X = L_ARM_X + 3, SHADE_L_ARM_Y = L_ARM_Y + 1;
const SHADE_R_ARM_X = R_ARM_X + 0, SHADE_R_ARM_Y = R_ARM_Y + 1;

const PATH_BODY_FILL = "M221.89 151.66C221.87 142.17 221.88 132.6 222.1 123.02C222.85 91.13 226.06 59.21 239.08 30.71C239.01 30.64 238.93 30.59 238.86 30.52C235.49 27.73 231.29 26.17 227.18 24.66C208.09 17.65 189 10.64 169.91 3.63C167.07 2.59 164.22 1.55 161.38 0.51C161.03 1.46 160.64 2.39 160.2 3.31C157.09 9.92 152.09 15.63 145.9 19.53C138.28 24.33 127.77 25.06 120.04 25.06H119.54C111.81 25.06 101.29 24.33 93.68 19.53C87.5 15.63 82.49 9.92 79.38 3.31C78.94 2.39 78.55 1.45 78.2 0.5C75.36 1.55 72.51 2.59 69.67 3.64C50.57 10.65 31.48 17.66 12.39 24.67C8.29 26.18 4.09 27.74 0.72 30.53C0.64 30.6 0.56 30.65 0.5 30.72C13.51 59.22 16.73 91.13 17.48 123.02V123.04C17.69 132.62 17.7 142.19 17.68 151.67C17.58 209.67 17.46 267.67 17.36 325.67C17.35 328.31 17.35 330.97 17.35 333.61C51.37 336.95 86.8 336.97 119.53 336.97H120.08C152.81 336.97 188.24 336.95 222.26 333.61C222.26 330.97 222.25 328.31 222.25 325.67C222.14 267.67 222.03 209.67 221.91 151.67L221.89 151.66Z";
const PATH_BODY_OUTLINE = PATH_BODY_FILL;
const PATH_BODY_HEM = "M17.34 325.66C51.34 329 86.79 329.02 119.51 329.02H120.06C152.78 329.02 188.22 329 222.23 325.66";
const PATH_L_ARM_FILL = "M50.52 0.5C46.38 4.02 43.87 9.08 41.48 13.99C28.77 40.18 16.04 66.36 3.53 92.12C2.51 94.21 1.5 96.29 0.49 98.36C14.06 109.96 29.55 119.33 46.81 125.76C48.34 123.79 49.85 121.77 51.31 119.73C57.43 111.22 62.84 102.22 67.48 92.83V92.81C66.73 60.92 63.52 29.01 50.5 0.51L50.52 0.5Z";
const PATH_R_ARM_FILL = "M17.46 0.5C21.6 4.02 24.11 9.08 26.5 13.99C39.21 40.18 51.94 66.36 64.45 92.12C65.47 94.21 66.48 96.29 67.49 98.36C53.92 109.96 38.43 119.33 21.17 125.76C19.64 123.79 18.13 121.77 16.67 119.73C10.55 111.22 5.14 102.22 0.5 92.83V92.81C1.25 60.92 4.46 29.01 17.48 0.51L17.46 0.5Z";
const PATH_BODY_BACK_FILL = "M221.89 153.82C221.88 144.33 221.89 134.76 222.11 125.18C222.86 93.29 226.07 61.37 239.09 32.87C239.02 32.8 238.94 32.75 238.87 32.68C235.49 29.89 231.3 28.33 227.19 26.82C206.17 19.1 185.14 11.37 164.12 3.66L155.52 0.5C147.84 2.93 130.82 6.38 119.79 6.38C108.76 6.38 91.76 2.93 84.07 0.5L75.47 3.66C54.44 11.38 33.41 19.11 12.39 26.82C8.29 28.33 4.09 29.89 0.720001 32.68C0.640001 32.75 0.56 32.8 0.5 32.87C13.51 61.37 16.73 93.28 17.48 125.17C17.69 134.76 17.7 144.33 17.68 153.82C17.58 211.82 17.46 269.82 17.36 327.82C17.35 330.46 17.35 333.12 17.35 335.76C51.38 339.1 87.07 339.12 119.8 339.12C152.53 339.12 188.22 339.1 222.26 335.76C222.26 333.12 222.25 330.46 222.25 327.82C222.14 269.82 222.03 211.82 221.91 153.82H221.9Z";
const PATH_BODY_BACK_HEM = "M17.35 327.82C51.38 331.16 87.07 331.18 119.79 331.18C152.51 331.18 188.21 331.16 222.24 327.82";

const DUMMY_COLLAR = [
    { d: "M92.41 2.66C92.06 3.61 91.67 4.54 91.23 5.46C78.51 10.96 63.72 13.41 50.92 13.41H50.7C37.91 13.41 23.12 10.96 10.4 5.46C9.96 4.54 9.57 3.6 9.22 2.65C11.18 1.93 13.13 1.22 15.09 0.5C26.88 4.76 39.78 5.85 50.81 5.85C61.84 5.85 74.74 4.75 86.54 0.5C88.5 1.22 90.45 1.93 92.41 2.66Z", fillAdj: -30, stroke: '#ef4444', strokeW: 1.2, offsetX: -7.9, offsetY: 2 },
    { d: "M91.24 5.46C88.13 12.07 83.13 17.78 76.94 21.68C69.32 26.48 58.81 27.21 51.08 27.21H50.58C42.85 27.21 32.33 26.48 24.72 21.68C18.54 17.78 13.53 12.07 10.42 5.46C23.14 10.96 37.93 13.41 50.72 13.41H50.94C63.74 13.41 78.53 10.96 91.25 5.46H91.24Z", fillAdj: -15, stroke: '#ef4444', strokeW: 1.2, offsetX: -9.42, offsetY: -4 },
    { d: "M101.49 6.11C98.2 15.12 90.78 22.57 81.92 27.13C72.55 31.96 61.83 33.52 51.01 33.52H50.97C40.16 33.52 29.44 31.96 20.06 27.13C11.21 22.57 3.79 15.13 0.5 6.11L9.09 2.48C11.82 10.4 17.98 16.93 25.32 20.95C33.1 25.19 42 26.56 50.96 26.56H51C59.98 26.56 68.87 25.18 76.64 20.95C83.99 16.94 90.15 10.4 92.88 2.48L101.47 6.11H101.49Z", fillAdj: 20, stroke: '#ef4444', strokeW: 1.2, offsetX: 0.5, offsetY: 0 }
];

const COLLAR_LIBRARY = {
    'crew': [
        { d: "M92.41 2.66C92.06 3.61 91.67 4.54 91.23 5.46C78.51 10.96 63.72 13.41 50.92 13.41H50.7C37.91 13.41 23.12 10.96 10.4 5.46C9.96 4.54 9.57 3.6 9.22 2.65C11.18 1.93 13.13 1.22 15.09 0.5C26.88 4.76 39.78 5.85 50.81 5.85C61.84 5.85 74.74 4.75 86.54 0.5C88.5 1.22 90.45 1.93 92.41 2.66Z", fillAdj: -30, stroke: '#292F44', strokeW: 0.7, offsetX: -7.9, offsetY: 2 },
        { d: "M91.24 5.46C88.13 12.07 83.13 17.78 76.94 21.68C69.32 26.48 58.81 27.21 51.08 27.21H50.58C42.85 27.21 32.33 26.48 24.72 21.68C18.54 17.78 13.53 12.07 10.42 5.46C23.14 10.96 37.93 13.41 50.72 13.41H50.94C63.74 13.41 78.53 10.96 91.25 5.46H91.24Z", fillAdj: -15, stroke: '#292F44', strokeW: 0.7, offsetX: -9.42, offsetY: -4 },
        { d: "M101.49 6.11C98.2 15.12 90.78 22.57 81.92 27.13C72.55 31.96 61.83 33.52 51.01 33.52H50.97C40.16 33.52 29.44 31.96 20.06 27.13C11.21 22.57 3.79 15.13 0.5 6.11L9.09 2.48C11.82 10.4 17.98 16.93 25.32 20.95C33.1 25.19 42 26.56 50.96 26.56H51C59.98 26.56 68.87 25.18 76.64 20.95C83.99 16.94 90.15 10.4 92.88 2.48L101.47 6.11H101.49Z", fillAdj: 20, stroke: '#797E91', strokeW: 0.6, offsetX: 0.5, offsetY: 0 }
    ],
    'oneck_combo': [
        { d: "M92.4064 2.66C92.0564 3.61 91.6664 4.54 91.2264 5.46C78.5064 10.96 63.7164 13.41 50.9164 13.41H50.6964C37.9064 13.41 23.1164 10.96 10.3964 5.46C9.95641 4.54 9.56642 3.6 9.21642 2.65C11.1764 1.93 13.1264 1.22 15.0864 0.5C26.8764 4.76 39.7764 5.85 50.8064 5.85C61.8364 5.85 74.7364 4.75 86.5364 0.5C88.4964 1.22 90.4464 1.93 92.4064 2.66Z", fillAdj: -50, stroke: '#292F44', strokeW: 0.7, offsetX: -7.9, offsetY: 2 },
        { d: "M91.2364 5.46C88.1264 12.07 83.1264 17.78 76.9364 21.68C69.3164 26.48 58.8064 27.21 51.0764 27.21H50.5764C42.8464 27.21 32.3264 26.48 24.7164 21.68C18.5364 17.78 13.5264 12.07 10.4164 5.46C23.1364 10.96 37.9264 13.41 50.7164 13.41H50.9364C63.7364 13.41 78.5264 10.96 91.2464 5.46H91.2364Z", fillAdj: -30, stroke: '#292F44', strokeW: 0.7, offsetX: -9.42, offsetY: -4 },
        { d: "M101.493 6.1121C98.1985 15.1187 90.784 22.5701 81.9188 27.1306C72.5499 31.9583 61.8311 33.523 51.0115 33.523H50.9712C40.1617 33.523 29.4429 31.9583 20.064 27.1306C11.2088 22.5701 3.79433 15.1282 0.500107 6.1121L9.09329 2.47704C11.8234 10.3959 17.9786 16.9314 25.3226 20.9481C33.0998 25.1938 41.9952 26.5581 50.9611 26.5581H51.0014C59.9774 26.5581 68.8729 25.1843 76.64 20.9481C83.994 16.941 90.1493 10.3959 92.8794 2.47704L101.473 6.1121H101.493Z", fillAdj: -10, stroke: '#797E91', strokeW: 0.6, offsetX: 0.5, offsetY: 0 },
        { d: "M50.9712 33.523H51.0115C60.0315 33.523 68.9815 32.4355 77.1376 29.2765L73.2815 22.5771C66.3564 25.5452 58.7086 26.5581 51.0014 26.5581H50.9611C43.2754 26.5581 35.6415 25.5556 28.7194 22.595L24.8501 29.2768C33.0116 32.4355 41.9599 33.523 50.9712 33.523Z", fillAdj: 10, stroke: '#B2B7C9', strokeW: 0.5, offsetX: -22.85, offsetY: -20.57 }
    ],
    'changi': [
        { type: 'path', d: "M92.4101 2.66C92.0601 3.61 91.6701 4.54 91.2301 5.46C78.5101 10.96 63.7201 13.41 50.9201 13.41H50.7001C37.9101 13.41 23.1201 10.96 10.4001 5.46C9.96013 4.54 9.57014 3.6 9.22014 2.65C11.1801 1.93 13.1301 1.22 15.0901 0.5C26.8801 4.76 39.7801 5.85 50.8101 5.85C61.8401 5.85 74.7401 4.75 86.5401 0.5C88.5001 1.22 90.4501 1.93 92.4101 2.66Z", fillAdj: -30, stroke: '#292F44', strokeW: 0.7, offsetX: -7.9, offsetY: 2 },
        { type: 'path', d: "M91.2401 5.46C88.1301 12.07 83.1301 17.78 76.9401 21.68C69.3201 26.48 58.8101 27.21 51.0801 27.21H50.5801C42.8501 27.21 32.3301 26.48 24.7201 21.68C18.5401 17.78 13.5301 12.07 10.4201 5.46C23.1401 10.96 37.9301 13.41 50.7201 13.41H50.9401C63.7401 13.41 78.5301 10.96 91.2501 5.46H91.2401Z", fillAdj: -15, stroke: '#292F44', strokeW: 0.7, offsetX: -9.42, offsetY: -4 },
        { type: 'path', d: "M101.496 6.1121C98.2022 15.1187 90.7877 22.5701 81.9225 27.1306C72.5536 31.9583 61.8348 33.523 51.0152 33.523H50.9749C40.1655 33.523 29.4466 31.9583 20.0677 27.1306C11.2126 22.5701 3.79805 15.1282 0.50383 6.1121L9.09702 2.47704C11.8271 10.3959 17.9823 16.9314 25.3263 20.9481C33.1035 25.1938 41.9989 26.5581 50.9649 26.5581H51.0052C59.9812 26.5581 68.8766 25.1843 76.6437 20.9481C83.9978 16.941 90.153 10.3959 92.8831 2.47704L101.476 6.1121H101.496Z", fillAdj: 20, stroke: '#797E91', strokeW: 0.6, offsetX: 0.5, offsetY: 0 },
        { type: 'path', d: "M101.5 5.99999C98.2059 15.0066 91.8653 21.9395 83.0001 26.5C73.6312 31.3277 61.86 33.5 51.0404 33.5H51.0001C40.1907 33.5 28.3791 31.3277 19.0001 26.5C10.145 21.9395 3.79436 15.0161 0.500137 5.99999L10.0001 2.49999C12.7302 10.4189 17.9823 14.9314 25.3263 18.9481C33.1035 23.1938 36.5342 24.5 45.5001 24.5L46.5001 26.5H54.5001L55.5001 24.5C64.4761 24.5 68.8766 23.1843 76.6437 18.9481C83.9978 14.941 88.2701 10.4189 91.0001 2.49999L101.5 5.99999Z", fillAdj: 20, stroke: '#797E91', strokeW: 0.6, offsetX: 0.5, offsetY: 0 },
        { type: 'rect', x: 96.5, y: 24.5, w: 8, h: 27, fillAdj: 0, stroke: '#797E91', strokeW: 0.6, offsetX: 0, offsetY: 0 },
        { type: 'rect', x: 96.5, y: 45.5, w: 8, h: 6, fillAdj: 0, stroke: '#797E91', strokeW: 0.6, offsetX: 0, offsetY: 0 },
        { type: 'rect', x: 96.5, y: 24.5, w: 8, h: 6, fillAdj: 0, stroke: '#797E91', strokeW: 0.6, offsetX: 0, offsetY: 0 }
    ],
    'vneck_1': DUMMY_COLLAR, 'vneck_2': DUMMY_COLLAR, 'vneck_3': DUMMY_COLLAR,
    'vpasung': DUMMY_COLLAR, 'vpasung_combo': DUMMY_COLLAR, 'vclassic_combo': DUMMY_COLLAR,
    'vkerah': DUMMY_COLLAR, 'wangki': DUMMY_COLLAR, 'vclassic': DUMMY_COLLAR
};

const SHADE_BODY_LINES = [
    "M15.05 104.08C22.44 96.32 31.9 90.54 42.18 87.5",
    "M15.59 114.06C23.69 110.81 32.33 108.92 41.05 108.48",
    "M29.68 149.75C28.49 179.06 28.37 208.41 29.32 237.73",
    "M13.8 307.14C33.24 307.81 52.69 308.48 72.13 309.15",
    "M217.42 26.95C202.58 19.19 186.59 13.66 170.13 10.59",
    "M223.54 104.08C216.15 96.32 206.69 90.54 196.41 87.5",
    "M223 114.06C214.9 110.81 206.26 108.92 197.54 108.48",
    "M208.92 149.75C210.11 179.06 210.23 208.41 209.28 237.73",
    "M224.79 307.14C205.35 307.81 185.9 308.48 166.46 309.15",
    "M21.18 26.95C36.02 19.19 52.01 13.66 68.47 10.59"
];
const SHADE_BODY_L = "M16.98 119.38V119.4C17.19 128.98 17.2 138.55 17.18 148.03C17.08 206.03 16.96 264.03 16.86 322.03C16.85 324.67 16.85 327.33 16.85 329.97C19.06 330.19 21.28 330.39 23.51 330.58V160.8C23.51 117.76 20.12 87.89 20.12 87.89C18.62 89.92 17.16 91.89 15.71 93.83C16.41 102.31 16.79 110.85 16.99 119.39L16.98 119.38Z";
const SHADE_BODY_R = "M221.74 322.03C221.63 264.03 221.52 206.03 221.4 148.03C221.38 138.54 221.39 128.97 221.61 119.39C221.79 111.72 222.12 104.05 222.68 96.42C212.1 85.9 204.27 79.79 204.27 79.79C204.27 79.79 196.84 166.27 196.05 225.36C195.46 269.98 197.32 313.25 198.27 331.77C206.13 331.31 213.97 330.73 221.74 329.97C221.74 327.33 221.73 324.67 221.73 322.03H221.74Z";
const SHADE_L_ARM_LINES = [
    "M35.09 46.66C40 34.41 46.63 22.85 54.71 12.42",
    "M19.98 89.52C27.61 97.53 36.69 104.14 46.66 108.93",
    "M48.36 102.65C42.67 99.98 37.66 95.89 33.9 90.86"
];
const SHADE_L_ARM_CUFF = "M0.5 91.64C14.94 103.14 31.11 112.48 48.29 119.24";
const SHADE_L_ARM_SHADOW = "M43.78 125.26C45.31 123.29 46.82 121.27 48.28 119.23C54.4 110.72 59.81 101.72 64.45 92.33V92.31C64.25 83.77 63.87 75.23 63.17 66.75C46.08 89.72 32.97 106.8 25.15 116.85C31.1 120.04 37.31 122.86 43.77 125.26H43.78Z";
const SHADE_R_ARM_LINES = [
    "M29.38 46.66C24.47 34.41 17.84 22.85 9.76 12.42",
    "M44.49 89.52C36.86 97.53 27.78 104.14 17.81 108.93",
    "M16.11 102.65C21.8 99.98 26.81 95.89 30.57 90.86"
];
const SHADE_R_ARM_CUFF = "M63.98 91.64C49.54 103.14 33.37 112.48 16.19 119.24";
const SHADE_R_ARM_SHADOW = "M1.08 69.35C0.51 76.97 0.19 84.64 0.01 92.31V92.33C4.66 101.73 10.07 110.72 16.18 119.23C17.65 121.27 19.15 123.28 20.68 125.26C26.95 122.92 32.99 120.19 38.79 117.12C27.27 97.4 12.56 80.77 1.08 69.35Z";

// ================================================================
// STATE
// ================================================================
const COLORS = ['#ffffff','#000000','#1a3a8f','#c8102e','#22c55e','#eab308','#a855f7','#06b6d4','#f97316','#64748b'];

const state = {
    viewMode: 'front',
    activePlayerIndex: 0,
    config: { jerseyType: 'crew', size: 'm' },
    design: {
        front: {
            zones: { body: { color: '#1a3a8f', pattern: 'solid' }, sleeves: { color: '#c8102e' }, collar: { color: '#f0f0f0' } },
            roster: { players: [], font: 'Arial', color: '#ffffff' }
        },
        back: {
            zones: { body: { color: '#1a3a8f', pattern: 'solid' }, sleeves: { color: '#c8102e' }, collar: { color: '#f0f0f0' } },
            roster: { players: [], font: 'Arial', color: '#ffffff' }
        }
    }
};

let uploadedLogo = null;
let fabricFront = null;
let fabricBack  = null;
let rosterDebounce = null;

// ================================================================
// FABRIC MANAGER
// ================================================================
class FabricManager {
    constructor(canvasId, side = 'front') {
        this.side = side;
        this.canvas = new fabric.Canvas(canvasId, {
            width: 500, height: 680,
            backgroundColor: '#e8eaf0',
            preserveObjectStacking: true
        });
        this.logoObjects   = [];
        this.rosterObjects = [];
        this.onUpdate      = null;

        this._keydownHandler = (e) => {
            if (e.key !== 'Delete' && e.key !== 'Backspace') return;
            const active = this.canvas.getActiveObject();
            if (!active) return;
            const idx = this.logoObjects.indexOf(active);
            if (idx > -1) {
                this.canvas.remove(active);
                this.logoObjects.splice(idx, 1);
                this.trigger();
                showToast('Logo dihapus.', 'info');
            }
        };
        document.addEventListener('keydown', this._keydownHandler);
    }

    renderBaseLayer(bodyColor, sleeveColor, collarColor, pattern, collarType) {
        const savedLogos  = [...this.logoObjects];
        const savedRoster = [...this.rosterObjects];

        this.canvas.clear();
        this.logoObjects   = [];
        this.rosterObjects = [];
        this.canvas.setBackgroundColor('#e8eaf0', () => {});

        const lArmFill = new fabric.Path(PATH_L_ARM_FILL, { fill: sleeveColor, stroke: '#292F44', strokeWidth: 0.8/S, strokeLineCap:'round', strokeLineJoin:'round', selectable:false, evented:false, scaleX:S, scaleY:S, left:L_ARM_X, top:L_ARM_Y });
        const rArmFill = new fabric.Path(PATH_R_ARM_FILL, { fill: sleeveColor, stroke: '#292F44', strokeWidth: 0.8/S, strokeLineCap:'round', strokeLineJoin:'round', selectable:false, evented:false, scaleX:S, scaleY:S, left:R_ARM_X, top:R_ARM_Y });
        this.canvas.add(lArmFill, rArmFill);

        const bodyPathToUse = this.side === 'back' ? PATH_BODY_BACK_FILL : PATH_BODY_FILL;
        const bodyFill = new fabric.Path(bodyPathToUse, {
            fill: bodyColor, stroke: '#292F44', strokeWidth: 0.6/S, strokeLineCap:'round', strokeLineJoin:'round',
            selectable:false, evented:false, scaleX:S, scaleY:S, left:BODY_X, top:BODY_Y
        });
        this.canvas.add(bodyFill);

        if (pattern !== 'solid') { this._renderPattern(pattern, bodyColor, sleeveColor, bodyPathToUse); }

        SHADE_BODY_LINES.forEach(d => {
            const p = new fabric.Path(d, { fill:'transparent', stroke:'#E4E5EB', strokeWidth:0.9/S, strokeLineCap:'round', strokeLineJoin:'round', selectable:false, evented:false, opacity:0.7 });
            p.set({ scaleX:S, scaleY:S, left:BODY_X+(p.left*S), top:BODY_Y+(p.top*S) });
            this.canvas.add(p);
        });
        SHADE_L_ARM_LINES.forEach(d => {
            const p = new fabric.Path(d, { fill:'transparent', stroke:'#E4E5EB', strokeWidth:0.9/S, strokeLineCap:'round', strokeLineJoin:'round', selectable:false, evented:false, opacity:0.7 });
            p.set({ scaleX:S, scaleY:S, left:L_ARM_X+(p.left*S), top:L_ARM_Y+(p.top*S) });
            this.canvas.add(p);
        });
        SHADE_R_ARM_LINES.forEach(d => {
            const p = new fabric.Path(d, { fill:'transparent', stroke:'#E4E5EB', strokeWidth:0.9/S, strokeLineCap:'round', strokeLineJoin:'round', selectable:false, evented:false, opacity:0.7 });
            p.set({ scaleX:S, scaleY:S, left:R_ARM_X+(p.left*S), top:R_ARM_Y+(p.top*S) });
            this.canvas.add(p);
        });

        const pBodyL = new fabric.Path(SHADE_BODY_L, { fill:'#383838', stroke:'none', selectable:false, evented:false, opacity:0.09 });
        pBodyL.set({ scaleX:S, scaleY:S, left:BODY_X+(pBodyL.left*S), top:BODY_Y+(pBodyL.top*S) }); this.canvas.add(pBodyL);
        const pBodyR = new fabric.Path(SHADE_BODY_R, { fill:'#383838', stroke:'none', selectable:false, evented:false, opacity:0.09 });
        pBodyR.set({ scaleX:S, scaleY:S, left:BODY_X+(pBodyR.left*S), top:BODY_Y+(pBodyR.top*S) }); this.canvas.add(pBodyR);
        const pLArmShadow = new fabric.Path(SHADE_L_ARM_SHADOW, { fill:'#383838', stroke:'none', selectable:false, evented:false, opacity:0.09 });
        pLArmShadow.set({ scaleX:S, scaleY:S, left:L_ARM_X+(pLArmShadow.left*S), top:L_ARM_Y+(pLArmShadow.top*S) }); this.canvas.add(pLArmShadow);
        const pRArmShadow = new fabric.Path(SHADE_R_ARM_SHADOW, { fill:'#383838', stroke:'none', selectable:false, evented:false, opacity:0.09 });
        pRArmShadow.set({ scaleX:S, scaleY:S, left:R_ARM_X+(pRArmShadow.left*S), top:R_ARM_Y+(pRArmShadow.top*S) }); this.canvas.add(pRArmShadow);

        const pLCuff = new fabric.Path(SHADE_L_ARM_CUFF, { fill:'transparent', stroke:'#797E91', strokeWidth:0.8/S, strokeLineCap:'round', strokeLineJoin:'round', selectable:false, evented:false });
        pLCuff.set({ scaleX:S, scaleY:S, left:L_ARM_X+(pLCuff.left*S), top:L_ARM_Y+(pLCuff.top*S) }); this.canvas.add(pLCuff);
        const pRCuff = new fabric.Path(SHADE_R_ARM_CUFF, { fill:'transparent', stroke:'#797E91', strokeWidth:0.8/S, strokeLineCap:'round', strokeLineJoin:'round', selectable:false, evented:false });
        pRCuff.set({ scaleX:S, scaleY:S, left:R_ARM_X+(pRCuff.left*S), top:R_ARM_Y+(pRCuff.top*S) }); this.canvas.add(pRCuff);

        const hemPathToUse = this.side === 'back' ? PATH_BODY_BACK_HEM : PATH_BODY_HEM;
        const bodyHem = new fabric.Path(hemPathToUse, { fill:'transparent', stroke:'#797E91', strokeWidth:1/S, strokeLineCap:'round', strokeLineJoin:'round', selectable:false, evented:false, opacity:0.6 });
        bodyHem.set({ scaleX:S, scaleY:S, left:BODY_X+(bodyHem.left*S), top:BODY_Y+(bodyHem.top*S) });
        this.canvas.add(bodyHem);

        this._renderCollar(collarColor, collarType);

        savedLogos.forEach(o  => { this.canvas.add(o); this.logoObjects.push(o); });
        savedRoster.forEach(o => { this.canvas.add(o); this.rosterObjects.push(o); });

        this.trigger();
    }

    _renderPattern(pattern, bodyColor, sleeveColor, maskShapePath) {
        const bx = BODY_X, by = BODY_Y;
        const bw = 240*S, bh = 338*S;
        let patternElements = [];

        if (pattern === 'stripe') {
            for (let x = bx+10; x < bx+bw-10; x+=22)
                patternElements.push(new fabric.Rect({ left:x, top:by+20, width:9, height:bh-40, fill:'rgba(255,255,255,0.18)', selectable:false, evented:false }));
        } else if (pattern === 'checkered') {
            const sz = 26;
            const rows = Math.ceil(bh/sz), cols = Math.ceil(bw/sz);
            for (let r=0;r<rows;r++) for (let c=0;c<cols;c++)
                if ((r+c)%2===0) patternElements.push(new fabric.Rect({ left:bx+c*sz, top:by+r*sz, width:sz, height:sz, fill:'rgba(255,255,255,0.15)', selectable:false, evented:false }));
        } else if (pattern === 'hoop') {
            for (let y=by+20; y<by+bh-20; y+=28)
                patternElements.push(new fabric.Rect({ left:bx, top:y, width:bw, height:12, fill:'rgba(255,255,255,0.18)', selectable:false, evented:false }));
        }

        if (patternElements.length > 0) {
            const patternGroup = new fabric.Group(patternElements, { selectable:false, evented:false });
            const clipMask = new fabric.Path(maskShapePath, { scaleX:S, scaleY:S, left:BODY_X, top:BODY_Y, absolutePositioned:true });
            patternGroup.set({ clipPath: clipMask });
            this.canvas.add(patternGroup);
        }
    }

    _renderCollar(collarColor, collarType) {
        if (this.side === 'back') {
            const bx = BODY_X + (240*S/2) - (87*S/2);
            const by = BODY_Y - (2*S);
            const backPath = "M78.8281 0.524433C50.6238 8.39409 34.9834 8.37822 7.32812 0.524433L1.16066 2.70119C0.312783 3.00044 0.271105 4.1808 1.09272 4.54603C32.4113 18.4683 51.5722 18.1848 84.9251 4.52152C85.7713 4.17487 85.7482 2.9668 84.8858 2.66245L78.8281 0.524433Z";
            this.canvas.add(new fabric.Path(backPath, {
                fill: this._adjustColor(collarColor, 0),
                stroke: '#292F44', strokeWidth: 0.7/S, strokeLineCap:'round', strokeLineJoin:'round',
                selectable:false, evented:false, scaleX:S, scaleY:S, left:bx, top:by
            }));
            return;
        }

        const cx = COLLAR_X, cy = COLLAR_Y;
        const layers = COLLAR_LIBRARY[collarType] || COLLAR_LIBRARY['crew'];

        layers.forEach(layer => {
            const fillColor = layer.isTransparent ? 'transparent' : this._adjustColor(collarColor, layer.fillAdj);
            const options = {
                fill: fillColor, stroke: layer.stroke, strokeWidth: layer.strokeW/S,
                strokeLineCap:'round', strokeLineJoin:'round', selectable:false, evented:false, scaleX:S, scaleY:S
            };
            if (layer.type === 'path' || !layer.type) {
                options.left = cx - ((layer.offsetX||0)*S);
                options.top  = cy - ((layer.offsetY||0)*S);
                this.canvas.add(new fabric.Path(layer.d, options));
            } else if (layer.type === 'rect') {
                options.left   = cx + ((layer.x-51)*S);
                options.top    = cy + (layer.y*S);
                options.width  = layer.w;
                options.height = layer.h;
                this.canvas.add(new fabric.Rect(options));
            }
        });
    }

    _adjustColor(hex, amount) {
        const h = hex.replace('#','');
        const num = parseInt(h.length===3 ? h.split('').map(c=>c+c).join('') : h, 16);
        const r = Math.max(0,Math.min(255,(num>>16)+amount));
        const g = Math.max(0,Math.min(255,((num>>8)&0xff)+amount));
        const b = Math.max(0,Math.min(255,(num&0xff)+amount));
        return `rgb(${r},${g},${b})`;
    }

    addLogo(dataUrl, zone) {
        fabric.Image.fromURL(dataUrl, (img) => {
            if (!img) { showToast('Gagal memuat gambar logo.','error'); return; }
            const positions = {
                leftChest:     { left:345, top:290, scale:0.11 },
                rightChest:    { left:165, top:290, scale:0.11 },
                centerSponsor: { left:250, top:400, scale:0.22 },
                sleeves:       { left:70,  top:280, scale:0.09 }
            };
            const p = positions[zone] || positions.centerSponsor;
            img.set({ left:p.left, top:p.top, scaleX:p.scale, scaleY:p.scale, originX:'center', originY:'center',
                selectable:true, hasControls:true, hasBorders:true, borderColor:'#06b6d4', cornerColor:'#a855f7', cornerSize:9, transparentCorners:false });
            this.canvas.add(img);
            this.logoObjects.push(img);
            this.canvas.setActiveObject(img);
            this.trigger();
            showToast('Logo placed! Drag/resize bebas, Delete untuk hapus.','info');
        }, { crossOrigin:'anonymous' });
    }

    renderRoster(player, font, color) {
        if (!player) return;
        const numStr  = (player.number!==''&&player.number!=null) ? String(player.number) : '??';
        const nameStr = (player.name&&player.name.trim()) ? player.name.trim().toUpperCase() : 'PLAYER';
        const isLight = parseInt(color.replace('#',''),16) > 0xffffff/2;
        const strokeColor = isLight ? '#0f172a' : '#ffffff';

        if (!this.nameText || !this.numberText) {
            this.numberText = new fabric.Text(numStr, {
                left:250, top:420, fontSize:145, fontFamily:font, fill:color,
                stroke:strokeColor, strokeWidth:4, paintFirst:'stroke',
                originX:'center', originY:'center', selectable:true, opacity:0.88,
                shadow: new fabric.Shadow({ color:'rgba(0,0,0,0.35)', blur:6, offsetX:2, offsetY:3 })
            });
            this.nameText = new fabric.Text(nameStr, {
                left:250, top:265, fontSize:40, fontFamily:font, fill:color,
                stroke:strokeColor, strokeWidth:2.5, paintFirst:'stroke',
                originX:'center', originY:'center', selectable:true,
                shadow: new fabric.Shadow({ color:'rgba(0,0,0,0.3)', blur:4, offsetX:1, offsetY:2 })
            });
            this.canvas.add(this.numberText, this.nameText);
            this.rosterObjects.push(this.numberText, this.nameText);
        } else {
            this.numberText.set({ text:numStr, fontFamily:font, fill:color, stroke:strokeColor });
            this.nameText.set({ text:nameStr, fontFamily:font, fill:color, stroke:strokeColor });
        }
        this.trigger();
    }

    trigger() { this.canvas.renderAll(); if (this.onUpdate) this.onUpdate(); }

    destroy() { document.removeEventListener('keydown', this._keydownHandler); this.canvas.dispose(); }

    getElement() { return this.canvas.getElement(); }
}

// ================================================================
// COLOR SWATCHES
// ================================================================
function buildSwatches(containerId, getActive, onPick) {
    const el = document.getElementById(containerId);
    if (!el) return;
    el.innerHTML = '';
    COLORS.forEach(color => {
        const btn = document.createElement('button');
        const isActive = getActive() === color;
        btn.className = 'swatch-btn' + (isActive ? ' active' : '');
        btn.style.cssText = `width:28px;height:28px;border-radius:7px;background:${color};border:2px solid ${isActive?'white':'rgba(255,255,255,0.15)'};transition:transform 0.15s;cursor:pointer;`;
        btn.title = color;
        btn.addEventListener('click', () => onPick(color));
        btn.addEventListener('mouseenter', () => { btn.style.transform='scale(1.18)'; });
        btn.addEventListener('mouseleave', () => { btn.style.transform=''; });
        el.appendChild(btn);
    });
}

function rebuildBodySwatches()   { buildSwatches('body-colors',   () => state.design.front.zones.body.color,    setBodyColor); }
function rebuildSleeveSwatches() { buildSwatches('sleeve-colors', () => state.design.front.zones.sleeves.color, setSleeveColor); }
function rebuildCollarSwatches() { buildSwatches('collar-colors', () => state.design.front.zones.collar.color,  setCollarColor); }

// ================================================================
// SECTION ACCORDIONS
// ================================================================
document.querySelectorAll('.section-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
        const panel = document.getElementById(`section-${btn.dataset.section}`);
        const icon  = btn.querySelector('.toggle-icon');
        const isOpen = panel.classList.contains('open');
        panel.classList.toggle('open', !isOpen);
        icon.textContent = isOpen ? '+' : '−';
    });
});

// ================================================================
// VIEW SWITCHING
// ================================================================
const VIEW_COLORS = {
    front: { bg:'#a3e635', color:'#020617' },
    back:  { bg:'#06b6d4', color:'#020617' }
};

function switchView(mode) {
    state.viewMode = mode;
    document.getElementById('view-front').style.display = mode==='front' ? 'flex' : 'none';
    document.getElementById('view-back').style.display  = mode==='back'  ? 'flex' : 'none';

    const rosterPanel = document.getElementById('roster-panel-container');
    if (rosterPanel) rosterPanel.style.display = mode==='front' ? 'none' : 'block';

    document.querySelectorAll('.view-btn').forEach(b => {
        b.style.background=''; b.style.color=''; b.classList.add('text-slate-400');
    });
    const activeBtn = document.querySelector(`.view-btn[data-view="${mode}"]`);
    if (activeBtn) {
        activeBtn.style.background = VIEW_COLORS[mode].bg;
        activeBtn.style.color = VIEW_COLORS[mode].color;
        activeBtn.classList.remove('text-slate-400');
    }

    const rosterSideEl = document.getElementById('roster-side');
    if (rosterSideEl) rosterSideEl.value = mode;
}

document.querySelectorAll('.view-btn').forEach(btn => btn.addEventListener('click', () => switchView(btn.dataset.view)));

// ================================================================
// COLOR HANDLERS
// ================================================================
function setBodyColor(color) {
    state.design.front.zones.body.color = color;
    state.design.back.zones.body.color  = color;
    document.getElementById('body-custom-color').value = color;
    rebuildBodySwatches(); refreshAll();
}
function setSleeveColor(color) {
    state.design.front.zones.sleeves.color = color;
    state.design.back.zones.sleeves.color  = color;
    document.getElementById('sleeve-custom-color').value = color;
    rebuildSleeveSwatches(); refreshAll();
}
function setCollarColor(color) {
    state.design.front.zones.collar.color = color;
    state.design.back.zones.collar.color  = color;
    document.getElementById('collar-custom-color').value = color;
    rebuildCollarSwatches(); refreshAll();
}

document.getElementById('body-custom-color').addEventListener('input',   e => setBodyColor(e.target.value));
document.getElementById('sleeve-custom-color').addEventListener('input',  e => setSleeveColor(e.target.value));
document.getElementById('collar-custom-color').addEventListener('input',  e => setCollarColor(e.target.value));
document.getElementById('pattern-select').addEventListener('change', e => {
    state.design.front.zones.body.pattern = e.target.value;
    state.design.back.zones.body.pattern  = e.target.value;
    refreshAll();
});

// ================================================================
// LOGO
// ================================================================
document.getElementById('logo-upload').addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
    if (file.size > 5*1024*1024) { showToast('File terlalu besar (max 5MB)','error'); return; }
    const reader = new FileReader();
    reader.onload = ev => {
        uploadedLogo = ev.target.result;
        document.getElementById('logo-preview-img').src = uploadedLogo;
        document.getElementById('logo-preview').classList.remove('hidden');
        document.getElementById('btn-place-logo').disabled = false;
    };
    reader.onerror = () => showToast('Gagal membaca file.','error');
    reader.readAsDataURL(file);
});

document.getElementById('btn-place-logo').addEventListener('click', () => {
    if (!uploadedLogo) { showToast('Upload logo dulu!','error'); return; }
    const zone = document.getElementById('logo-zone').value;
    const mgr  = state.viewMode === 'back' ? fabricBack : fabricFront;
    mgr.addLogo(uploadedLogo, zone);
});

// ================================================================
// ROSTER
// ================================================================
function getEditingRoster() { return state.design.back.roster; }

document.getElementById('roster-side').addEventListener('change', () => {
    renderRosterUI();
    const roster = getEditingRoster();
    document.getElementById('roster-font').value  = roster.font;
    document.getElementById('roster-color').value = roster.color;
});

function renderRosterUI() {
    const roster = getEditingRoster();
    const list   = document.getElementById('roster-list');
    const empty  = document.getElementById('roster-empty');
    list.querySelectorAll('.player-row').forEach(r => r.remove());
    empty.style.display = roster.players.length === 0 ? 'block' : 'none';

    roster.players.forEach((player, idx) => {
        const row = document.createElement('div');
        row.className = 'player-row flex gap-1.5 items-center p-2 rounded-lg border transition';
        row.style.cssText = 'background:rgba(30,41,59,0.6);border-color:rgba(255,255,255,0.08);';
        const is = 'background:#0f172a;border:1px solid rgba(255,255,255,0.1);';
        row.innerHTML = `
            <input type="radio" name="activePreview" class="cursor-pointer" ${idx===state.activePlayerIndex?'checked':''}>
            <input type="text" value="${player.name||''}" placeholder="Name" class="flex-1 min-w-0 p-1.5 text-xs rounded text-white placeholder-slate-500 focus:outline-none" style="${is}">
            <input type="number" value="${player.number??''}" placeholder="#" min="0" max="99" class="w-11 p-1.5 text-xs rounded text-white text-center focus:outline-none flex-shrink-0" style="${is}">
            <select class="w-12 p-1.5 text-xs rounded text-white focus:outline-none flex-shrink-0" style="${is}">
                ${['s','m','l','xl'].map(s=>`<option value="${s}" ${(player.size||'m')===s?'selected':''}>${s.toUpperCase()}</option>`).join('')}
            </select>
            <button class="del-btn text-slate-500 hover:text-red-400 font-black text-lg leading-none px-1 flex-shrink-0">×</button>
        `;
        const inputs = row.querySelectorAll('input');
        const sizeIn = row.querySelector('select');
        const radio  = row.querySelector('input[type="radio"]');
        radio.addEventListener('change', () => { state.activePlayerIndex = idx; refreshRosters(); });
        inputs[1].addEventListener('input', e => { roster.players[idx].name   = e.target.value; scheduleRoster(); });
        inputs[2].addEventListener('input', e => { roster.players[idx].number = e.target.value; scheduleRoster(); });
        sizeIn.addEventListener('change', e => { roster.players[idx].size = e.target.value; });
        row.querySelector('.del-btn').addEventListener('click', () => { roster.players.splice(idx,1); renderRosterUI(); scheduleRoster(); });
        list.appendChild(row);
    });
}

function scheduleRoster() { clearTimeout(rosterDebounce); rosterDebounce = setTimeout(refreshRosters, 420); }

function refreshRosters() {
    const br = state.design.back.roster;
    const activeBackPlayer = br.players[state.activePlayerIndex] || { name:'PLAYER', number:'??' };
    fabricBack.renderRoster(activeBackPlayer, br.font, br.color);
    if (fabricFront.nameText || fabricFront.numberText) {
        fabricFront.canvas.remove(fabricFront.nameText, fabricFront.numberText);
        fabricFront.nameText = null; fabricFront.numberText = null;
        fabricFront.trigger();
    }
}

document.getElementById('btn-add-player').addEventListener('click', () => {
    getEditingRoster().players.push({ name:'', number:'', size:'m' });
    renderRosterUI(); scheduleRoster();
});
document.getElementById('roster-font').addEventListener('change',  e => { getEditingRoster().font  = e.target.value; refreshRosters(); });
document.getElementById('roster-color').addEventListener('input',  e => { getEditingRoster().color = e.target.value; refreshRosters(); });

// ================================================================
// REFRESH ALL
// ================================================================
function refreshAll() {
    const f = state.design.front, b = state.design.back;
    const collarStyle = state.config.jerseyType;
    fabricFront.renderBaseLayer(f.zones.body.color, f.zones.sleeves.color, f.zones.collar.color, f.zones.body.pattern, collarStyle);
    fabricBack.renderBaseLayer(b.zones.body.color,  b.zones.sleeves.color, b.zones.collar.color, b.zones.body.pattern, collarStyle);
    refreshRosters();
}

// ================================================================
// EXPORT & CART
// ================================================================
document.getElementById('btn-export-json').addEventListener('click', () => {
    const payload = {
        config: state.config,
        front:  { zones: state.design.front.zones, roster: state.design.front.roster.players },
        back:   { zones: state.design.back.zones,  roster: state.design.back.roster.players },
        exportedAt: new Date().toISOString()
    };
    const blob = new Blob([JSON.stringify(payload, null, 2)], { type:'application/json' });
    const url  = URL.createObjectURL(blob);
    const a    = Object.assign(document.createElement('a'), { href:url, download:'jersey-design.json' });
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    URL.revokeObjectURL(url);
    showToast('Design exported as JSON ✓','success');
});

document.getElementById('btn-export-img').addEventListener('click', () => {
    const cvs = state.viewMode === 'back'
        ? document.getElementById('fabric-canvas-back')
        : document.getElementById('fabric-canvas-front');
    const url = cvs.toDataURL('image/png');
    const a   = Object.assign(document.createElement('a'), { href:url, download:`jersey-${state.viewMode}-${Date.now()}.png` });
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    showToast(`${state.viewMode==='back'?'Back':'Front'} downloaded ✓`,'success');
});

document.getElementById('btn-cart').addEventListener('click', async () => {
    if (!IS_LOGGED_IN) {
        showToast('Silakan login terlebih dahulu!', 'error');
        setTimeout(() => { window.location.href = LOGIN_URL; }, 1500);
        return;
    }

    const roster = state.design.back.roster.players;
    const sizeCart = document.getElementById('jersey-size-cart').value;

    if (roster.length === 0) {
        showToast('Tambahkan minimal 1 player ke roster!', 'error');
        return;
    }
    if (!sizeCart) {
        showToast('Pilih ukuran jersey terlebih dahulu!', 'error');
        return;
    }

    toggleLoader(true, 'Menyimpan ke keranjang...');

    // ==========================================
    // UPDATED PAYLOAD TO MATCH LARAVEL BACKEND
    // ==========================================
    const payload = {
        size: sizeCart,
        quantity: roster.length, // 1. Added the required quantity field
        
        // 2. Renamed to design_json and stringified the object
        design_json: JSON.stringify({
            config: state.config,
            front_zones: state.design.front.zones,
            back_zones: state.design.back.zones,
            roster_data: roster
        }),

        // 3. Renamed to preview_image (using the front view as the main thumbnail)
        preview_image: fabricFront.canvas.toDataURL({ format: 'png', quality: 0.5 })
    };

    try {
        const response = await fetch(SAVE_DESIGN_URL, { // This now points to /cart/add-design/{id}
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        });

        const result = await response.json();

        if (response.ok) {
            showToast(`✓ Berhasil disimpan ke keranjang!`, 'success');
            setTimeout(() => {
                            window.location.href = result.redirect_url;
                        }, 1000); // 1 second delay so they can see the success toast
        } else {
            console.error('Validation/Server Error:', result);
            showToast(result.message || 'Gagal menyimpan design.', 'error');
        }
    } catch (error) {
        console.error('Connection Error:', error);
        showToast('Terjadi kesalahan koneksi ke server.', 'error');
    } finally {
        toggleLoader(false);
    }
});

document.getElementById('jersey-size').addEventListener('change', e => { state.config.size = e.target.value; });

document.getElementById('btn-bulk-export').addEventListener('click', async () => {
    const roster = state.design.back.roster.players;
    if (roster.length === 0) { showToast('Roster is empty! Tambahkan player dulu.','error'); return; }

    toggleLoader(true, `MENYIAPKAN 1 FRONT & ${roster.length} BACK VIEWS...`);

    const zip = new JSZip();
    const originalIndex = state.activePlayerIndex;
    const getBase64Data = (dataUrl) => dataUrl.split(',')[1];

    await new Promise(resolve => setTimeout(resolve, 300));
    const frontData = fabricFront.canvas.toDataURL('image/png');
    zip.file(`00_Front_Design.png`, getBase64Data(frontData), { base64:true });

    for (let i=0; i<roster.length; i++) {
        state.activePlayerIndex = i;
        refreshRosters();
        toggleLoader(true, `MENGEKSPOR PLAYER ${i+1} DARI ${roster.length}...`);
        await new Promise(resolve => setTimeout(resolve, 300));
        const playerName   = roster[i].name   ? roster[i].name.trim().toUpperCase() : `PLAYER-${i+1}`;
        const playerNumber = roster[i].number || '00';
        const backData = fabricBack.canvas.toDataURL('image/png');
        zip.file(`${playerNumber}_${playerName}_Back.png`, getBase64Data(backData), { base64:true });
    }

    state.activePlayerIndex = originalIndex;
    refreshRosters();
    renderRosterUI();

    toggleLoader(true, 'MENYATUKAN FILE ZIP...');
    zip.generateAsync({ type:"blob" }).then(function(content) {
        const url = URL.createObjectURL(content);
        const a   = Object.assign(document.createElement('a'), { href:url, download:`Team_Roster_Export.zip` });
        document.body.appendChild(a); a.click(); document.body.removeChild(a);
        URL.revokeObjectURL(url);
        toggleLoader(false);
        showToast('Download ZIP selesai! ✓','success');
    });
});

// ================================================================
// DYNAMIC CONFIG HANDLERS
// ================================================================
const COLLAR_OPTIONS_MAP = {
    'o-neck': [
        { id:'crew',         label:'O-Neck' },
        { id:'oneck_combo',  label:'O-Neck Combo' },
        { id:'changi',       label:'Changi' }
    ],
    'v-neck': [
        { id:'vneck_1',        label:'V-Neck 1' },
        { id:'vneck_2',        label:'V-Neck 2' },
        { id:'vneck_3',        label:'V-Neck 3' },
        { id:'vpasung',        label:'V-Pasung' },
        { id:'vpasung_combo',  label:'V-Pasung Combo' },
        { id:'vclassic_combo', label:'V-Classic Combo' },
        { id:'vkerah',         label:'V-Kerah' },
        { id:'wangki',         label:'Wangki' },
        { id:'vclassic',       label:'V-Classic' }
    ]
};

function handleCollarButtonClick(e) {
    const btn = e.currentTarget;
    state.config.jerseyType = btn.getAttribute('data-collar');
    document.querySelectorAll('.collar-btn').forEach(b => {
        b.style.background = '#0f172a';
        b.style.borderColor = 'rgba(255,255,255,0.1)';
        b.style.color = 'white';
        b.classList.remove('active');
    });
    btn.style.background  = 'rgba(163,230,53,0.15)';
    btn.style.borderColor = '#a3e635';
    btn.style.color       = '#a3e635';
    btn.classList.add('active');
    refreshAll();
}

function renderCollarButtons(category) {
    const container = document.getElementById('collar-style-buttons');
    container.innerHTML = '';
    const options = COLLAR_OPTIONS_MAP[category] || COLLAR_OPTIONS_MAP['o-neck'];
    options.forEach((opt, idx) => {
        const btn = document.createElement('button');
        btn.className = 'collar-btn py-2 px-1 text-[10px] sm:text-xs font-bold rounded-lg border transition text-center leading-tight';
        btn.dataset.collar = opt.id;
        btn.textContent = opt.label;
        if (idx === 0) {
            btn.classList.add('active');
            btn.style.background  = 'rgba(163,230,53,0.15)';
            btn.style.borderColor = '#a3e635';
            btn.style.color       = '#a3e635';
            state.config.jerseyType = opt.id;
        } else {
            btn.style.background  = '#0f172a';
            btn.style.borderColor = 'rgba(255,255,255,0.1)';
            btn.style.color       = 'white';
        }
        btn.addEventListener('click', handleCollarButtonClick);
        container.appendChild(btn);
    });
    refreshAll();
}

document.getElementById('jersey-category').addEventListener('change', e => { renderCollarButtons(e.target.value); });

// ================================================================
// INIT
// ================================================================
window.addEventListener('DOMContentLoaded', () => {
    fabricFront = new FabricManager('fabric-canvas-front', 'front');
    fabricBack  = new FabricManager('fabric-canvas-back',  'back');

    rebuildBodySwatches();
    rebuildSleeveSwatches();
    rebuildCollarSwatches();

    switchView('front');
    renderCollarButtons('o-neck');
    refreshAll();
    renderRosterUI();

    showToast('Jersey Customizer siap! 🎽','success');
});
</script>

@endsection