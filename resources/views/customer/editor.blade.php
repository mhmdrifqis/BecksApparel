@extends('layouts.app')

@section('title', 'Jersey Customizer - Becks Apparel')

@section('skip_alpine_cdn', true)

@push('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        .canvas-container { margin: 0 auto !important; }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.05); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #475569; border-radius: 10px; }
        
        @media (max-width: 768px) {
            #jersey-canvas { max-width: 100% !important; height: auto !important; }
            .canvas-container { width: 100% !important; height: auto !important; }
        }

        .floating-toolbar-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4), 0 8px 10px -6px rgba(0, 0, 0, 0.4);
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        @font-face { font-family: 'AC Milan 4th'; src: url('/assets/fonts/AC Milan 4th 23.woff2') format('woff2'); }
        @font-face { font-family: 'Brøndby IF'; src: url('/assets/fonts/Brøndby IF 25-26.woff2') format('woff2'); }
        @font-face { font-family: 'Girondins Bordeaux'; src: url('/assets/fonts/Girondins Bordeaux 25-26_Nero Design.woff2') format('woff2'); }
        @font-face { font-family: 'Iraq 2025'; src: url('/assets/fonts/Iraq 2025_Nero Design.woff2') format('woff2'); }
        @font-face { font-family: 'Osasuna 25-26'; src: url('/assets/fonts/Osasuna 25-26_NeroDesign.woff2') format('woff2'); }
        @font-face { font-family: 'PSG Fourth'; src: url('/assets/fonts/PSG Fourth 25-26_Nero Design.woff2') format('woff2'); }
        @font-face { font-family: 'Palermo FC'; src: url('/assets/fonts/Palermo FC 125 years 25-26_Nero Design.woff2') format('woff2'); }
        @font-face { font-family: 'Portugal WC 2026'; src: url('/assets/fonts/Portugal WC 2026_Nero Design.woff2') format('woff2'); }
        @font-face { font-family: 'SC Freiburg'; src: url('/assets/fonts/SC Freiburg 25-26_Nero Design.woff2') format('woff2'); }
        @font-face { font-family: 'South Africa'; src: url('/assets/fonts/South Africa 25-26_Nero Design.woff2') format('woff2'); }
        @font-face { font-family: 'Spain WC 2026'; src: url('/assets/fonts/Spain WC 2026_Nero Design.woff2') format('woff2'); }
        
        /* Cropper CSS */
        .cropper-container { background-color: #0f172a !important; }
        .cropper-modal { background-color: #0f172a !important; opacity: 0.8 !important; }
        .cropper-view-box { outline: 2px solid #6366f1 !important; outline-color: rgba(99, 102, 241, 0.75) !important; }
        .cropper-face { background-color: transparent !important; }
    </style>
    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
@endpush

@section('content')
<div class="bg-slate-950 text-slate-100 mt-20 h-[calc(100vh-80px)] min-h-[700px] overflow-hidden font-sans flex flex-col w-full relative" x-data="customizer()" x-cloak>

    <!-- LOADING OVERLAY -->
    <div x-show="isLoading" 
         class="fixed inset-0 z-[100] bg-slate-950/80 backdrop-blur-md flex flex-col items-center justify-center transition-all duration-500">
        <div class="relative w-24 h-24">
            <div class="absolute inset-0 border-4 border-indigo-500/20 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-t-indigo-500 rounded-full animate-spin"></div>
        </div>
        <p class="mt-6 text-indigo-400 font-bold tracking-widest text-xs uppercase animate-pulse text-center">Menyiapkan Desain...</p>
    </div>
    
    <div id="app-container" class="flex flex-col md:flex-row h-full w-full overflow-hidden relative">
        
        <!-- SIDEBAR/BOTTOM NAV -->
        <nav class="fixed bottom-0 md:relative w-full md:w-20 bg-slate-900/90 md:bg-slate-900/50 backdrop-blur-xl border-t md:border-t-0 md:border-r border-slate-800 flex flex-row md:flex-col items-center py-2 md:py-6 px-4 md:px-0 gap-2 md:gap-8 z-50 order-3 md:order-1 shrink-0 h-16 md:h-full">
            <div class="hidden md:flex p-3 rounded-xl bg-indigo-600 shadow-lg mb-4 cursor-pointer" @click="location.reload()">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>
            </div>
            
            <div class="flex flex-row md:flex-col flex-1 justify-around md:justify-start gap-2 md:gap-6 w-full overflow-x-auto no-scrollbar">
                <template x-for="menu in menus" :key="menu.id">
                    <button @click="setActiveMenu(menu.id)" :class="activeMenu === menu.id ? 'bg-indigo-500/10 text-indigo-400 border-indigo-500/50' : 'text-slate-400 border-transparent'" class="group flex flex-col items-center gap-1 p-2 rounded-lg border transition-all min-w-[60px]">
                        <div class="p-2 rounded-lg group-hover:bg-slate-800"><span x-html="menu.icon"></span></div>
                        <span class="text-[9px] md:text-[10px] font-medium uppercase" x-text="menu.label"></span>
                    </button>
                </template>
            </div>
        </nav>

        <!-- OPTIONS PANEL -->
        <aside 
            :class="isPanelOpen ? 'md:w-80 h-[45%] md:h-full opacity-100' : 'md:w-0 h-0 md:h-full md:opacity-0 opacity-0'"
            class="relative w-full bg-slate-900 border-t md:border-t-0 md:border-r border-slate-800 flex flex-col z-20 shadow-2xl order-2 md:order-2 transition-all duration-300 overflow-hidden shrink-0 mb-16 md:mb-0"
        >
            <header class="p-4 md:p-6 border-b border-slate-800 bg-slate-900/50 flex items-center justify-between">
                <div>
                    <h2 class="text-base md:text-lg font-semibold capitalize" x-text="activeMenuLabel"></h2>
                    <p class="text-[10px] md:text-sm text-slate-500 mt-1">Konfigurasi Elemen</p>
                </div>
            </header>
            
            <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-8 pb-32">
                <!-- Mockup Selection -->
                <div x-show="activeMenu === 'mockup'" x-transition class="space-y-6">
                    <label class="block text-[10px] font-medium text-slate-400 mb-4 uppercase tracking-widest">Pilih Model Mockup</label>
                    <div class="grid grid-cols-1 gap-4">
                        <template x-for="mockup in availableMockups" :key="mockup.id">
                            <button 
                                @click="setModel(mockup.id)"
                                :class="currentModel === mockup.id ? 'border-indigo-500 bg-indigo-500/5 ring-1 ring-indigo-500' : 'border-slate-800 hover:border-slate-700 bg-slate-950/30'"
                                class="w-full flex items-center gap-4 p-4 rounded-2xl border transition-all text-left group"
                            >
                                <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center group-hover:bg-indigo-500/20 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-slate-100 uppercase tracking-wide" x-text="mockup.label"></h3>
                                    <p class="text-[10px] text-slate-500 mt-1 uppercase" x-text="mockup.id"></p>
                                </div>
                                <div x-show="currentModel === mockup.id" class="ml-auto">
                                    <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Color & Parts -->
                <div x-show="activeMenu === 'color'" x-transition class="space-y-6">
                    <!-- PART SELECTOR -->
                    <div>
                        <label class="block text-[10px] font-medium text-slate-400 mb-3 uppercase tracking-widest">Pilih Bagian Jersey</label>
                        <div class="space-y-1 bg-slate-950/50 rounded-xl border border-slate-800 overflow-hidden">
                            <template x-for="part in parts" :key="'part-'+part.id">
                                <button 
                                    @click="activePart = part.id"
                                    class="w-full flex items-center justify-between p-3 hover:bg-slate-800/50 transition-colors border-b border-slate-800/50 last:border-0"
                                    :class="activePart === part.id ? 'bg-indigo-500/5 border-l-2 border-l-indigo-500' : ''"
                                >
                                    <div class="flex items-center gap-3">
                                        <div class="w-5 h-5 rounded-full border border-white/10 relative overflow-hidden flex-shrink-0">
                                            <template x-if="partColorMode[part.id] === 'gradient' && activeState.partGradientEnabled[part.id]">
                                                <div class="absolute inset-0 rounded-full" :style="`background: linear-gradient(135deg, ${activeState.partGradientColor1[part.id]}, ${activeState.partGradientColor2[part.id]})`"></div>
                                            </template>
                                            <template x-if="partColorMode[part.id] !== 'gradient' || !activeState.partGradientEnabled[part.id]">
                                                <div class="absolute inset-0 rounded-full" :style="`background-color: ${partColors[part.id]}`"></div>
                                            </template>
                                        </div>
                                        <span class="text-xs font-medium" :class="activePart === part.id ? 'text-indigo-300' : 'text-slate-300'" x-text="part.label"></span>
                                    </div>
                                    <span x-show="partColorMode[part.id] === 'gradient'" class="text-[8px] bg-indigo-600/20 text-indigo-400 px-1.5 py-0.5 rounded uppercase font-bold tracking-wider">Gradasi</span>
                                </button>
                            </template>
                        </div>
                    </div>



                    <!-- WARNA SOLID DEFAULT -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="text-slate-400"><circle cx="12" cy="12" r="10"/></svg>
                                <label class="text-xs font-semibold text-slate-200">Warna solid</label>
                            </div>
                            <button @click="showAllSolidColors = !showAllSolidColors" class="text-[10px] text-indigo-400 hover:text-indigo-300 transition-colors font-medium" x-text="showAllSolidColors ? 'Tutup' : 'Lihat semua'"></button>
                        </div>
                        <!-- 2 rows = 14 colors (7 cols), expands to all -->
                        <div class="grid grid-cols-7 gap-1.5">
                            <template x-for="(color, index) in solidColors" :key="'solid-'+color">
                                <button 
                                    x-show="showAllSolidColors || index < 14"
                                    @click="updatePartColor(activePart, color)" 
                                    :style="`background-color: ${color}`" 
                                    :class="partColors[activePart] === color && partColorMode[activePart] === 'solid' ? 'ring-2 ring-indigo-400 ring-offset-2 ring-offset-slate-900 scale-110' : 'opacity-90 hover:opacity-100 hover:scale-105'" 
                                    class="w-7 h-7 rounded-full border border-white/10 transition-all"
                                ></button>
                            </template>
                            <!-- Custom color picker always visible -->
                            <button class="w-7 h-7 rounded-full border-2 border-dashed border-slate-600 hover:border-indigo-500 bg-slate-800 flex items-center justify-center relative transition-all hover:scale-105">
                                <span class="text-slate-400 text-sm leading-none pointer-events-none">+</span>
                                <input type="color" x-ref="partPicker" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full rounded-full" @input="updatePartColor(activePart, $event.target.value)">
                            </button>
                        </div>
                    </div>

                    <!-- WARNA GRADASI DEFAULT -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect x="2" y="2" width="20" height="20" rx="4"/></svg>
                                <label class="text-xs font-semibold text-slate-200">Warna gradasi</label>
                            </div>
                            <button @click="showAllGradients = !showAllGradients" class="text-[10px] text-indigo-400 hover:text-indigo-300 transition-colors font-medium" x-text="showAllGradients ? 'Tutup' : 'Lihat semua'"></button>
                        </div>
                        <!-- 2 rows = 14 presets (7 cols), expands to all — same size as solid circles -->
                        <div class="grid grid-cols-7 gap-1.5">
                            <template x-for="(gp, index) in gradientPresets" :key="gp.id">
                                <button 
                                    x-show="showAllGradients || index < 14"
                                    @click="applyGradientPreset(activePart, gp)"
                                    :class="partActiveGradientPreset[activePart] === gp.id ? 'ring-2 ring-indigo-400 ring-offset-2 ring-offset-slate-900 scale-110' : 'opacity-90 hover:opacity-100 hover:scale-105'"
                                    class="w-7 h-7 rounded-full border border-white/10 transition-all"
                                    :style="`background: ${gp.type === 'radial' ? 'radial-gradient(circle, ' + gp.color1 + ', ' + gp.color2 + ')' : 'linear-gradient(' + gp.angle + 'deg, ' + gp.color1 + ', ' + gp.color2 + ')'}`"
                                ></button>
                            </template>
                        </div>
                    </div>

                    <!-- GRADIENT ADJUST CONTROLS — tampil hanya jika mode gradient aktif -->
                    <div x-show="partColorMode[activePart] === 'gradient'" x-transition class="pt-4 border-t border-slate-800 space-y-5">
                        <label class="block text-[10px] font-medium text-slate-400 uppercase tracking-widest">Atur Gradasi</label>

                        <!-- Type -->
                        <div class="flex gap-2 p-1 bg-slate-950 rounded-lg border border-slate-800">
                            <button @click="updatePartGradient(activePart, 'partGradientType', 'linear')" :class="activeState.partGradientType[activePart] === 'linear' ? 'bg-indigo-600 text-white' : 'text-slate-400'" class="flex-1 py-1.5 text-[10px] font-bold rounded-md transition-all uppercase">Linear</button>
                            <button @click="updatePartGradient(activePart, 'partGradientType', 'radial')" :class="activeState.partGradientType[activePart] === 'radial' ? 'bg-indigo-600 text-white' : 'text-slate-400'" class="flex-1 py-1.5 text-[10px] font-bold rounded-md transition-all uppercase">Radial</button>
                        </div>

                        <!-- Colors -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[9px] text-slate-500 mb-2 uppercase">Warna 1</label>
                                <label class="flex items-center gap-2 cursor-pointer group relative">
                                    <div class="w-9 h-9 rounded-lg border-2 border-white/10 group-hover:border-indigo-500 transition-colors flex-shrink-0" :style="`background-color: ${activeState.partGradientColor1[activePart]}`"></div>
                                    <span class="text-[10px] text-slate-400 font-mono" x-text="activeState.partGradientColor1[activePart]"></span>
                                    <input type="color" :value="activeState.partGradientColor1[activePart]" @input="updatePartGradient(activePart, 'partGradientColor1', $event.target.value)" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer">
                                </label>
                            </div>
                            <div>
                                <label class="block text-[9px] text-slate-500 mb-2 uppercase">Warna 2</label>
                                <label class="flex items-center gap-2 cursor-pointer group relative">
                                    <div class="w-9 h-9 rounded-lg border-2 border-white/10 group-hover:border-indigo-500 transition-colors flex-shrink-0" :style="`background-color: ${activeState.partGradientColor2[activePart]}`"></div>
                                    <span class="text-[10px] text-slate-400 font-mono" x-text="activeState.partGradientColor2[activePart]"></span>
                                    <input type="color" :value="activeState.partGradientColor2[activePart]" @input="updatePartGradient(activePart, 'partGradientColor2', $event.target.value)" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer">
                                </label>
                            </div>
                        </div>

                        <!-- Preview strip -->
                        <div class="h-6 rounded-full border border-white/10 transition-all" 
                             :style="`background: ${activeState.partGradientType[activePart] === 'radial' ? 'radial-gradient(circle, ' + activeState.partGradientColor1[activePart] + ', ' + activeState.partGradientColor2[activePart] + ')' : 'linear-gradient(' + activeState.partGradientAngle[activePart] + 'deg, ' + activeState.partGradientColor1[activePart] + ', ' + activeState.partGradientColor2[activePart] + ')'}`">
                        </div>

                        <!-- Angle (only for linear) -->
                        <div x-show="activeState.partGradientType[activePart] === 'linear'" x-transition>
                            <label class="flex justify-between text-[10px] font-medium text-slate-400 mb-2 uppercase tracking-widest">
                                <span>Sudut Gradasi</span>
                                <span class="text-indigo-400" x-text="activeState.partGradientAngle[activePart] + '°'"></span>
                            </label>
                            <input type="range" min="0" max="360" :value="activeState.partGradientAngle[activePart]" @input="updatePartGradient(activePart, 'partGradientAngle', $event.target.value)" class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                        </div>
                    </div>
                </div>

                <!-- Pattern -->
                <div x-show="activeMenu === 'pattern'" x-transition class="space-y-6">
                    <!-- PART SELECTOR FOR PATTERN (New) -->
                    <div>
                        <label class="block text-[10px] font-medium text-slate-400 mb-4 uppercase tracking-widest">Atur Motif Per Bagian</label>
                        <div class="space-y-1 bg-slate-950/50 rounded-xl border border-slate-800 overflow-hidden mb-6">
                            <template x-for="part in parts.filter(p => !['belt'].includes(p.id))" :key="'pnode-'+part.id">
                                <div 
                                    class="w-full flex items-center justify-between p-3 hover:bg-slate-800/50 transition-colors border-b border-slate-800/50 last:border-0 cursor-pointer"
                                    :class="activePatternPart === part.id ? 'bg-indigo-500/5 border-l-2 border-l-indigo-500' : ''"
                                    @click="activePatternPart = part.id"
                                >
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full" :class="partPatterns[part.id] ? 'bg-indigo-500' : 'bg-slate-700'"></div>
                                        <span class="text-xs font-medium" :class="activePatternPart === part.id ? 'text-indigo-300' : 'text-slate-300'" x-text="part.label"></span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <button 
                                            @click.stop="togglePartPattern(part.id)"
                                            class="relative inline-flex h-4 w-7 shrink-0 items-center rounded-full transition-colors focus:outline-none"
                                            :class="partPatterns[part.id] ? 'bg-indigo-600' : 'bg-slate-700'"
                                        >
                                            <span 
                                                class="inline-block h-2.5 w-2.5 transform rounded-full bg-white transition-transform"
                                                :class="partPatterns[part.id] ? 'translate-x-4' : 'translate-x-0.5'"
                                            ></span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- PATTERN GRID (Like Screenshot 1) -->
                    <div>
                        <label class="block text-[10px] font-medium text-slate-400 mb-3 uppercase tracking-widest">Pilih Motif untuk <span class="text-indigo-400" x-text="parts.find(p => p.id === activePatternPart)?.label"></span></label>
                        <div class="grid grid-cols-2 gap-3 mb-6 max-h-52 md:max-h-72 overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="p in patterns" :key="p.id">
                                <button 
                                    @click="partActivePatterns[activePatternPart] = p.id; partPatterns[activePatternPart] = true; updatePattern()" 
                                    class="group relative aspect-[4/3] bg-slate-800 rounded-xl overflow-hidden border-2 transition-all" 
                                    :class="partActivePatterns[activePatternPart] === p.id ? 'border-indigo-500 ring-2 ring-indigo-500/20' : 'border-slate-800'"
                                >
                                    <img :src="p.url" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    <div class="absolute bottom-2 left-2 text-[9px] font-bold text-white uppercase truncate pr-2" x-text="p.name"></div>
                                </button>
                            </template>
                        </div>
                        
                        <!-- Pattern Color — solid palette -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Warna Motif</label>
                                <button @click="showAllPatternColors = !showAllPatternColors" class="text-[10px] text-indigo-400 hover:text-indigo-300 transition-colors font-medium" x-text="showAllPatternColors ? 'Tutup' : 'Lihat semua'"></button>
                            </div>
                            <div class="grid grid-cols-7 gap-1.5 mb-3">
                                <template x-for="(color, index) in solidColors" :key="'pat-'+color">
                                    <button
                                        x-show="showAllPatternColors || index < 14"
                                        @click="updatePatternColor(color)"
                                        :style="`background-color: ${color}`"
                                        :class="patternColor === color ? 'ring-2 ring-indigo-400 ring-offset-2 ring-offset-slate-900 scale-110' : 'opacity-90 hover:opacity-100 hover:scale-105'"
                                        class="w-7 h-7 rounded-full border border-white/10 transition-all"
                                    ></button>
                                </template>
                                <button class="w-7 h-7 rounded-full border-2 border-dashed border-slate-600 hover:border-indigo-500 bg-slate-800 flex items-center justify-center relative transition-all hover:scale-105">
                                    <span class="text-slate-400 text-sm leading-none pointer-events-none">+</span>
                                    <input type="color" x-ref="patternPicker" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full rounded-full" @input="updatePatternColor($event.target.value)">
                                </button>
                            </div>
                            <!-- Gradient preset palette for pattern -->
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Gradasi Motif</label>
                                <button @click="showAllPatternGradients = !showAllPatternGradients" class="text-[10px] text-indigo-400 hover:text-indigo-300 transition-colors font-medium" x-text="showAllPatternGradients ? 'Tutup' : 'Lihat semua'"></button>
                            </div>
                            <div class="grid grid-cols-7 gap-1.5 mb-4">
                                <template x-for="(gp, index) in gradientPresets" :key="'patgp-'+gp.id">
                                    <button
                                        x-show="showAllPatternGradients || index < 14"
                                        @click="updatePatternGradientFromPreset(gp)"
                                        :class="patternActiveGradientPreset === gp.id ? 'ring-2 ring-indigo-400 ring-offset-2 ring-offset-slate-900 scale-110' : 'opacity-90 hover:opacity-100 hover:scale-105'"
                                        class="w-7 h-7 rounded-full border border-white/10 transition-all"
                                        :style="`background: ${gp.type === 'radial' ? 'radial-gradient(circle, ' + gp.color1 + ', ' + gp.color2 + ')' : 'linear-gradient(' + gp.angle + 'deg, ' + gp.color1 + ', ' + gp.color2 + ')'}`"
                                    ></button>
                                </template>
                            </div>
                        </div>

                        <!-- PART PATTERN GRADIENT CONTROLS -->
                        <div x-show="partPatternGradientEnabled[activePatternPart]" x-transition class="pt-4 border-t border-slate-800 space-y-5">
                            <label class="block text-[10px] font-medium text-slate-400 uppercase tracking-widest">Atur Gradasi Motif</label>
                            
                            <div>
                                <!-- Type Selection -->
                                <div class="flex gap-2 p-1 bg-slate-950 rounded-lg border border-slate-800">
                                    <button @click="updatePatternGradient('partPatternGradientType', 'linear')" :class="partPatternGradientType[activePatternPart] === 'linear' ? 'bg-indigo-600 text-white' : 'text-slate-400'" class="flex-1 py-1.5 text-[10px] font-bold rounded-md transition-all uppercase">Linear</button>
                                    <button @click="updatePatternGradient('partPatternGradientType', 'radial')" :class="partPatternGradientType[activePatternPart] === 'radial' ? 'bg-indigo-600 text-white' : 'text-slate-400'" class="flex-1 py-1.5 text-[10px] font-bold rounded-md transition-all uppercase">Radial</button>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[9px] text-slate-500 mb-2 uppercase">Warna 1</label>
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg border border-white/10" :style="`background-color: ${partPatternGradientColor1[activePatternPart]}`"></div>
                                            <input type="color" :value="partPatternGradientColor1[activePatternPart]" @input="updatePatternGradient('partPatternGradientColor1', $event.target.value)" class="w-full h-8 opacity-0 absolute cursor-pointer">
                                            <span class="text-[10px] text-slate-400" x-text="partPatternGradientColor1[activePatternPart]"></span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[9px] text-slate-500 mb-2 uppercase">Warna 2</label>
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg border border-white/10" :style="`background-color: ${partPatternGradientColor2[activePatternPart]}`"></div>
                                            <input type="color" :value="partPatternGradientColor2[activePatternPart]" @input="updatePatternGradient('partPatternGradientColor2', $event.target.value)" class="w-full h-8 opacity-0 absolute cursor-pointer">
                                            <span class="text-[10px] text-slate-400" x-text="partPatternGradientColor2[activePatternPart]"></span>
                                        </div>
                                    </div>
                                </div>

                                <div x-show="partPatternGradientType[activePatternPart] === 'linear'">
                                    <label class="flex justify-between text-[10px] font-medium text-slate-400 mb-3 uppercase tracking-widest">
                                        <span>Sudut Gradasi</span>
                                        <span class="text-indigo-400" x-text="partPatternGradientAngle[activePatternPart] + '°'"></span>
                                    </label>
                                    <input type="range" min="0" max="360" :value="partPatternGradientAngle[activePatternPart]" @input="updatePatternGradient('partPatternGradientAngle', $event.target.value)" class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SCALE & ANGLE & FLIP -->
                    <div class="space-y-6 pt-4 border-t border-slate-800">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <label class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Scale: <span class="text-indigo-400" x-text="Number(partPatternScales[activePatternPart] || 0.3).toFixed(1)"></span></label>
                                    <button @click="resetPatternProperty('scale')" class="p-1 hover:text-indigo-400 text-slate-500 transition-colors" title="Reset Scale">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                                    </button>
                                </div>
                                <input type="range" min="0.3" max="8" step="0.3" x-model.number="partPatternScales[activePatternPart]" @input="updatePatternScale($event.target.value)" class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <label class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Angle: <span class="text-indigo-400" x-text="partPatternAngles[activePatternPart]"></span>°</label>
                                    <button @click="resetPatternProperty('angle')" class="p-1 hover:text-indigo-400 text-slate-500 transition-colors" title="Reset Angle">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                                    </button>
                                </div>
                                <input type="range" min="0" max="360" step="1" x-model="partPatternAngles[activePatternPart]" @input="updatePatternAngle($event.target.value)" class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <label class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Posisi X: <span class="text-indigo-400" x-text="partPatternX[activePatternPart]"></span></label>
                                    <button @click="resetPatternProperty('X')" class="p-1 hover:text-indigo-400 text-slate-500 transition-colors" title="Reset Posisi X">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                                    </button>
                                </div>
                                <input type="range" min="-300" max="900" step="1" x-model="partPatternX[activePatternPart]" @input="updatePatternPosition('X', $event.target.value)" class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <label class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Posisi Y: <span class="text-indigo-400" x-text="partPatternY[activePatternPart]"></span></label>
                                    <button @click="resetPatternProperty('Y')" class="p-1 hover:text-indigo-400 text-slate-500 transition-colors" title="Reset Posisi Y">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                                    </button>
                                </div>
                                <input type="range" min="-300" max="900" step="1" x-model="partPatternY[activePatternPart]" @input="updatePatternPosition('Y', $event.target.value)" class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button 
                                @click="updatePatternFlip('X')"
                                :class="partPatternFlipX[activePatternPart] ? 'bg-indigo-600 border-indigo-500' : 'bg-slate-800 border-slate-700'"
                                class="flex-1 py-2 rounded-xl border flex items-center justify-center gap-2 text-[10px] font-bold uppercase transition-all"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18"/><path d="m15 15 3-3-3-3"/><path d="m9 9-3 3 3 3"/></svg>
                                Flip H
                            </button>
                            <button 
                                @click="updatePatternFlip('Y')"
                                :class="partPatternFlipY[activePatternPart] ? 'bg-indigo-600 border-indigo-500' : 'bg-slate-800 border-slate-700'"
                                class="flex-1 py-2 rounded-xl border flex items-center justify-center gap-2 text-[10px] font-bold uppercase transition-all"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="m9 15 3 3 3-3"/><path d="m15 9-3-3-3 3"/></svg>
                                Flip V
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Logo -->
                <div x-show="activeMenu === 'logo'" x-transition class="space-y-6">
                    <div @click="triggerLogoUpload()" class="border-2 border-dashed border-slate-800 rounded-2xl p-6 flex flex-col items-center justify-center text-center cursor-pointer hover:border-indigo-500/50 transition-colors bg-slate-950/30 group">
                        <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center mb-3 group-hover:bg-indigo-500/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-400"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        </div>
                        <span class="text-xs font-bold text-slate-200 uppercase tracking-wider">Upload Logo / Foto</span>
                        <p class="text-[10px] text-slate-500 mt-1 uppercase">Unggah logo Anda dalam format JPG atau PNG (latar belakang transparan disarankan).</p>
                    </div>
                </div>

                <!-- Unified Text Panel -->
                <div x-show="activeMenu === 'text'" x-transition class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-medium text-slate-400 mb-3 uppercase tracking-widest">Input Teks</label>
                        <div class="flex gap-2">
                            <input type="text" x-model="textInput" @input="updateTextProperty('textInput', $event.target.value)" class="flex-1 bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-slate-100 text-sm focus:border-indigo-500 focus:outline-none" placeholder="Ketik teks...">
                            <button @click="addText()" class="bg-indigo-600 hover:bg-indigo-500 text-white p-3 rounded-xl transition-all shadow-lg shadow-indigo-600/20">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Fonts -->
                    <div>
                        <label class="block text-[10px] font-medium text-slate-400 mb-3 uppercase tracking-widest">Pilihan Font</label>
                        <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto pr-1 no-scrollbar">
                            <template x-for="f in availableFonts" :key="f.id">
                                <button 
                                    @click="updateFont('activeFont', f.id)"
                                    :class="activeFont === f.id ? 'border-indigo-500 bg-indigo-500/10' : 'border-slate-800 hover:border-slate-700 bg-slate-950/30'"
                                    class="p-2 border rounded-lg transition-all text-center group"
                                >
                                    <div class="text-sm text-slate-100 truncate" :style="`font-family: '${f.id}'`" x-text="'Abc 123'"></div>
                                    <div class="text-[8px] text-slate-500 mt-1 uppercase" x-text="f.name"></div>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Colors -->
                    <div>
                        <!-- Solid palette -->
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Warna Teks</label>
                            <button @click="showAllTextColors = !showAllTextColors" class="text-[10px] text-indigo-400 hover:text-indigo-300 transition-colors font-medium" x-text="showAllTextColors ? 'Tutup' : 'Lihat semua'"></button>
                        </div>
                        <div class="grid grid-cols-7 gap-1.5 mb-3">
                            <template x-for="(color, index) in solidColors" :key="'txt-'+color">
                                <button
                                    x-show="showAllTextColors || index < 14"
                                    @click="updateTextProperty('activeColor', color)"
                                    :style="`background-color: ${color}`"
                                    :class="activeColor === color ? 'ring-2 ring-indigo-400 ring-offset-2 ring-offset-slate-900 scale-110' : 'opacity-90 hover:opacity-100 hover:scale-105'"
                                    class="w-7 h-7 rounded-full border border-white/10 transition-all"
                                ></button>
                            </template>
                            <button class="w-7 h-7 rounded-full border-2 border-dashed border-slate-600 hover:border-indigo-500 bg-slate-800 flex items-center justify-center relative transition-all hover:scale-105">
                                <span class="text-slate-400 text-sm leading-none pointer-events-none">+</span>
                                <input type="color" x-ref="textPicker" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full rounded-full" @input="updateTextProperty('activeColor', $event.target.value)">
                            </button>
                        </div>
                        <!-- Gradient preset palette for text -->
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Gradasi Teks</label>
                            <button @click="showAllTextGradients = !showAllTextGradients" class="text-[10px] text-indigo-400 hover:text-indigo-300 transition-colors font-medium" x-text="showAllTextGradients ? 'Tutup' : 'Lihat semua'"></button>
                        </div>
                        <div class="grid grid-cols-7 gap-1.5">
                            <template x-for="(gp, index) in gradientPresets" :key="'txtgp-'+gp.id">
                                <button
                                    x-show="showAllTextGradients || index < 14"
                                    @click="applyTextGradientPreset(gp)"
                                    :class="textActiveGradientPreset === gp.id ? 'ring-2 ring-indigo-400 ring-offset-2 ring-offset-slate-900 scale-110' : 'opacity-90 hover:opacity-100 hover:scale-105'"
                                    class="w-7 h-7 rounded-full border border-white/10 transition-all"
                                    :style="`background: ${gp.type === 'radial' ? 'radial-gradient(circle, ' + gp.color1 + ', ' + gp.color2 + ')' : 'linear-gradient(' + gp.angle + 'deg, ' + gp.color1 + ', ' + gp.color2 + ')'}`"
                                ></button>
                            </template>
                        </div>
                    </div>

                    <!-- TEXT GRADIENT CONTROLS -->
                    <div x-show="textGradientEnabled" x-transition class="pt-4 border-t border-slate-800 space-y-5">
                        <label class="block text-[10px] font-medium text-slate-400 uppercase tracking-widest">Atur Gradasi Teks</label>

                        <div>
                            <!-- Type Selection -->
                            <div class="flex gap-2 p-1 bg-slate-950 rounded-lg border border-slate-800">
                                <button @click="updateTextProperty('textGradientType', 'linear')" :class="textGradientType === 'linear' ? 'bg-indigo-600 text-white' : 'text-slate-400'" class="flex-1 py-1.5 text-[10px] font-bold rounded-md transition-all uppercase">Linear</button>
                                <button @click="updateTextProperty('textGradientType', 'radial')" :class="textGradientType === 'radial' ? 'bg-indigo-600 text-white' : 'text-slate-400'" class="flex-1 py-1.5 text-[10px] font-bold rounded-md transition-all uppercase">Radial</button>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[9px] text-slate-500 mb-2 uppercase">Warna 1</label>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg border border-white/10" :style="`background-color: ${textGradientColor1}`"></div>
                                        <input type="color" x-model="textGradientColor1" @input="updateTextProperty('textGradientColor1', $event.target.value)" class="w-full h-8 opacity-0 absolute cursor-pointer">
                                        <span class="text-[10px] text-slate-400" x-text="textGradientColor1"></span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[9px] text-slate-500 mb-2 uppercase">Warna 2</label>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg border border-white/10" :style="`background-color: ${textGradientColor2}`"></div>
                                        <input type="color" x-model="textGradientColor2" @input="updateTextProperty('textGradientColor2', $event.target.value)" class="w-full h-8 opacity-0 absolute cursor-pointer">
                                        <span class="text-[10px] text-slate-400" x-text="textGradientColor2"></span>
                                    </div>
                                </div>
                            </div>

                            <div x-show="textGradientType === 'linear'">
                                <label class="flex justify-between text-[10px] font-medium text-slate-400 mb-3 uppercase tracking-widest">
                                    <span>Sudut Gradasi</span>
                                    <span class="text-indigo-400" x-text="textGradientAngle + '°'"></span>
                                </label>
                                <input type="range" min="0" max="360" x-model="textGradientAngle" @input="updateTextProperty('textGradientAngle', $event.target.value)" class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Advanced Typography -->
                    <div class="space-y-5 pt-4 border-t border-slate-800">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <label class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Ukuran: <span class="text-indigo-400" x-text="textFontSize"></span>px</label>
                            </div>
                            <input type="range" min="10" max="250" step="1" x-model.number="textFontSize" @input="updateTextProperty('textFontSize', $event.target.value)" class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <label class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Jarak Huruf: <span class="text-indigo-400" x-text="textCharSpacing"></span></label>
                            </div>
                            <input type="range" min="-100" max="1000" step="10" x-model.number="textCharSpacing" @input="updateTextProperty('textCharSpacing', $event.target.value)" class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <label class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Lengkungan: <span class="text-indigo-400" x-text="textArc"></span></label>
                            </div>
                            <input type="range" min="-300" max="300" step="1" x-model.number="textArc" @input="updateTextProperty('textArc', $event.target.value)" class="w-full h-1.5 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-indigo-500">
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN STAGE -->
        <main class="flex-1 bg-slate-100 relative flex flex-col items-center justify-center p-4 min-h-[400px] order-1 md:order-3 mb-16 md:mb-0">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10 pointer-events-none"></div>

            <div class="absolute top-6 left-1/2 -translate-x-1/2 z-40 flex items-center gap-2">
                <div class="bg-white/80 backdrop-blur-md p-1 rounded-2xl border border-slate-200 shadow-xl flex gap-1">
                    <template x-for="v in [
                        {id: 'front', label: 'Depan'},
                        {id: 'back', label: 'Belakang'},
                        {id: 'pants', label: 'Celana'}
                    ]" :key="v.id">
                        <button 
                            @click="setView(v.id)"
                            :class="currentView === v.id ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-slate-100'"
                            class="px-5 py-2 rounded-xl text-xs font-bold transition-all uppercase tracking-wider"
                            x-text="v.label"
                        ></button>
                    </template>
                </div>

                <!-- COPY DESIGN BUTTON -->
                <button 
                    x-show="currentView === 'back' || currentView === 'pants'" x-cloak
                    @click="confirmCopyFromFront()"
                    class="bg-indigo-600/90 text-white p-2 rounded-xl text-xs font-bold shadow-xl border border-white/10 hover:bg-indigo-500 transition-all flex items-center gap-2 h-full"
                    title="Salin pola & warna dari Depan"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                    <span class="hidden md:inline">Salin dari Depan</span>
                </button>
            </div>
            
            <!-- HISTORY, ZOOM & SAVE CONTROLS (Vertical Stack) -->
            <div class="absolute bottom-20 md:bottom-6 right-6 z-40 flex flex-col gap-2 items-end">
                <!-- Save -->
                <button class="bg-indigo-600 hover:bg-indigo-500 text-white w-12 h-12 rounded-2xl shadow-2xl flex items-center justify-center transition-all hover:scale-105 active:scale-95 border border-white/10 group" title="Simpan Desain">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:rotate-12 transition-transform"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                </button>

                <!-- Undo -->
                <button @click="undo()" :disabled="undoStack.length <= 1" class="w-12 h-12 bg-slate-800/90 backdrop-blur-md text-slate-100 rounded-2xl flex items-center justify-center hover:bg-indigo-600 disabled:opacity-30 disabled:cursor-not-allowed transition-all shadow-xl border border-white/5" title="Undo (Ctrl+Z)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7v6h6"/><path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"/></svg>
                </button>

                <!-- Redo -->
                <button @click="redo()" :disabled="redoStack.length === 0" class="w-12 h-12 bg-slate-800/90 backdrop-blur-md text-slate-100 rounded-2xl flex items-center justify-center hover:bg-indigo-600 disabled:opacity-30 disabled:cursor-not-allowed transition-all shadow-xl border border-white/5" title="Redo (Ctrl+Shift+Z)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 7v6h-6"/><path d="M3 17a9 9 0 0 1 9-9 9 9 0 0 1 6 2.3L21 13"/></svg>
                </button>

                <!-- Zoom In -->
                <button @click="zoom(0.2)" class="w-12 h-12 bg-slate-800/90 backdrop-blur-md text-white rounded-2xl flex items-center justify-center hover:bg-indigo-600 transition-colors shadow-xl border border-white/5 text-xl font-bold" title="Zoom In">+</button>
                
                <!-- Zoom Out -->
                <button @click="zoom(-0.2)" class="w-12 h-12 bg-slate-800/90 backdrop-blur-md text-white rounded-2xl flex items-center justify-center hover:bg-indigo-600 transition-colors shadow-xl border border-white/5 text-xl font-bold" title="Zoom Out">-</button>
                
                <!-- Reset Zoom -->
                <button @click="resetZoom()" class="w-12 h-12 bg-rose-600/90 backdrop-blur-md text-white rounded-2xl flex items-center justify-center hover:bg-rose-500 transition-colors shadow-xl border border-white/5" title="Reset Zoom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                </button>
            </div>

            <div class="relative bg-white/50 rounded-[1.5rem] md:rounded-[2.5rem] p-4 md:p-12 backdrop-blur-md border border-slate-300 shadow-2xl w-full max-w-[600px] aspect-square flex items-center justify-center transition-all">
                
                <!-- FLOATING CONTEXT TOOLBAR -->
                <div 
                    x-show="showToolbar" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    class="absolute z-[60] bg-slate-900/90 backdrop-blur-xl border border-slate-700 rounded-full flex items-center gap-1 p-1.5 floating-toolbar-shadow pointer-events-auto"
                    :style="`top: ${toolbarPos.top}px; left: ${toolbarPos.left}px; transform: translateX(-50%);`"
                    @mousedown.stop
                >
                    <button @click="duplicateSelected()" class="p-2 text-slate-400 hover:text-white hover:bg-white/5 rounded-full transition-colors group relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                        <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-[8px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Salin</span>
                    </button>
                    
                    <div class="w-[1px] h-4 bg-slate-700 mx-1"></div>

                    <button @click="flipObject('X')" class="p-2 text-slate-400 hover:text-white hover:bg-white/5 rounded-full transition-colors group relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18"/><path d="m15 15 3-3-3-3"/><path d="m9 9-3 3 3 3"/></svg>
                        <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-[8px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Flip H</span>
                    </button>

                    <button @click="flipObject('Y')" class="p-2 text-slate-400 hover:text-white hover:bg-white/5 rounded-full transition-colors group relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="m9 15 3 3 3-3"/><path d="m15 9-3-3-3 3"/></svg>
                        <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-[8px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Flip V</span>
                    </button>
                    
                    <div class="w-[1px] h-4 bg-slate-700 mx-1"></div>
                    
                    <button @click="deleteSelected()" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-400/10 rounded-full transition-colors group relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                        <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-[8px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Hapus</span>
                    </button>

                    <!-- Cropper button temporarily hidden per user request -->
                    <!--
                    <div x-show="canvas?.getActiveObject() && (canvas?.getActiveObject()?.type === 'image' || canvas?.getActiveObject()?._element)" class="contents">
                        <div class="w-[1px] h-4 bg-slate-700 mx-1"></div>
                        <button @click="openCropper()" class="p-2 text-indigo-400 hover:text-white hover:bg-indigo-500 rounded-full transition-all group relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 10V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2h-5"/><polyline points="14 3 14 8 20 8"/><path d="M3 14.28a5 5 0 0 1 5.42-3.72c2.47.3 4.58 2.21 4.58 4.72 0 2.5-1.5 4-3.5 4.5"/><path d="M3 14.28C3 17 5 19 8 19s5-2 5-4.72c0-2.5-2.1-4.42-4.58-4.72a5 5 0 0 0-5.42 3.72z"/></svg>
                            <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-[8px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Pangkas</span>
                        </button>
                    </div>
                    -->
                </div>

                <div class="w-full h-full flex items-center justify-center overflow-hidden rounded-xl">
                    <canvas id="jersey-canvas" width="600" height="600" class="rounded-xl"></canvas>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL CROPPER -->
    <div x-show="showCropper" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-slate-950/90 backdrop-blur-lg">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
            <div class="p-4 border-b border-slate-800 flex justify-between items-center">
                <h3 class="font-bold text-slate-100">Pangkas Gambar</h3>
                <button @click="cancelCrop()" class="p-2 text-slate-400 hover:text-white"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <div class="flex-1 bg-slate-950 relative overflow-hidden flex items-center justify-center min-h-[300px]">
                <img id="cropper-image" class="max-w-full max-h-full block">
            </div>
            <div class="p-6 border-t border-slate-800 flex justify-end gap-3 bg-slate-900/50">
                <button @click="cancelCrop()" class="px-6 py-2.5 rounded-xl border border-slate-700 text-slate-300 hover:bg-slate-800 transition-all font-medium">Batal</button>
                <button @click="applyCrop()" class="px-8 py-2.5 rounded-xl bg-indigo-600 text-white hover:bg-indigo-500 shadow-lg shadow-indigo-600/20 transition-all font-bold">Terapkan Pangkasan</button>
            </div>
        </div>
    </div>
    <!-- MODAL KONFIRMASI SALIN DARI DEPAN -->
    <div 
        x-show="showCopyConfirmModal" 
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md"
    >
        <div 
            x-show="showCopyConfirmModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="bg-slate-900 border border-slate-700 rounded-2xl w-full max-w-sm overflow-hidden shadow-2xl"
        >
            <!-- Header -->
            <div class="p-5 border-b border-slate-800 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-500/15 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-400"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                </div>
                <h3 class="font-bold text-slate-100 text-sm">Salin dari Bagian Depan</h3>
            </div>
            <!-- Body -->
            <div class="p-5">
                <p class="text-sm text-slate-300 leading-relaxed">Yakin ingin menyalin setelan <span class="text-indigo-400 font-semibold">Warna dan Motif</span> dari bagian Depan ke bagian ini?</p>
                <p class="text-xs text-slate-500 mt-2">Teks dan Logo pada bagian ini tidak akan terpengaruh atau terhapus.</p>
            </div>
            <!-- Footer -->
            <div class="px-5 pb-5 flex gap-3 justify-end">
                <button 
                    @click="showCopyConfirmModal = false"
                    class="px-5 py-2.5 rounded-xl border border-slate-700 text-slate-300 hover:bg-slate-800 transition-all text-xs font-semibold"
                >
                    Batal
                </button>
                <button 
                    @click="copyDesignFromFront()"
                    class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold shadow-lg shadow-indigo-600/20 transition-all"
                >
                    Ya, Salin Sekarang
                </button>
            </div>
        </div>
    </div>
</div>
@endsection