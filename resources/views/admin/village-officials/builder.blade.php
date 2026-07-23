@extends('layouts.app')

@section('page_title', 'Desain SOTK Visual')
@section('page_subtitle', 'Atur posisi dan tarik garis antar perangkat desa secara manual layaknya papan tulis.')

@push('scripts')
{{-- Include LeaderLine library for drawing lines --}}
<script src="https://cdn.jsdelivr.net/npm/leader-line-new@1.1.9/leader-line.min.js"></script>
@endpush

@section('content')

@if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
        <ul class="list-disc pl-5 text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div x-data="{ tab: '{{ session('success') || $errors->any() ? 'settings' : 'builder' }}' }">
    <!-- Tabs Header -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-6" aria-label="Tabs">
            <button @click="tab = 'builder'"
                    :class="tab === 'builder' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm transition-colors">
                <i class="ti-layout-grid2 mr-1"></i> Builder SOTK Interaktif
            </button>
            <button @click="tab = 'settings'"
                    :class="tab === 'settings' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm transition-colors">
                <i class="ti-image mr-1"></i> Upload Gambar SOTK & Pengaturan
            </button>
        </nav>
    </div>

    <!-- Tab 1: Builder -->
    <div x-show="tab === 'builder'">
<style>
    #canvas-container {
        position: relative;
        width: 100%;
        height: 700px;
        background-color: #f8fafc;
        background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
        background-size: 20px 20px;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        overflow: auto;
        cursor: grab;
    }
    #canvas-container:active {
        cursor: grabbing;
    }
    .canvas-content {
        position: relative;
        width: 3000px;
        height: 3000px;
        transform-origin: 0 0;
    }
    
    .org-node-card {
        position: absolute;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        text-align: center;
        transition: transform 0.1s ease, box-shadow 0.3s ease;
        width: 200px;
        display: flex;
        flex-direction: column;
        z-index: 2;
        padding: 15px;
        cursor: pointer;
        user-select: none;
        touch-action: none;
    }
    .org-node-card * {
        pointer-events: none;
    }
    .org-node-card:hover {
        box-shadow: 0 12px 28px rgba(0,0,0,0.12);
        border-color: #3b82f6;
    }
    .org-node-card.selected-source {
        border: 2px solid #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
    }
    
    .org-node-photo-wrapper {
        width: 135px;
        height: 180px;
        margin: 0 auto 10px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #edf2f7;
        background-color: #f7fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .org-node-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .node-type-badge {
        font-size: 10px;
        padding: 3px 8px;
        border-radius: 12px;
        display: inline-block;
        margin-bottom: 10px;
        font-weight: bold;
        letter-spacing: 0.05em;
    }

    /* Controls Panel */
    .controls-panel {
        position: sticky;
        top: 0;
        background: white;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 50;
    }

    /* Drawer list */
    #unused-nodes {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 10px;
    }
    .drawer-node {
        flex-shrink: 0;
        padding: 8px 12px;
        background: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        cursor: grab;
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
</style>

{{-- Tools Panel --}}
<div class="controls-panel">
    <div class="flex items-center gap-4">
        <div>
            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Mode</span>
            <div class="flex bg-gray-100 p-1 rounded-lg">
                <button id="mode-move" class="px-4 py-1.5 text-sm font-semibold rounded-md bg-white shadow-sm text-blue-600">Geser (Drag)</button>
                <button id="mode-connect" class="px-4 py-1.5 text-sm font-semibold rounded-md text-gray-600 hover:text-gray-900">Tarik Garis</button>
                <button id="mode-delete-line" class="px-4 py-1.5 text-sm font-semibold rounded-md text-red-600 hover:text-red-700">Hapus Garis</button>
            </div>
        </div>
        <div class="border-l border-gray-200 pl-4">
            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tipe Garis (Jika Tarik Garis)</span>
            <select id="line-type-select" class="text-sm border-gray-300 rounded-md py-1.5">
                <option value="solid">Solid (Komando)</option>
                <option value="dashed">Putus-putus (Koordinasi)</option>
            </select>
        </div>
        <div class="border-l border-gray-200 pl-4 flex items-center gap-2">
            <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mr-1">Zoom:</span>
            <button onclick="setZoom(currentZoom - 0.1)" class="w-7 h-7 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-center font-bold text-gray-600">-</button>
            <span id="zoom-level-text" class="text-xs font-bold w-8 text-center">100%</span>
            <button onclick="setZoom(currentZoom + 0.1)" class="w-7 h-7 bg-gray-100 hover:bg-gray-200 rounded flex items-center justify-center font-bold text-gray-600">+</button>
        </div>
    </div>
    
    <div class="flex gap-3">
        <button onclick="saveLayout()" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan Desain
        </button>
    </div>
</div>

<div class="bg-white p-4 rounded-xl border border-gray-100 mb-4 shadow-sm">
    <h3 class="text-sm font-bold text-gray-700 mb-2">Perangkat yang belum diletakkan di Canvas:</h3>
    <div id="unused-nodes">
        @php $hasUnused = false; @endphp
        @foreach($officials as $official)
            @if($official->pos_x === null || $official->pos_y === null)
                @php $hasUnused = true; @endphp
                <div class="drawer-node" data-id="{{ $official->id }}" onclick="addToCanvas({{ $official->id }})">
                    <div class="w-6 h-6 rounded-full bg-gray-200 overflow-hidden">
                        @if($official->photo)
                            <img src="{{ asset('storage/'.$official->photo) }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    {{ $official->name }}
                    <button class="ml-2 w-5 h-5 rounded bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200">+</button>
                </div>
            @endif
        @endforeach
        
        @if(!$hasUnused)
            <p class="text-sm text-gray-400 italic">Semua perangkat sudah ada di canvas.</p>
        @endif
    </div>
</div>

{{-- Canvas Area --}}
<div id="canvas-container">
    <div class="canvas-content" id="canvas-area">
        {{-- Cards will be rendered here --}}
        @foreach($officials as $official)
            @if($official->pos_x !== null && $official->pos_y !== null)
                    @php
                        $badgeColor = match($official->type) {
                            'legislatif' => 'bg-purple-100 text-purple-700',
                            'kasun' => 'bg-amber-100 text-amber-700',
                            'staf' => 'bg-gray-100 text-gray-700',
                            default => 'bg-blue-100 text-blue-700',
                        };
                        $borderTop = match($official->type) {
                            'legislatif' => '#9333ea',
                            'kasun' => '#d97706',
                            'staf' => '#94a3b8',
                            default => '#3b82f6',
                        };
                    @endphp
                    
                    <div id="node-{{ $official->id }}" 
                         class="org-node-card"
                         data-id="{{ $official->id }}"
                         data-x="{{ $official->pos_x }}"
                         data-y="{{ $official->pos_y }}"
                         style="border-top: 3px solid {{ $borderTop }}; transform: translate({{ $official->pos_x }}px, {{ $official->pos_y }}px)">
                        
                        <span class="node-type-badge {{ $badgeColor }}">{{ $official->type_label }}</span>
                        
                        <div class="org-node-photo-wrapper">
                            @if($official->photo)
                                <img src="{{ asset('storage/'.$official->photo) }}" class="org-node-photo" draggable="false">
                            @else
                                <div class="flex items-center justify-center text-gray-400">
                                    <i class="ti-user" style="font-size: 40px;"></i>
                                </div>
                            @endif
                        </div>
                        
                        <h3 class="g-font-size-16--xs g-font-weight--700 g-margin-b-5--xs font-bold text-gray-900 text-sm line-clamp-2 leading-tight">{{ $official->name }}</h3>
                        <p class="g-font-size-12--xs g-font-weight--600 g-margin-b-5--xs text-xs font-semibold mt-1" style="color: {{ $borderTop }};">{{ $official->position }}</p>
                    </div>
            @endif
        @endforeach
    </div>
</div>
    </div>

    <!-- Tab 2: Settings & Image Upload -->
    <div x-show="tab === 'settings'" x-cloak>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-base font-bold text-gray-800">Pengaturan Tampilan SOTK Publik</h3>
                <p class="text-sm text-gray-500 mt-1">Pilih metode tampilan SOTK yang akan dilihat oleh masyarakat di website desa.</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.village-officials.builder.settings') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Tipe Tampilan SOTK</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-data="{ sotkType: '{{ old('sotk_type', $settings->sotk_type) }}' }">
                            <!-- Option 1: Builder -->
                            <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-colors"
                                   :class="sotkType === 'builder' ? 'border-blue-500 ring-1 ring-blue-500 bg-blue-50/20' : 'border-gray-300 hover:border-gray-400'">
                                <input type="radio" name="sotk_type" value="builder" class="sr-only" x-model="sotkType">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-bold text-gray-900 mb-1">Gunakan Diagram Builder</span>
                                        <span class="mt-1 flex items-center text-xs text-gray-500 leading-relaxed">
                                            Sistem akan menampilkan SOTK interaktif dari data perangkat desa (Tab 1).
                                        </span>
                                    </span>
                                </span>
                                <!-- Check icon -->
                                <svg class="h-5 w-5 text-blue-600" :class="sotkType === 'builder' ? 'opacity-100' : 'opacity-0'" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </label>

                            <!-- Option 2: Image -->
                            <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-colors"
                                   :class="sotkType === 'image' ? 'border-blue-500 ring-1 ring-blue-500 bg-blue-50/20' : 'border-gray-300 hover:border-gray-400'">
                                <input type="radio" name="sotk_type" value="image" class="sr-only" x-model="sotkType">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-bold text-gray-900 mb-1">Gunakan Gambar SOTK</span>
                                        <span class="mt-1 flex items-center text-xs text-gray-500 leading-relaxed">
                                            Sistem hanya akan menampilkan 1 (satu) gambar SOTK statis secara utuh.
                                        </span>
                                    </span>
                                </span>
                                <!-- Check icon -->
                                <svg class="h-5 w-5 text-blue-600" :class="sotkType === 'image' ? 'opacity-100' : 'opacity-0'" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload Gambar SOTK <span class="text-[10px] uppercase font-bold tracking-wider text-gray-400 bg-gray-100 px-2 py-0.5 rounded ml-2">Opsional jika pilih Builder</span></label>
                        
                        @if($settings->sotk_image_path)
                        <div class="mb-4">
                            <p class="text-xs text-gray-500 mb-2">Gambar saat ini:</p>
                            <img src="{{ asset('storage/'.$settings->sotk_image_path) }}" class="h-48 w-auto rounded-lg border border-gray-200 object-contain bg-gray-50 shadow-sm" alt="SOTK">
                        </div>
                        @endif

                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="sotk_image" class="relative cursor-pointer bg-white rounded-md font-bold text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-2 py-1">
                                        <span>Upload file gambar baru</span>
                                        <input id="sotk_image" name="sotk_image" type="file" class="sr-only" accept="image/*"
                                               onchange="document.getElementById('file-name').textContent = this.files[0].name">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, WEBP up to 2MB</p>
                                <p id="file-name" class="text-xs font-semibold text-blue-600 mt-2"></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-sm">
                            Simpan Pengaturan SOTK
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>

<script>
    // Initial data from server
    const officialsData = @json($officials->keyBy('id'));
    const initialLines = @json($lines);
    
    // State
    let mode = 'move'; // move, connect, delete-line
    let sourceNodeId = null;
    let lines = [];
    
    // DOM Elements
    const canvasContainer = document.getElementById('canvas-container');
    const canvasArea = document.getElementById('canvas-area');
    
    // Mode Switching
    document.getElementById('mode-move').addEventListener('click', (e) => setMode('move', e.target));
    document.getElementById('mode-connect').addEventListener('click', (e) => setMode('connect', e.target));
    document.getElementById('mode-delete-line').addEventListener('click', (e) => setMode('delete-line', e.target));
    
    function setMode(newMode, btnEl) {
        mode = newMode;
        sourceNodeId = null; // reset connection state
        document.querySelectorAll('.org-node-card').forEach(n => n.classList.remove('selected-source'));
        
        // Update button styles
        document.querySelectorAll('.controls-panel button[id^="mode-"]').forEach(btn => {
            btn.classList.remove('bg-white', 'shadow-sm', 'text-blue-600', 'text-red-600');
            btn.classList.add('text-gray-600');
            if (btn.id === 'mode-delete-line') btn.classList.add('hover:text-red-700');
        });
        
        btnEl.classList.remove('text-gray-600', 'hover:text-red-700');
        btnEl.classList.add('bg-white', 'shadow-sm');
        if (mode === 'delete-line') {
            btnEl.classList.add('text-red-600');
            document.body.style.cursor = 'crosshair';
        } else {
            btnEl.classList.add('text-blue-600');
            document.body.style.cursor = 'default';
        }
    }

    // Add node from drawer to canvas
    window.addToCanvas = function(id) {
        const off = officialsData[id];
        // Place in center of visible viewport roughly
        const scrollX = canvasContainer.scrollLeft;
        const scrollY = canvasContainer.scrollTop;
        const x = scrollX + 100;
        const y = scrollY + 100;
        
        off.pos_x = x;
        off.pos_y = y;
        
        // Create element
        let badgeColor = 'bg-blue-100 text-blue-700';
        let borderTop = '#3b82f6';
        if(off.type === 'legislatif') { badgeColor = 'bg-purple-100 text-purple-700'; borderTop = '#9333ea'; }
        else if(off.type === 'kasun') { badgeColor = 'bg-amber-100 text-amber-700'; borderTop = '#d97706'; }
        else if(off.type === 'staf') { badgeColor = 'bg-gray-100 text-gray-700'; borderTop = '#94a3b8'; }
        
        const photoHtml = off.photo 
            ? `<img src="/storage/${off.photo}" class="org-node-photo" draggable="false">` 
            : `<div class="flex items-center justify-center text-gray-400"><i class="ti-user" style="font-size: 40px;"></i></div>`;
            
        const html = `
            <div id="node-${id}" 
                 class="org-node-card"
                 data-id="${id}"
                 data-x="${x}"
                 data-y="${y}"
                 style="border-top: 3px solid ${borderTop}; transform: translate(${x}px, ${y}px)">
                <span class="node-type-badge ${badgeColor}">${off.type.toUpperCase()}</span>
                <div class="org-node-photo-wrapper">
                    ${photoHtml}
                </div>
                <h3 class="g-font-size-16--xs g-font-weight--700 g-margin-b-5--xs font-bold text-gray-900 text-sm line-clamp-2 leading-tight">${off.name}</h3>
                <p class="g-font-size-12--xs g-font-weight--600 g-margin-b-5--xs text-xs font-semibold mt-1" style="color: ${borderTop};">${off.position}</p>
            </div>
        `;
        
        canvasArea.insertAdjacentHTML('beforeend', html);
        
        // Remove from drawer
        event.currentTarget.remove();
        
        // Check if drawer empty
        const drawer = document.getElementById('unused-nodes');
        if(drawer.children.length === 0) {
            drawer.innerHTML = '<p class="text-sm text-gray-400 italic">Semua perangkat sudah ada di canvas.</p>';
        }
        
        // Attach click listener for new node
        attachNodeListeners(document.getElementById(`node-${id}`));
    }
    
    // Zoom functionality
    let currentZoom = 1.0;
    window.setZoom = function(z) {
        if(z < 0.2 || z > 2.0) return;
        currentZoom = z;
        canvasArea.style.transform = `scale(${currentZoom})`;
        document.getElementById('zoom-level-text').innerText = Math.round(currentZoom * 100) + '%';
        updateLines();
    };

    // Pure JS Drag and Drop
    let draggedNode = null;
    let dragStartX = 0;
    let dragStartY = 0;
    let initialX = 0;
    let initialY = 0;

    document.addEventListener('mousedown', (e) => {
        if (mode !== 'move') return;
        
        const card = e.target.closest('.org-node-card');
        if (card) {
            draggedNode = card;
            
            // Get current transform values
            initialX = parseFloat(card.getAttribute('data-x')) || 0;
            initialY = parseFloat(card.getAttribute('data-y')) || 0;
            
            // Record original mouse click pos
            dragStartX = e.clientX;
            dragStartY = e.clientY;
            
            // Bring to front
            document.querySelectorAll('.org-node-card').forEach(c => c.style.zIndex = '2');
            card.style.zIndex = '10';
            
            // Prevent default to avoid text selection
            e.preventDefault();
        }
    });

    document.addEventListener('mousemove', (e) => {
        if (!draggedNode) return;
        
        // Calculate new position considering zoom
        let dx = (e.clientX - dragStartX) / currentZoom;
        let dy = (e.clientY - dragStartY) / currentZoom;
        
        let newX = initialX + dx;
        let newY = initialY + dy;
        
        // Apply new position
        draggedNode.style.transform = `translate(${newX}px, ${newY}px)`;
        draggedNode.setAttribute('data-x', newX);
        draggedNode.setAttribute('data-y', newY);
        
        updateLines();
    });

    document.addEventListener('mouseup', () => {
        draggedNode = null;
    });
    
    // Canvas panning (drag canvas background)
    let isPanning = false;
    let startPanX, startPanY, startScrollLeft, startScrollTop;
    
    canvasContainer.addEventListener('mousedown', (e) => {
        if(e.target === canvasContainer || e.target === canvasArea) {
            isPanning = true;
            startPanX = e.clientX;
            startPanY = e.clientY;
            startScrollLeft = canvasContainer.scrollLeft;
            startScrollTop = canvasContainer.scrollTop;
        }
    });
    
    window.addEventListener('mouseup', () => { isPanning = false; });
    window.addEventListener('mousemove', (e) => {
        if(!isPanning) return;
        const dx = e.clientX - startPanX;
        const dy = e.clientY - startPanY;
        canvasContainer.scrollLeft = startScrollLeft - dx;
        canvasContainer.scrollTop = startScrollTop - dy;
    });

    // Node Click Handlers (For Connect / Delete Mode)
    function attachNodeListeners(node) {
        node.addEventListener('click', (e) => {
            const id = node.getAttribute('data-id');
            
            if (mode === 'connect') {
                if (!sourceNodeId) {
                    sourceNodeId = id;
                    node.classList.add('selected-source');
                } else {
                    if (sourceNodeId !== id) {
                        createLine(sourceNodeId, id, document.getElementById('line-type-select').value);
                    }
                    document.getElementById(`node-${sourceNodeId}`).classList.remove('selected-source');
                    sourceNodeId = null;
                }
            } 
        });
    }
    
    document.querySelectorAll('.org-node-card').forEach(attachNodeListeners);
    
    // Line Management
    function createLine(sourceId, targetId, lineType, isInit = false) {
        // Prevent duplicate lines
        const exists = lines.find(l => l.sourceId == sourceId && l.targetId == targetId);
        if (exists) return;
        
        const el1 = document.getElementById(`node-${sourceId}`);
        const el2 = document.getElementById(`node-${targetId}`);
        
        if(!el1 || !el2) return;

        const leaderLineOptions = {
            path: 'grid', // 'straight', 'arc', 'fluid', 'grid'
            color: lineType === 'dashed' ? '#9ca3af' : '#64748b',
            size: 2,
            startSocket: 'bottom',
            endSocket: 'top',
            endPlug: 'arrow3',
            endPlugSize: 1.5
        };
        
        if (lineType === 'dashed') {
            leaderLineOptions.dash = {animation: false, len: 6, gap: 4};
        }

        const line = new LeaderLine(el1, el2, leaderLineOptions);
        
        const lineObj = {
            line: line,
            sourceId: sourceId,
            targetId: targetId,
            lineType: lineType
        };
        
        lines.push(lineObj);
        
        // Add delete listener to the SVG line
        if(!isInit) setTimeout(() => attachDeleteEventToLine(lineObj), 100);
    }
    
    function attachDeleteEventToLine(lineObj) {
        try {
            const svgEl = document.body.querySelector(`svg.leader-line:last-of-type`);
            if (svgEl) {
                // Store reference
                lineObj.svgEl = svgEl;
                svgEl.style.cursor = 'pointer';
                svgEl.addEventListener('click', (e) => {
                    if (mode === 'delete-line') {
                        lineObj.line.remove();
                        lines = lines.filter(l => l !== lineObj);
                    }
                });
                
                // Hover effect
                svgEl.addEventListener('mouseenter', () => {
                    if(mode === 'delete-line') svgEl.style.opacity = '0.5';
                });
                svgEl.addEventListener('mouseleave', () => {
                    if(mode === 'delete-line') svgEl.style.opacity = '1';
                });
            }
        } catch(e) {}
    }
    
    function updateLines() {
        lines.forEach(l => {
            try { l.line.position(); } catch(e) {}
        });
    }
    
    // Initialization
    window.addEventListener('load', () => {
        // Draw initial lines
        initialLines.forEach(l => {
            createLine(l.source_id, l.target_id, l.line_type, true);
        });
        
        // Find all SVGs generated by LeaderLine and attach delete events
        setTimeout(() => {
            const svgs = document.querySelectorAll('svg.leader-line');
            lines.forEach((lObj, index) => {
                if (svgs[index]) {
                    lObj.svgEl = svgs[index];
                    svgs[index].style.cursor = 'pointer';
                    svgs[index].addEventListener('click', (e) => {
                        if (mode === 'delete-line') {
                            lObj.line.remove();
                            lines = lines.filter(l => l !== lObj);
                        }
                    });
                    svgs[index].addEventListener('mouseenter', () => {
                        if(mode === 'delete-line') svgs[index].style.opacity = '0.5';
                    });
                    svgs[index].addEventListener('mouseleave', () => {
                        if(mode === 'delete-line') svgs[index].style.opacity = '1';
                    });
                }
            });
            
            // Initial center scroll if canvas has elements
            if(document.querySelector('.org-node-card')) {
                canvasContainer.scrollLeft = 500;
                canvasContainer.scrollTop = 100;
            }
        }, 500);
    });
    
    // Need to reposition lines on scroll/resize because canvas is scrolled
    canvasContainer.addEventListener('scroll', updateLines);
    window.addEventListener('resize', updateLines);
    
    // Save function
    window.saveLayout = function() {
        const nodes = [];
        document.querySelectorAll('.org-node-card').forEach(el => {
            nodes.push({
                id: el.getAttribute('data-id'),
                pos_x: Math.round(parseFloat(el.getAttribute('data-x'))),
                pos_y: Math.round(parseFloat(el.getAttribute('data-y')))
            });
        });
        
        const linesData = lines.map(l => ({
            source_id: l.sourceId,
            target_id: l.targetId,
            line_type: l.lineType
        }));
        
        const btn = document.querySelector('button[onclick="saveLayout()"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Menyimpan...';
        btn.disabled = true;
        
        fetch('{{ route('admin.village-officials.builder.save') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                nodes: nodes,
                lines: linesData
            })
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                alert('Desain SOTK berhasil disimpan!');
            } else {
                alert('Terjadi kesalahan saat menyimpan.');
            }
        })
        .catch(err => {
            alert('Gagal menghubungi server.');
            console.error(err);
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
</script>
@endsection
