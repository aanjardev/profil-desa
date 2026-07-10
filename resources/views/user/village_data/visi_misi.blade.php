@extends('layouts.user')

@section('title', 'Visi & Misi Desa')

@section('content')
<!--========== PARALLAX HEADER ==========-->
<div class="g-padding-y-80--xs" style="background-image: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-top: 130px !important;">
    <!-- Dark Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(26, 32, 44, 0.85); z-index: 1;"></div>
    
    <div class="container text-center" style="position: relative; z-index: 2;">
        <h1 class="g-font-size-32--xs g-font-size-40--sm g-font-weight--700 g-color--white g-margin-b-10--xs">Visi & Misi</h1>
        <p class="g-font-size-16--xs g-color--white-opacity" style="max-width: 600px; margin: 0 auto;">Cita-cita dan langkah strategis untuk memajukan kesejahteraan masyarakat.</p>
    </div>
</div>
<!--========== END PARALLAX HEADER ==========-->

<!--========== PAGE CONTENT ==========-->
<div class="g-bg-color--sky-light g-padding-y-80--xs">
    <div class="container">
        
        <div class="row" style="display: flex; flex-wrap: wrap; justify-content: center;">
            <div class="col-md-10">
                <div style="background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e2e8f0;">
                    
                    @if($visiMisi)
                        @php
                            $content = $visiMisi->content;
                            // Basic parsing to split Visi and Misi if they exist.
                            // Assuming typical format contains "VISI:" and "MISI:"
                            $visi = '';
                            $misi = '';
                            if (strpos(strtoupper($content), 'MISI') !== false) {
                                $parts = preg_split('/MISI[:\n]/i', $content, 2);
                                $visiPart = str_ireplace('VISI:', '', $parts[0] ?? '');
                                $misiPart = $parts[1] ?? '';
                                
                                $visi = trim($visiPart);
                                $misi = trim($misiPart);
                            } else {
                                $visi = trim($content);
                            }
                        @endphp

                        <!-- VISI -->
                        <div class="g-padding-x-40--xs g-padding-y-50--xs text-center g-bg-color--primary" style="position: relative; overflow: hidden;">
                            <!-- Decor -->
                            <i class="ti-quote-left" style="position: absolute; top: -10px; left: 20px; font-size: 100px; color: rgba(255,255,255,0.1);"></i>
                            <i class="ti-quote-right" style="position: absolute; bottom: -10px; right: 20px; font-size: 100px; color: rgba(255,255,255,0.1);"></i>
                            
                            <h2 class="g-font-size-28--xs g-font-weight--700 g-color--white g-margin-b-20--xs">VISI DESA</h2>
                            <p class="g-font-size-20--xs g-font-size-24--sm g-font-weight--600 g-color--white" style="line-height: 1.6; font-style: italic;">
                                "{{ trim($visi, '"\' ') }}"
                            </p>
                        </div>

                        <!-- MISI -->
                        @if($misi)
                        <div class="g-padding-x-40--xs g-padding-x-60--sm g-padding-y-50--xs">
                            <h2 class="g-font-size-28--xs g-font-weight--700 g-margin-b-30--xs text-center" style="color: #2d3748;">
                                <span style="display: inline-block; padding-bottom: 10px; border-bottom: 3px solid #dc3545;">MISI DESA</span>
                            </h2>
                            <div class="g-font-size-16--xs" style="line-height: 1.8; color: #4a5568;">
                                {!! nl2br(e($misi)) !!}
                            </div>
                        </div>
                        @endif

                    @else
                        <div class="text-center g-padding-y-60--xs">
                            <i class="ti-flag-alt g-font-size-40--xs g-color--primary g-margin-b-15--xs" style="display: block;"></i>
                            <h4 class="g-font-size-20--xs g-margin-b-10--xs" style="color: #2d3748;">Data Visi & Misi Belum Tersedia</h4>
                            <p class="g-font-size-15--xs" style="color: #718096; margin-bottom: 0;">Konten ini sedang dalam pembaruan.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection
