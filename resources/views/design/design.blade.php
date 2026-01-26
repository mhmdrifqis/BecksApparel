<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jersey Customizer - Beck's Apparel</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 950: '#020617', 900: '#0f172a', 800: '#1e293b' },
                        lime: { 400: '#a3e635', 500: '#84cc16' },
                        'accent-cyan': '#06b6d4',
                        'accent-purple': '#a855f7'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Montserrat', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-15px)' },
                        }
                    },
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        
        .glass-card {
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .text-gradient {
            background: linear-gradient(135deg, #a3e635 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: linear-gradient(135deg, #a3e635 0%, #84cc16 100%);
            color: #020617;
            font-weight: 900;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            box-shadow: 0 0 30px rgba(163, 230, 53, 0.4);
            transform: scale(1.05);
        }

        .btn-secondary {
            background: rgba(163, 230, 53, 0.1);
            border: 2px solid rgba(163, 230, 53, 0.3);
            color: #a3e635;
        }

        .btn-secondary:hover {
            border-color: #a3e635;
            background: rgba(163, 230, 53, 0.2);
        }

        canvas {
            filter: drop-shadow(0 0 20px rgba(163, 230, 53, 0.3));
        }
    </style>
</head>
<body class="bg-navy-950 font-sans antialiased text-white">
    
    <div x-data="jerseyCustomizer()" x-cloak class="min-h-screen flex flex-col">
        
        <!-- HEADER -->
        <div class="border-b border-white/5 sticky top-0 z-50 backdrop-blur">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-lime-400 to-accent-cyan flex items-center justify-center font-black text-navy-950">
                        B
                    </div>
                    <h1 class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-lime-400 to-accent-cyan">
                        JERSEY CUSTOMIZER
                    </h1>
                </div>
                <div class="flex gap-3">
                    <button @click="exportDesign()" class="btn-secondary px-5 py-2.5 rounded-lg text-sm font-bold transition hover:-translate-y-1">
                        <i data-lucide="download" class="w-4 h-4 inline mr-2"></i>Export JSON
                    </button>
                    <button @click="exportPreview()" class="btn-secondary px-5 py-2.5 rounded-lg text-sm font-bold transition hover:-translate-y-1">
                        <i data-lucide="image" class="w-4 h-4 inline mr-2"></i>Download Preview
                    </button>
                    <button @click="addToCart()" class="btn-primary px-5 py-2.5 rounded-lg text-sm font-bold transition hover:-translate-y-1">
                        <i data-lucide="shopping-cart" class="w-4 h-4 inline mr-2"></i>Add to Cart
                    </button>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col lg:flex-row gap-6 p-6 max-w-7xl mx-auto w-full overflow-hidden">
            
            <!-- LEFT SIDEBAR -->
            <div class="w-full lg:w-96 flex-shrink-0 glass-card rounded-2xl flex flex-col overflow-hidden border border-white/10 shadow-2xl">
                <div class="p-6 overflow-y-auto flex-1 space-y-4">
                    
                    <!-- Product Config Section -->
                    <div class="rounded-xl overflow-hidden border border-white/10">
                        <button @click="toggleSection('config')" class="w-full flex justify-between items-center p-4 bg-white/5 hover:bg-white/10 font-bold text-white text-sm transition">
                            <span class="flex items-center gap-2">
                                <i data-lucide="settings" class="w-5 h-5 text-lime-400"></i>
                                Product Config
                            </span>
                            <span x-text="sections.config ? '−' : '+'" class="text-lg text-lime-400"></span>
                        </button>
                        <div x-show="sections.config" x-collapse class="p-4 bg-navy-800/50 border-t border-white/10 space-y-3">
                            <div>
                                <label class="text-xs font-bold text-lime-400 uppercase tracking-wider">Jersey Type</label>
                                <select @change="updateConfig('jerseyType', $el.value)" class="w-full mt-2 p-3 bg-navy-900 border border-white/10 rounded-lg text-white text-sm focus:border-lime-400 focus:outline-none transition">
                                    <option value="vneck">V-Neck Sport</option>
                                    <option value="crew">Crew Neck</option>
                                    <option value="polo">Polo Shirt</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-lime-400 uppercase tracking-wider">Base Size</label>
                                <select @change="updateConfig('size', $el.value)" class="w-full mt-2 p-3 bg-navy-900 border border-white/10 rounded-lg text-white text-sm focus:border-lime-400 focus:outline-none transition">
                                    <option value="s">Small</option>
                                    <option value="m" selected>Medium</option>
                                    <option value="l">Large</option>
                                    <option value="xl">XL</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Colors & Patterns Section -->
                    <div class="rounded-xl overflow-hidden border border-white/10">
                        <button @click="toggleSection('colors')" class="w-full flex justify-between items-center p-4 bg-white/5 hover:bg-white/10 font-bold text-white text-sm transition">
                            <span class="flex items-center gap-2">
                                <i data-lucide="palette" class="w-5 h-5 text-accent-cyan"></i>
                                Colors & Patterns
                            </span>
                            <span x-text="sections.colors ? '−' : '+'" class="text-lg text-accent-cyan"></span>
                        </button>
                        <div x-show="sections.colors" x-collapse class="p-4 bg-navy-800/50 border-t border-white/10 space-y-4">
                            <div>
                                <label class="text-xs font-bold text-accent-cyan uppercase tracking-wider block mb-3">Body Color</label>
                                <div class="grid grid-cols-5 gap-2">
                                    <template x-for="color in colors" :key="color">
                                        <button @click="updateZoneColor('body', color)" 
                                                :style="{ backgroundColor: color }" 
                                                class="w-10 h-10 rounded-lg border-2 shadow-lg hover:scale-110 transition"
                                                :class="{ 'border-white ring-2 ring-lime-400': state.design.zones.body.color === color, 'border-white/20': state.design.zones.body.color !== color }">
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-accent-cyan uppercase tracking-wider block mb-3">Sleeves Color</label>
                                <div class="grid grid-cols-5 gap-2">
                                    <template x-for="color in colors" :key="color">
                                        <button @click="updateZoneColor('sleeves', color)" 
                                                :style="{ backgroundColor: color }" 
                                                class="w-10 h-10 rounded-lg border-2 shadow-lg hover:scale-110 transition"
                                                :class="{ 'border-white ring-2 ring-accent-cyan': state.design.zones.sleeves.color === color, 'border-white/20': state.design.zones.sleeves.color !== color }">
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-accent-cyan uppercase tracking-wider block mb-2">Pattern Style</label>
                                <select @change="updatePattern($el.value)" class="w-full p-3 bg-navy-900 border border-white/10 rounded-lg text-white text-sm focus:border-accent-cyan focus:outline-none transition">
                                    <option value="solid">Solid / Polos</option>
                                    <option value="stripe">Vertical Stripes</option>
                                    <option value="checkered">Checkered / Kotak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Logos Section -->
                    <div class="rounded-xl overflow-hidden border border-white/10">
                        <button @click="toggleSection('logos')" class="w-full flex justify-between items-center p-4 bg-white/5 hover:bg-white/10 font-bold text-white text-sm transition">
                            <span class="flex items-center gap-2">
                                <i data-lucide="image-plus" class="w-5 h-5 text-accent-purple"></i>
                                Logos & Graphics
                            </span>
                            <span x-text="sections.logos ? '−' : '+'" class="text-lg text-accent-purple"></span>
                        </button>
                        <div x-show="sections.logos" x-collapse class="p-4 bg-navy-800/50 border-t border-white/10 space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-accent-purple uppercase tracking-wider mb-2">Upload File</label>
                                <input type="file" @change="handleLogoUpload($event)" accept="image/*" class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-accent-purple/20 file:text-accent-purple hover:file:bg-accent-purple/30 transition"/>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-accent-purple uppercase tracking-wider mb-2">Position</label>
                                <select @change="updateLogoZone($el.value)" class="w-full p-3 bg-navy-900 border border-white/10 rounded-lg text-white text-sm focus:border-accent-purple focus:outline-none transition">
                                    <option value="leftChest">Left Chest (Logo Klub)</option>
                                    <option value="rightChest">Right Chest (Apparel)</option>
                                    <option value="centerSponsor">Center (Sponsor)</option>
                                    <option value="sleeves">Sleeves</option>
                                </select>
                            </div>
                            <button @click="placeLogo()" :disabled="!uploadedLogo" class="btn-primary w-full py-3 rounded-lg text-sm font-bold shadow-lg disabled:opacity-50 disabled:cursor-not-allowed transition hover:-translate-y-1">
                                <i data-lucide="check-circle" class="w-4 h-4 inline mr-2"></i>Place on Jersey
                            </button>
                        </div>
                    </div>

                    <!-- Team Roster Section -->
                    <div class="rounded-xl overflow-hidden border border-white/10">
                        <button @click="toggleSection('roster')" class="w-full flex justify-between items-center p-4 bg-white/5 hover:bg-white/10 font-bold text-white text-sm transition">
                            <span class="flex items-center gap-2">
                                <i data-lucide="users" class="w-5 h-5 text-lime-400"></i>
                                Team Roster (Nameset)
                            </span>
                            <span x-text="sections.roster ? '−' : '+'" class="text-lg text-lime-400"></span>
                        </button>
                        <div x-show="sections.roster" x-collapse class="p-4 bg-navy-800/50 border-t border-white/10 space-y-3">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="text-xs font-bold text-lime-400 uppercase tracking-wider">Font</label>
                                    <select @change="updateRosterFont($el.value)" class="w-full mt-2 p-2 bg-navy-900 border border-white/10 rounded text-xs text-white focus:border-lime-400 focus:outline-none transition">
                                        <option value="arial">Arial</option>
                                        <option value="impact">Impact</option>
                                        <option value="courier">Courier</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-lime-400 uppercase tracking-wider">Color</label>
                                    <input type="color" @change="updateRosterFontColor($el.value)" value="#FFFFFF" class="w-full mt-2 h-9 rounded cursor-pointer border border-white/10">
                                </div>
                            </div>
                            
                            <button @click="addRosterRow()" class="w-full py-2.5 bg-lime-400/20 text-lime-400 border border-lime-400/50 rounded-lg text-xs font-bold hover:bg-lime-400/30 transition">
                                <i data-lucide="plus" class="w-4 h-4 inline mr-2"></i>Add Player
                            </button>

                            <div class="max-h-56 overflow-y-auto rounded-lg bg-navy-900/50 border border-white/5 p-2">
                                <template x-for="(player, idx) in (state.viewMode === 'front' ? state.design.front.roster.players : state.design.back.roster.players)" :key="idx">
                                    <div class="flex gap-1.5 mb-2 items-center bg-navy-800/50 p-2 rounded border border-white/10 hover:border-white/20 transition">
                                        <input type="text" :value="player.name" @input="updateRosterPlayer(idx, 'name', $el.value)" placeholder="Name" class="flex-1 min-w-0 p-2 text-xs bg-navy-900 border border-white/10 rounded text-white placeholder-slate-500 focus:border-lime-400 focus:outline-none transition">
                                        <input type="number" :value="player.number" @input="updateRosterPlayer(idx, 'number', $el.value)" placeholder="00" class="w-14 p-2 text-xs bg-navy-900 border border-white/10 rounded text-white placeholder-slate-500 focus:border-lime-400 focus:outline-none transition flex-shrink-0">
                                        <select @change="updateRosterPlayer(idx, 'size', $el.value)" class="w-14 p-2 text-xs bg-navy-900 border border-white/10 rounded text-white focus:border-lime-400 focus:outline-none transition flex-shrink-0">
                                            <option value="s">S</option><option value="m">M</option><option value="l">L</option><option value="xl">XL</option>
                                        </select>
                                        <button @click="removeRosterPlayer(idx)" class="text-accent-purple hover:text-accent-cyan font-bold p-1 transition flex-shrink-0">×</button>
                                    </div>
                                </template>
                                <div x-show="(state.viewMode === 'front' ? state.design.front.roster.players.length : state.design.back.roster.players.length) === 0" class="text-center text-xs text-slate-500 py-4">
                                    No players added yet.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- CENTER CANVAS / VIEWER -->
            <div class="flex-1 glass-card rounded-2xl shadow-2xl border border-white/10 flex flex-col relative overflow-hidden">
                
                <!-- View Mode Switcher -->
                <div class="absolute top-6 left-1/2 transform -translate-x-1/2 glass-card rounded-full shadow-xl p-1.5 flex gap-2 z-20 border border-white/10">
                    <button @click="switchViewMode('front')" :class="state.viewMode === 'front' ? 'bg-lime-400 text-navy-950 shadow-lg' : 'text-slate-400 hover:text-white'" class="px-5 py-2 rounded-full text-xs font-bold transition duration-300">
                        <i data-lucide="eye" class="w-4 h-4 inline mr-1.5"></i>Front 2D
                    </button>
                    <button @click="switchViewMode('back')" :class="state.viewMode === 'back' ? 'bg-accent-cyan text-navy-950 shadow-lg' : 'text-slate-400 hover:text-white'" class="px-5 py-2 rounded-full text-xs font-bold transition duration-300">
                        <i data-lucide="eye-off" class="w-4 h-4 inline mr-1.5"></i>Back 2D
                    </button>
                    <button @click="switchViewMode('3d')" :class="state.viewMode === '3d' ? 'bg-accent-purple text-white shadow-lg' : 'text-slate-400 hover:text-white'" class="px-5 py-2 rounded-full text-xs font-bold transition duration-300 flex items-center gap-1.5">
                        <i data-lucide="box" class="w-4 h-4"></i>3D View
                    </button>
                </div>

                <!-- 2D Canvas -->
                <div x-show="state.viewMode !== '3d'" class="flex-1 flex items-center justify-center p-8 overflow-auto bg-gradient-to-br from-navy-800/30 to-navy-900/30">
                    <!-- Front Canvas -->
                    <div x-show="state.viewMode === 'front'" class="rounded-2xl overflow-hidden border border-lime-400/30">
                        <canvas id="fabric-canvas-front" width="600" height="800" class="border-2 border-lime-400/50"></canvas>
                    </div>

                    <!-- Back Canvas -->
                    <div x-show="state.viewMode === 'back'" class="rounded-2xl overflow-hidden border border-accent-cyan/30">
                        <canvas id="fabric-canvas-back" width="600" height="800" class="border-2 border-accent-cyan/50"></canvas>
                    </div>
                </div>

                <!-- 3D Viewer -->
                <div x-show="state.viewMode === '3d'" id="three-viewer" class="flex-1 w-full h-full bg-gradient-to-br from-navy-800 to-navy-900 cursor-move rounded-xl relative" style="position: relative; display: flex;"></div>

                <!-- Loading Indicator -->
                <div x-show="state.loading" class="absolute inset-0 bg-navy-950/80 backdrop-blur flex items-center justify-center z-50 rounded-2xl">
                    <div class="text-center">
                        <div class="w-12 h-12 border-4 border-lime-400 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                        <p class="text-white font-bold">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script>
        // ============================================================
        // LOGIC APLIKASI
        // ============================================================
        
        // 1. Fabric.js Manager (Untuk Editor 2D)
        class FabricCanvasManager {
            constructor(canvasId) {
                this.canvas = new fabric.Canvas(canvasId, {
                    width: 600,
                    height: 800,
                    backgroundColor: '#ffffff',
                    preserveObjectStacking: true
                });
                this.textureUpdateCallback = null;
                this.logoObjects = []; // Store logos separately
                this.rosterObjects = []; // Store roster text separately
            }

            // Render Pola Dasar Baju (Front/Back)
            renderBaseLayer(bodyColor, sleeveColor, patternType) {
                // Save logos and roster before clearing
                const savedLogos = this.logoObjects;
                const savedRoster = this.rosterObjects;
                
                this.canvas.clear();
                this.logoObjects = [];
                this.rosterObjects = [];
                
                this.canvas.setBackgroundColor('#ffffff', this.canvas.renderAll.bind(this.canvas));

                // A. Buat Area Body (Badan)
                const body = new fabric.Rect({
                    left: 100, top: 100, width: 400, height: 600,
                    fill: bodyColor, selectable: false, evented: false
                });

                // B. Buat Area Sleeves (Lengan)
                const leftSleeve = new fabric.Rect({
                    left: 20, top: 120, width: 80, height: 250,
                    fill: sleeveColor, selectable: false, evented: false, angle: 10
                });
                const rightSleeve = new fabric.Rect({
                    left: 500, top: 120, width: 80, height: 250,
                    fill: sleeveColor, selectable: false, evented: false, angle: -10
                });

                // C. Terapkan Pattern (Jika ada)
                if (patternType === 'stripe') {
                    for(let i=100; i<500; i+=40) {
                        const stripe = new fabric.Rect({
                            left: i, top: 100, width: 20, height: 600,
                            fill: 'rgba(0,0,0,0.1)', selectable: false, evented: false
                        });
                        this.canvas.add(stripe);
                    }
                } else if (patternType === 'checkered') {
                    for(let i=100; i<500; i+=40) {
                        for(let j=100; j<700; j+=40) {
                            if ((i+j)%80 === 0) {
                                const check = new fabric.Rect({
                                    left: i, top: j, width: 40, height: 40,
                                    fill: 'rgba(0,0,0,0.1)', selectable: false, evented: false
                                });
                                this.canvas.add(check);
                            }
                        }
                    }
                }

                // Tambahkan object dasar ke canvas (Urutan layer penting!)
                this.canvas.add(body);
                this.canvas.add(leftSleeve);
                this.canvas.add(rightSleeve);
                this.canvas.sendToBack(body); // Pastikan body paling bawah

                // Re-add saved logos and roster
                if (savedLogos && savedLogos.length > 0) {
                    savedLogos.forEach(logo => this.canvas.add(logo));
                    this.logoObjects = savedLogos;
                }
                if (savedRoster && savedRoster.length > 0) {
                    savedRoster.forEach(text => this.canvas.add(text));
                    this.rosterObjects = savedRoster;
                }

                this.triggerUpdate();
            }

            addLogo(url, zone) {
                fabric.Image.fromURL(url, (img) => {
                    // Tentukan posisi berdasarkan zona
                    let pos = { left: 300, top: 300, scale: 0.2 }; // Default center
                    if (zone === 'leftChest') pos = { left: 380, top: 200, scale: 0.15 };
                    if (zone === 'rightChest') pos = { left: 220, top: 200, scale: 0.15 };
                    if (zone === 'sleeves') pos = { left: 50, top: 200, scale: 0.15 };

                    img.set({
                        left: pos.left,
                        top: pos.top,
                        scaleX: pos.scale,
                        scaleY: pos.scale,
                        originX: 'center',
                        originY: 'center',
                        selectable: true,
                        hasControls: true,
                        hasBorders: true,
                        borderColor: '#06b6d4',
                        cornerColor: '#a855f7',
                        cornerSize: 10,
                        transparentCorners: false
                    });
                    this.canvas.add(img);
                    this.logoObjects.push(img); // Store logo reference
                    this.canvas.setActiveObject(img);
                    
                    // Enable delete on Delete key
                    img.on('selected', () => {
                        const handleKeydown = (e) => {
                            if (e.key === 'Delete' && this.canvas.getActiveObject() === img) {
                                this.canvas.remove(img);
                                const idx = this.logoObjects.indexOf(img);
                                if (idx > -1) this.logoObjects.splice(idx, 1);
                                this.triggerUpdate();
                                document.removeEventListener('keydown', handleKeydown);
                            }
                        };
                        document.addEventListener('keydown', handleKeydown);
                    });
                    
                    this.triggerUpdate();
                }, { crossOrigin: 'anonymous' });
            }

            // Khusus untuk Roster (Nama & Nomor di Punggung)
            renderRoster(players, font, color) {
                // Remove old roster texts from storage
                this.rosterObjects.forEach(o => this.canvas.remove(o));
                this.rosterObjects = [];

                // Hanya render pemain pertama sebagai preview di canvas
                // (Di sistem real, ini harus looping render backend)
                if (players.length > 0) {
                    const player = players[0]; // Preview player pertama
                    
                    // Render Nomor
                    const numText = new fabric.Text(player.number.toString(), {
                        left: 300, top: 300,
                        fontSize: 180, fontFamily: font, fill: color,
                        originX: 'center', originY: 'center',
                        id: 'roster-text', selectable: true
                    });

                    // Render Nama
                    const nameText = new fabric.Text(player.name.toUpperCase(), {
                        left: 300, top: 180,
                        fontSize: 60, fontFamily: font, fill: color,
                        originX: 'center', originY: 'center',
                        id: 'roster-text', selectable: true
                    });

                    this.canvas.add(numText);
                    this.canvas.add(nameText);
                    this.rosterObjects.push(numText, nameText); // Store roster references
                }
                this.triggerUpdate();
            }

            triggerUpdate() {
                this.canvas.renderAll();
                if (this.textureUpdateCallback) this.textureUpdateCallback();
            }

            exportTexture() {
                return this.canvas.getElement(); // Mengembalikan elemen HTMLCanvas
            }
        }

        // 2. Three.js Manager (Untuk Preview 3D)
        class ThreeViewer {
            constructor(containerId) {
                this.container = document.getElementById(containerId);
                if (!this.container) {
                    console.error('Three.js container not found:', containerId);
                    return;
                }

                this.scene = new THREE.Scene();
                this.scene.background = new THREE.Color(0xe5e7eb); // Abu-abu terang

                // Ensure container has dimensions
                const width = this.container.clientWidth || 800;
                const height = this.container.clientHeight || 600;

                // Camera
                this.camera = new THREE.PerspectiveCamera(50, width / height, 0.1, 1000);
                this.camera.position.z = 40;

                // Renderer
                this.renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
                this.renderer.setSize(width, height);
                this.renderer.setPixelRatio(window.devicePixelRatio);
                this.renderer.shadowMap.enabled = true;
                this.container.appendChild(this.renderer.domElement);

                // Lighting setup
                const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
                this.scene.add(ambientLight);

                const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
                directionalLight.position.set(10, 10, 10);
                directionalLight.castShadow = true;
                this.scene.add(directionalLight);

                // Create Jersey Model using cylinders for better 3D appearance
                this.mesh = this.createJerseyModel();
                this.scene.add(this.mesh);

                // Setup mouse controls
                this.setupMouseControls();

                // Start animation loop
                this.animationFrameId = requestAnimationFrame(this.animate.bind(this));

                // Handle resize
                this.resizeHandler = () => this.onWindowResize();
                window.addEventListener('resize', this.resizeHandler);
            }

            createJerseyModel() {
                const group = new THREE.Group();

                // Material Dasar (Putih)
                const material = new THREE.MeshPhongMaterial({ 
                    color: 0xffffff,
                    side: THREE.DoubleSide
                });

                // ==========================================
                // 1. BADAN (BODY)
                // ==========================================
                // CylinderGeometry(radiusTop, radiusBottom, height, segments)
                // Kita buat atas lebih lebar (bahu) dari bawah (pinggang) sedikit
                const bodyGeometry = new THREE.CylinderGeometry(5.2, 4.8, 15, 64);
                const body = new THREE.Mesh(bodyGeometry, material);
                
                // PENTING: scale.set(x, y, z)
                // Kita pipihkan sumbu Z (0.65) agar badan jadi oval, bukan bulat sempurna
                body.scale.set(1, 1, 0.65); 
                
                body.castShadow = true;
                body.receiveShadow = true;
                group.add(body);

                // ==========================================
                // 2. LENGAN (SLEEVES)
                // ==========================================
                const sleeveGeometry = new THREE.CylinderGeometry(2.4, 2.2, 7, 32);
                
                // Lengan Kiri
                const leftSleeve = new THREE.Mesh(sleeveGeometry, material.clone());
                leftSleeve.position.set(-6, 3.5, 0); // Geser ke kiri dan agak atas
                leftSleeve.rotation.z = Math.PI / 2.5; // Miringkan sekitar 70 derajat
                leftSleeve.scale.set(1, 1, 0.7); // Pipihkan juga sesuai badan
                leftSleeve.castShadow = true;
                group.add(leftSleeve);

                // Lengan Kanan
                const rightSleeve = new THREE.Mesh(sleeveGeometry, material.clone());
                rightSleeve.position.set(6, 3.5, 0);
                rightSleeve.rotation.z = -Math.PI / 2.5; // Miringkan ke arah sebaliknya
                rightSleeve.scale.set(1, 1, 0.7);
                rightSleeve.castShadow = true;
                group.add(rightSleeve);

                // ==========================================
                // 3. KERAH (COLLAR)
                // ==========================================
                const collarGeometry = new THREE.TorusGeometry(3, 0.3, 16, 64);
                const collar = new THREE.Mesh(collarGeometry, new THREE.MeshPhongMaterial({ color: 0xeeeeee }));
                
                collar.position.y = 7.5; // Posisi di atas badan
                collar.rotation.x = Math.PI / 2; // Putar jadi mendatar
                collar.scale.set(1.4, 1, 1); // Lebarkan ke samping agar lonjong mengikuti bahu
                
                collar.castShadow = true;
                group.add(collar);

                return group;
            }

            setupMouseControls() {
                let isDragging = false;
                let previousMousePosition = { x: 0, y: 0 };

                this.renderer.domElement.addEventListener('mousedown', (e) => {
                    isDragging = true;
                    previousMousePosition = { x: e.clientX, y: e.clientY };
                });

                document.addEventListener('mousemove', (e) => {
                    if (isDragging && this.mesh) {
                        const deltaX = e.clientX - previousMousePosition.x;
                        const deltaY = e.clientY - previousMousePosition.y;

                        this.mesh.rotation.y += deltaX * 0.01;
                        this.mesh.rotation.x += deltaY * 0.01;

                        previousMousePosition = { x: e.clientX, y: e.clientY };
                    }
                });

                document.addEventListener('mouseup', () => {
                    isDragging = false;
                });

                // Zoom with scroll
                this.renderer.domElement.addEventListener('wheel', (e) => {
                    e.preventDefault();
                    this.camera.position.z += e.deltaY * 0.05;
                    this.camera.position.z = Math.max(20, Math.min(100, this.camera.position.z));
                });
            }

            updateTexture(canvasElementFront, canvasElementBack) {
                if (!this.mesh) return;

                // Use front texture for both sides (or implement dual-texture if needed)
                const texture = new THREE.CanvasTexture(canvasElementFront);
                texture.magFilter = THREE.LinearFilter;
                texture.minFilter = THREE.LinearFilter;

                // Update all mesh materials
                this.mesh.traverse((child) => {
                    if (child instanceof THREE.Mesh) {
                        child.material.map = texture;
                        child.material.needsUpdate = true;
                    }
                });
            }

            animate() {
                this.animationFrameId = requestAnimationFrame(this.animate.bind(this));
                this.renderer.render(this.scene, this.camera);
            }

            onWindowResize() {
                if (!this.container) return;

                const width = this.container.clientWidth || 800;
                const height = this.container.clientHeight || 600;

                this.camera.aspect = width / height;
                this.camera.updateProjectionMatrix();
                this.renderer.setSize(width, height);
            }

            destroy() {
                if (this.animationFrameId) {
                    cancelAnimationFrame(this.animationFrameId);
                }
                if (this.resizeHandler) {
                    window.removeEventListener('resize', this.resizeHandler);
                }
                if (this.renderer) {
                    this.renderer.dispose();
                    if (this.container && this.renderer.domElement) {
                        this.container.removeChild(this.renderer.domElement);
                    }
                }
            }
        }

        // 3. Alpine.js Component
        function jerseyCustomizer() {
            return {
                state: {
                    viewMode: 'front', // front, back, 3d
                    loading: false,
                    design: {
                        front: {
                            zones: {
                                body: { color: '#ffffff', pattern: 'solid' },
                                sleeves: { color: '#ffffff', pattern: 'solid' }
                            },
                            logos: [],
                            roster: {
                                players: [], // { name: 'Becks', number: 7, size: 'm' }
                                font: 'arial',
                                color: '#000000'
                            }
                        },
                        back: {
                            zones: {
                                body: { color: '#ffffff', pattern: 'solid' },
                                sleeves: { color: '#ffffff', pattern: 'solid' }
                            },
                            logos: [],
                            roster: {
                                players: [], // { name: 'Becks', number: 7, size: 'm' }
                                font: 'arial',
                                color: '#000000'
                            }
                        }
                    }
                },
                sections: { config: true, colors: true, logos: false, roster: false },
                colors: ['#ffffff', '#000000', '#ef4444', '#3b82f6', '#22c55e', '#eab308', '#a855f7'],
                uploadedLogo: null,
                selectedLogoZone: 'centerSponsor',
                fabricMgrFront: null,
                fabricMgrBack: null,
                threeMgr: null,

                init() {
                    // Inisialisasi setelah DOM siap
                    this.$nextTick(() => {
                        try {
                            // Create separate canvas managers for front and back
                            this.fabricMgrFront = new FabricCanvasManager('fabric-canvas-front');
                            this.fabricMgrBack = new FabricCanvasManager('fabric-canvas-back');
                            
                            // Delay Three.js init to ensure container is rendered
                            setTimeout(() => {
                                this.threeMgr = new ThreeViewer('three-viewer');
                                
                                // Hubungkan Fabric ke Three
                                if (this.threeMgr && this.threeMgr.mesh) {
                                    this.fabricMgrFront.textureUpdateCallback = () => this.updateThreeViewer();
                                    this.fabricMgrBack.textureUpdateCallback = () => this.updateThreeViewer();
                                }
                            }, 100);

                            // Render awal
                            this.refreshCanvas();
                        } catch (err) {
                            console.error('Initialization error:', err);
                        }
                    });
                },

                updateThreeViewer() {
                    if (!this.threeMgr || !this.threeMgr.mesh) return;
                    
                    // Combine front and back textures
                    // For now, use front texture; later can blend both
                    const textureFront = this.fabricMgrFront.exportTexture();
                    const textureBack = this.fabricMgrBack.exportTexture();
                    
                    if (textureFront) {
                        this.threeMgr.updateTexture(textureFront, textureBack);
                    }
                },

                refreshCanvas() {
                    const front = this.state.design.front;
                    const back = this.state.design.back;
                    
                    // Refresh front canvas
                    this.fabricMgrFront.renderBaseLayer(front.zones.body.color, front.zones.sleeves.color, front.zones.body.pattern);
                    if (front.roster.players.length > 0) {
                        this.fabricMgrFront.renderRoster(front.roster.players, front.roster.font, front.roster.color);
                    }

                    // Refresh back canvas
                    this.fabricMgrBack.renderBaseLayer(back.zones.body.color, back.zones.sleeves.color, back.zones.body.pattern);
                    if (back.roster.players.length > 0) {
                        this.fabricMgrBack.renderRoster(back.roster.players, back.roster.font, back.roster.color);
                    }

                    // Sync textures to 3D viewer
                    if (this.threeMgr && this.threeMgr.mesh) {
                        setTimeout(() => {
                            this.updateThreeViewer();
                        }, 50);
                    }
                },

                // UI Actions
                toggleSection(key) { this.sections[key] = !this.sections[key]; },
                
                updateZoneColor(zone, color) {
                    // Update both front and back
                    this.state.design.front.zones[zone].color = color;
                    this.state.design.back.zones[zone].color = color;
                    this.refreshCanvas();
                },

                updatePattern(val) {
                    // Update both front and back
                    this.state.design.front.zones.body.pattern = val;
                    this.state.design.back.zones.body.pattern = val;
                    this.refreshCanvas();
                },

                handleLogoUpload(e) {
                    const file = e.target.files[0];
                    if(file) {
                        const reader = new FileReader();
                        reader.onload = (evt) => { this.uploadedLogo = evt.target.result; };
                        reader.readAsDataURL(file);
                    }
                },

                updateLogoZone(val) { 
                    this.selectedLogoZone = val;
                },

                placeLogo() {
                    const zone = this.selectedLogoZone;
                    const currentView = this.state.viewMode;
                    
                    if (currentView === 'front') {
                        this.fabricMgrFront.addLogo(this.uploadedLogo, zone);
                    } else if (currentView === 'back') {
                        this.fabricMgrBack.addLogo(this.uploadedLogo, zone);
                    }
                },

                // Roster Logic
                addRosterRow() {
                    const currentView = this.state.viewMode;
                    if (currentView === 'front') {
                        this.state.design.front.roster.players.push({ name: '', number: '', size: 'm' });
                    } else if (currentView === 'back') {
                        this.state.design.back.roster.players.push({ name: '', number: '', size: 'm' });
                    }
                    this.refreshCanvas();
                },

                removeRosterPlayer(idx) {
                    const currentView = this.state.viewMode;
                    if (currentView === 'front') {
                        this.state.design.front.roster.players.splice(idx, 1);
                    } else if (currentView === 'back') {
                        this.state.design.back.roster.players.splice(idx, 1);
                    }
                    this.refreshCanvas();
                },

                updateRosterPlayer(idx, key, val) {
                    const currentView = this.state.viewMode;
                    const roster = currentView === 'front' 
                        ? this.state.design.front.roster.players 
                        : this.state.design.back.roster.players;
                    roster[idx][key] = val;
                    clearTimeout(this.rosterTimeout);
                    this.rosterTimeout = setTimeout(() => this.refreshCanvas(), 500);
                },

                updateRosterFont(val) { 
                    this.state.design.front.roster.font = val;
                    this.state.design.back.roster.font = val;
                    this.refreshCanvas(); 
                },

                updateRosterFontColor(val) { 
                    this.state.design.front.roster.color = val;
                    this.state.design.back.roster.color = val;
                    this.refreshCanvas(); 
                },

                switchViewMode(mode) {
                    this.state.viewMode = mode;
                    this.refreshCanvas();
                    
                    // Initialize 3D viewer if switching to 3D for first time
                    if (mode === '3d' && !this.threeMgr) {
                        this.$nextTick(() => {
                            setTimeout(() => {
                                try {
                                    this.threeMgr = new ThreeViewer('three-viewer');
                                    console.log('3D Viewer initialized successfully');
                                    
                                    // Sync current design
                                    this.updateThreeViewer();
                                } catch (err) {
                                    console.error('Failed to initialize 3D viewer:', err);
                                }
                            }, 50);
                        });
                    }
                },

                exportDesign() {
                    const data = JSON.stringify(this.state.design);
                    alert("Design JSON Data (Ready to save to DB):\n" + data);
                },
                
                exportPreview() {
                    alert("Fitur download image preview akan menggunakan canvas.toDataURL()");
                },

                addToCart() {
                    alert("Added to cart!");
                }
            }
        }

        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
</body>
</html>