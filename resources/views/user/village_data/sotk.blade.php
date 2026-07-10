@extends('layouts.user')

@section('title', 'SOTK Desa')

@section('content')
<!--========== PARALLAX HEADER ==========-->
<div class="g-padding-y-80--xs" style="background-image: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-top: 130px !important;">
    <!-- Dark Overlay -->
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
            .official-card {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                border: 1px solid #e2e8f0;
                overflow: hidden;
                text-align: center;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                height: 100%;
                max-width: 240px;
                margin: 0 auto;
            }
            .official-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            }
            .official-photo-wrapper {
                width: 210px;
                height: 280px;
                margin: 15px auto 15px;
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
                font-size: 50px;
                color: #cbd5e0;
            }
        </style>

        <!-- KEPALA DESA -->
        @if($kepala->count() > 0)
        <div class="g-margin-b-60--xs text-center">
            <h2 class="g-font-size-24--xs g-font-weight--700 g-margin-b-30--xs" style="color: #2d3748; position: relative; display: inline-block;">
                Kepala Desa
                <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 40px; height: 3px; background: #dc3545; border-radius: 2px;"></span>
            </h2>
            <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap;">
                @foreach($kepala as $official)
                <div class="col-sm-6 col-md-4 g-margin-b-30--xs">
                    <div class="official-card">
                        <div class="official-photo-wrapper">
                            @if($official->photo)
                                <img src="{{ asset('storage/'.$official->photo) }}" alt="{{ $official->name }}" class="official-photo">
                            @else
                                <i class="ti-user official-photo-placeholder"></i>
                            @endif
                        </div>
                        <div class="g-padding-x-20--xs g-padding-b-25--xs">
                            <h3 class="g-font-size-18--xs g-font-weight--700 g-margin-b-5--xs" style="color: #2d3748;">{{ $official->name }}</h3>
                            <p class="g-font-size-14--xs g-color--primary g-font-weight--600 g-margin-b-5--xs">{{ $official->position }}</p>
                            @if($official->nip)
                                <p class="g-font-size-12--xs" style="color: #a0aec0; margin-bottom: 0;">NIP/NIPD: {{ $official->nip }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- PEJABAT / KEPALA SEKSI -->
        @if($pejabat->count() > 0)
        <div class="g-margin-b-60--xs">
            <div class="text-center">
                <h2 class="g-font-size-24--xs g-font-weight--700 g-margin-b-40--xs" style="color: #2d3748; position: relative; display: inline-block;">
                    Sekretaris & Kepala Seksi / Urusan
                    <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 40px; height: 3px; background: #dc3545; border-radius: 2px;"></span>
                </h2>
            </div>
            <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap;">
                @foreach($pejabat as $official)
                <div class="col-sm-6 col-md-4 g-margin-b-30--xs">
                    <div class="official-card">
                        <div class="official-photo-wrapper">
                            @if($official->photo)
                                <img src="{{ asset('storage/'.$official->photo) }}" alt="{{ $official->name }}" class="official-photo">
                            @else
                                <i class="ti-user official-photo-placeholder"></i>
                            @endif
                        </div>
                        <div class="g-padding-x-20--xs g-padding-b-25--xs">
                            <h3 class="g-font-size-18--xs g-font-weight--700 g-margin-b-5--xs" style="color: #2d3748;">{{ $official->name }}</h3>
                            <p class="g-font-size-14--xs g-color--primary g-font-weight--600 g-margin-b-5--xs">{{ $official->position }}</p>
                            @if($official->nip)
                                <p class="g-font-size-12--xs" style="color: #a0aec0; margin-bottom: 0;">NIP/NIPD: {{ $official->nip }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- STAF -->
        @if($staff->count() > 0)
        <div class="g-margin-b-20--xs">
            <div class="text-center">
                <h2 class="g-font-size-24--xs g-font-weight--700 g-margin-b-40--xs" style="color: #2d3748; position: relative; display: inline-block;">
                    Staf & Kepala Dusun
                    <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 40px; height: 3px; background: #dc3545; border-radius: 2px;"></span>
                </h2>
            </div>
            <div class="row" style="display: flex; justify-content: center; flex-wrap: wrap;">
                @foreach($staff as $official)
                <div class="col-sm-6 col-md-3 g-margin-b-30--xs">
                    <div class="official-card">
                        <div class="official-photo-wrapper" style="width: 180px; height: 240px; margin-top: 15px;">
                            @if($official->photo)
                                <img src="{{ asset('storage/'.$official->photo) }}" alt="{{ $official->name }}" class="official-photo">
                            @else
                                <i class="ti-user official-photo-placeholder" style="font-size: 40px;"></i>
                            @endif
                        </div>
                        <div class="g-padding-x-15--xs g-padding-b-20--xs">
                            <h3 class="g-font-size-16--xs g-font-weight--700 g-margin-b-5--xs" style="color: #2d3748;">{{ $official->name }}</h3>
                            <p class="g-font-size-13--xs g-color--primary g-font-weight--600 g-margin-b-5--xs">{{ $official->position }}</p>
                            @if($official->nip)
                                <p class="g-font-size-11--xs" style="color: #a0aec0; margin-bottom: 0;">NIP/NIPD: {{ $official->nip }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($kepala->isEmpty() && $pejabat->isEmpty() && $staff->isEmpty())
        <div class="text-center g-padding-y-60--xs g-bg-color--white" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <i class="ti-id-badge g-font-size-40--xs g-color--primary g-margin-b-15--xs" style="display: block;"></i>
            <h4 class="g-font-size-20--xs g-margin-b-10--xs" style="color: #2d3748;">Data SOTK Belum Tersedia</h4>
            <p class="g-font-size-15--xs" style="color: #718096; margin-bottom: 0;">Struktur Organisasi dan Tata Kerja saat ini sedang dalam pembaruan.</p>
        </div>
        @endif
        
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection
