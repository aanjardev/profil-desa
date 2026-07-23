@extends('layouts.user')

@section('title', 'SOTK Desa')

@push('scripts')
{{-- Include LeaderLine library for drawing lines --}}
<script src="https://cdn.jsdelivr.net/npm/leader-line-new@1.1.9/leader-line.min.js"></script>
@endpush

@section('content')
<!--========== PARALLAX HEADER ==========-->
<div class="g-padding-y-80--xs" style="background-image: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-top: 130px !important;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(26, 32, 44, 0.85); z-index: 1;"></div>
    
    <div class="container text-center" style="position: relative; z-index: 2;">
        <h1 class="g-font-size-32--xs g-font-size-40--sm g-font-weight--700 g-color--white g-margin-b-10--xs">SOTK Desa</h1>
        <p class="g-font-size-16--xs g-color--white-opacity" style="max-width: 600px; margin: 0 auto;">Struktur Organisasi dan Tata Kerja Pemerintah Desa.</p>
    </div>
</div>
<!--========== END PARALLAX HEADER ==========-->

<!--========== PAGE CONTENT ==========-->
<div class="g-bg-color--sky-light g-padding-y-60--xs">
    <div class="container">
        
        <style>
            .org-tree-container {
                overflow-x: auto;
                padding-bottom: 20px;
                min-width: 100%;
            }
            .canvas-content {
                position: relative;
                width: 3000px;
                height: 1500px;
                transform-origin: 0 0;
            }
            
            /* ── Official Card ──────────────────────────────────── */
            .official-card {
                position: absolute;
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.06);
                border: 1px solid #e2e8f0;
                overflow: hidden;
                text-align: center;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                width: 200px;
                display: flex;
                flex-direction: column;
                z-index: 2;
                padding: 15px;
            }
            .official-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 28px rgba(0,0,0,0.12);
            }
            .official-photo-wrapper {
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
            .official-photo {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .official-photo-placeholder {
                font-size: 40px;
                color: #cbd5e0;
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

            /* ── Legend ─────────────────────────────────────────── */
            .org-legend {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-bottom: 24px;
                justify-content: center;
            }
            .org-legend-item {
                display: flex;
                align-items: center;
                gap: 7px;
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 6px 14px;
                font-size: 12px;
                font-weight: 600;
                color: #374151;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            }
            .org-legend-dot {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                flex-shrink: 0;
            }

            /* ── Line info ─────────────────────────────────── */
            .line-info {
                display: flex;
                flex-wrap: wrap;
                gap: 16px;
                justify-content: center;
                margin-top: 20px;
                font-size: 12px;
                color: #6b7280;
            }
            .line-info-item {
                display: flex;
                align-items: center;
                gap: 6px;
            }
            .line-solid { width: 30px; height: 2px; background: #64748b; }
            .line-dashed { width: 30px; height: 2px; border-top: 2px dashed #9ca3af; }
        </style>

        @php
            // Grouping logic
            $kades = $officials->first(fn($o) => stripos($o->position, 'Kepala Desa') !== false);
            $sekdes = $officials->first(fn($o) => stripos($o->position, 'Sekretaris') !== false);
            $bpd = $officials->first(fn($o) => $o->type === 'legislatif' || stripos($o->position, 'BPD') !== false || stripos($o->position, 'Badan Permusyawaratan') !== false);
            
            // Kasi & Kaur (Ensure they are not Staff)
            $kasis = $officials->filter(fn($o) => stripos($o->position, 'Kasi') !== false && $o->type !== 'staf' && stripos($o->position, 'Staf') === false)->values();
            $kaurs = $officials->filter(fn($o) => stripos($o->position, 'Kaur') !== false && $o->type !== 'staf' && stripos($o->position, 'Staf') === false)->values();
            
            // Kasuns
            $kasuns = $officials->filter(fn($o) => stripos($o->position, 'Kasun') !== false || stripos($o->position, 'Dusun') !== false || $o->type === 'kasun')->values();
            
            // Staffs
            $stafs = $officials->filter(fn($o) => $o->type === 'staf' || stripos($o->position, 'Staf') !== false);
            
            $nodes = [];

            // KADES
            if ($kades) $nodes[] = ['obj' => $kades, 'x' => 800, 'y' => 0];

            // BPD
            if ($bpd) $nodes[] = ['obj' => $bpd, 'x' => 440, 'y' => 0];

            // SEKDES
            if ($sekdes) $nodes[] = ['obj' => $sekdes, 'x' => 1160, 'y' => 340];

            // KASI (X: 200, 440, 680)
            $kasiXs = [200, 440, 680];
            foreach($kasis->take(3) as $i => $kasi) {
                $x = $kasiXs[$i];
                $nodes[] = ['obj' => $kasi, 'x' => $x, 'y' => 680];
                
                // Find staffs for this Kasi
                $kasiStaffs = $stafs->where('parent_id', $kasi->id)->values();
                foreach($kasiStaffs as $s_idx => $staff) {
                    $nodes[] = ['obj' => $staff, 'x' => $x, 'y' => 1020 + ($s_idx * 340)];
                }
            }

            // KAUR (X: 920, 1160, 1400)
            $kaurXs = [920, 1160, 1400];
            foreach($kaurs->take(3) as $i => $kaur) {
                $x = $kaurXs[$i];
                $nodes[] = ['obj' => $kaur, 'x' => $x, 'y' => 680];
                
                // Find staffs for this Kaur
                $kaurStaffs = $stafs->where('parent_id', $kaur->id)->values();
                foreach($kaurStaffs as $s_idx => $staff) {
                    $nodes[] = ['obj' => $staff, 'x' => $x, 'y' => 1020 + ($s_idx * 340)];
                }
            }

            // Hitung Max Staff untuk mengatur Y position Kasun
            $maxStaffs = 0;
            foreach ($kasis->merge($kaurs) as $parent) {
                $c = $stafs->where('parent_id', $parent->id)->count();
                if ($c > $maxStaffs) $maxStaffs = $c;
            }
            $kasunY = max(1360, 1020 + ($maxStaffs * 340));
            $canvasHeight = max(1700, $kasunY + 340);

            // KASUNS
            $kasunCount = $kasuns->count();
            $kasunXs = [];
            if ($kasunCount > 0) {
                if ($kasunCount == 1) $kasunXs = [800];
                else if ($kasunCount == 2) $kasunXs = [400, 1200];
                else {
                    $step = 1200 / ($kasunCount - 1);
                    for ($i=0; $i<$kasunCount; $i++) {
                        $kasunXs[] = 200 + ($step * $i);
                    }
                }
                
                foreach($kasuns as $i => $kasun) {
                    $nodes[] = ['obj' => $kasun, 'x' => $kasunXs[$i], 'y' => $kasunY];
                }
            }
        @endphp

        @php $web_setting = \App\Models\WebSetting::first(); @endphp
        
        @if($web_setting && $web_setting->sotk_type === 'image' && $web_setting->sotk_image_path)
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm text-center">
                <img src="{{ asset('storage/'.$web_setting->sotk_image_path) }}" class="max-w-full h-auto rounded-lg mx-auto shadow-sm border border-gray-100" alt="Struktur SOTK Desa">
            </div>
        @else
            @if($officials->count() > 0)
            {{-- Org Chart --}}
            <div class="org-tree-container" id="canvas-container" style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; width: 100%; overflow-x: auto; padding: 20px 0;">
                
                <div id="canvas-wrapper" style="position: relative; overflow: hidden; margin: 0 auto;">
                    <div class="canvas-content" id="canvas-area" style="width: 1600px; height: {{ $canvasHeight }}px; position: absolute; top: 0; left: 0; transform-origin: top left;">
                    
                    {{-- FIXED LINES --}}
                    <div class="sotk-lines" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
                        <!-- BPD Coordination Line (Dashed) -->
                        @if(isset($bpd) && $bpd && isset($kades) && $kades)
                        <div style="position: absolute; left: 640px; top: 140px; width: 160px; height: 2px; border-top: 2px dashed #9ca3af;"></div>
                        @endif

                        <!-- Main Vertical Line -->
                        <div style="position: absolute; left: 800px; top: 280px; width: 2px; height: {{ $kasunY - 320 }}px; background: #64748b;"></div>
                        
                        <!-- Sekdes Branch (Solid) -->
                        <div style="position: absolute; left: 800px; top: 310px; width: 360px; height: 2px; background: #64748b;"></div>
                        <!-- Drop to Sekdes -->
                        <div style="position: absolute; left: 1160px; top: 310px; width: 2px; height: 30px; background: #64748b;"></div>
                        
                        <!-- Kasi Horizontal -->
                        <div style="position: absolute; left: 200px; top: 640px; width: 600px; height: 2px; background: #64748b;"></div>
                        <!-- Kasi Drops -->
                        <div style="position: absolute; left: 200px; top: 640px; width: 2px; height: 40px; background: #64748b;"></div>
                        <div style="position: absolute; left: 440px; top: 640px; width: 2px; height: 40px; background: #64748b;"></div>
                        <div style="position: absolute; left: 680px; top: 640px; width: 2px; height: 40px; background: #64748b;"></div>
                        
                        <!-- Sekdes Vertical Drop (for Kaurs) -->
                        <div style="position: absolute; left: 1160px; top: 620px; width: 2px; height: 20px; background: #64748b;"></div>
                        <!-- Kaur Horizontal -->
                        <div style="position: absolute; left: 920px; top: 640px; width: 480px; height: 2px; background: #64748b;"></div>
                        <!-- Kaur Drops -->
                        <div style="position: absolute; left: 920px; top: 640px; width: 2px; height: 40px; background: #64748b;"></div>
                        <div style="position: absolute; left: 1160px; top: 640px; width: 2px; height: 40px; background: #64748b;"></div>
                        <div style="position: absolute; left: 1400px; top: 640px; width: 2px; height: 40px; background: #64748b;"></div>
                        
                        <!-- Staff Lines -->
                        @foreach($nodes as $node)
                            @if($node['obj']->type === 'staf')
                                <div style="position: absolute; left: {{ $node['x'] }}px; top: {{ $node['y'] - 60 }}px; width: 2px; height: 60px; background: #64748b;"></div>
                            @endif
                        @endforeach
                        
                        <!-- Kasuns Lines -->
                        @if($kasunCount > 0)
                            <div style="position: absolute; left: {{ $kasunXs[0] }}px; top: {{ $kasunY - 40 }}px; width: {{ end($kasunXs) - $kasunXs[0] }}px; height: 2px; background: #64748b;"></div>
                            @foreach($kasunXs as $kx)
                                <div style="position: absolute; left: {{ $kx }}px; top: {{ $kasunY - 40 }}px; width: 2px; height: 40px; background: #64748b;"></div>
                            @endforeach
                        @endif
                    </div>

                    {{-- CARDS --}}
                    @foreach($nodes as $node)
                        @php
                            $official = $node['obj'];
                            $borderTop = match($official->type) {
                                'legislatif' => '#9333ea',
                                'kasun' => '#d97706',
                                'staf' => '#94a3b8',
                                default => '#3b82f6',
                            };
                        @endphp
                        
                        <div class="official-card"
                             style="border-top: 3px solid {{ $borderTop }}; left: {{ $node['x'] - 100 }}px; top: {{ $node['y'] }}px; height: 280px; position: absolute; z-index: 10;">
                            <div class="official-photo-wrapper">
                                @if($official->photo)
                                    <img src="{{ asset('storage/'.$official->photo) }}" class="official-photo">
                                @else
                                    <div class="official-photo-placeholder flex items-center justify-center">
                                        <i class="ti-user"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="g-font-size-16--xs g-font-weight--700 g-margin-b-5--xs" style="color: #2d3748; line-height: 1.2;">{{ $official->name }}</h3>
                            <p class="g-font-size-12--xs g-font-weight--600 g-margin-b-5--xs" style="color: {{ $borderTop }};">{{ $official->position }}</p>
                            @if($official->nip)
                                <p class="g-font-size-11--xs" style="color: #a0aec0; margin-bottom: 0;">NIP: {{ $official->nip }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                </div>
            </div>

            {{-- Line info --}}
            <!-- <div class="line-info">
                <div class="line-info-item">
                    <span class="line-solid"></span>
                    Garis Komando
                </div>
                <div class="line-info-item">
                    <span class="line-dashed"></span>
                    Garis Koordinasi
                </div>
            </div> -->
            
            <script>
                function resizeSotk() {
                    const container = document.getElementById('canvas-container');
                    const wrapper = document.getElementById('canvas-wrapper');
                    const area = document.getElementById('canvas-area');
                    if (!container || !wrapper || !area) return;
                    
                    const containerWidth = container.clientWidth;
                    // Base width of the canvas is 1600px
                    let scale = containerWidth / 1600;
                    
                    // Set a minimum scale so text doesn't become too small to read on mobile
                    if (scale < 0.65) {
                        scale = 0.65;
                    }
                    
                    if (scale > 1) {
                        scale = 1; 
                    }

                    const scaledWidth = 1600 * scale;
                    const scaledHeight = {{ $canvasHeight }} * scale;

                    area.style.transform = `scale(${scale})`;
                    
                    // Update wrapper size based on scaled area so scrollbars are accurate
                    wrapper.style.width = `${scaledWidth}px`;
                    wrapper.style.height = `${scaledHeight}px`;
                    
                    // If the container is wider than our scaled chart, center it using margin
                    if (containerWidth > scaledWidth) {
                        wrapper.style.margin = '0 auto';
                    } else {
                        wrapper.style.margin = '0';
                    }
                }

                window.addEventListener('resize', resizeSotk);
                window.addEventListener('load', resizeSotk);
                
                // Run immediately as well
                resizeSotk();
            </script>
        @else
            <div class="text-center g-padding-y-60--xs g-bg-color--white" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <i class="ti-id-badge g-font-size-40--xs g-color--primary g-margin-b-15--xs" style="display: block;"></i>
                <h4 class="g-font-size-20--xs g-margin-b-10--xs" style="color: #2d3748;">Data SOTK Belum Tersedia</h4>
                <p class="g-font-size-15--xs" style="color: #718096; margin-bottom: 0;">Bagan Struktur Organisasi dan Tata Kerja belum didesain oleh Admin.</p>
            </div>
        @endif
        @endif
        
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection
