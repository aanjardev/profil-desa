@extends('layouts.user')
@section('content')

@php
    // Warna diambil dari palet resmi tema (public/23/css/global/global.css):
    // primary #13b1cd, blueviolet #9877ea, gold #b99769, dark #222324, red #c54041, text #656565
    $publicTypeColors = [
        'kemasyarakatan' => '#13b1cd', // primary (warna utama tema)
        'pemerintahan'   => '#222324', // dark
        'ekonomi'        => '#b99769', // gold
        'kepemudaan'     => '#9877ea', // blueviolet
        'keagamaan'      => '#4fc3d9', // tint dari primary
        'keamanan'       => '#c54041', // red
        'lainnya'        => '#656565', // text/gray
    ];
    $badgeColor = $publicTypeColors[$institution->type] ?? '#6b7280';
@endphp

<!--========== PROMO BLOCK ==========-->
<div class="g-bg-position--center js__parallax-window" style="background: url('{{ asset('23/img/1920x1080/09.jpg') }}') 50% 0 no-repeat fixed;">
    <div class="g-container--md g-text-center--xs g-padding-y-150--xs">
        <p class="text-uppercase g-font-size-14--xs g-font-weight--700 g-color--white-opacity g-letter-spacing--2 g-margin-b-25--xs">
            {{ $typeLabels[$institution->type] ?? ucfirst($institution->type) }}
        </p>
        <h1 class="g-font-size-32--xs g-font-size-40--sm g-font-size-48--md g-color--white g-letter-spacing--1">
            {{ $institution->name }}
        </h1>
    </div>
</div>
<!--========== END PROMO BLOCK ==========-->

<style>
    .lembaga-badge { display: inline-block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; padding: 4px 10px; border-radius: 20px; color: #fff; }
    .lembaga-detail-logo { width: 100%; max-height: 260px; object-fit: contain; background: #f7f7f9; border-radius: 6px; padding: 20px; }
    .lembaga-contact-box { background: #f7f7f9; border-radius: 6px; padding: 22px 24px; margin-top: 25px; }
    .member-card { text-align: center; }
    .member-card__photo { width: 130px; height: 130px; border-radius: 50%; object-fit: cover; margin: 0 auto 15px; display: block; background: #f0f0f0; }
    .member-card__photo-placeholder { width: 130px; height: 130px; border-radius: 50%; margin: 0 auto 15px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 34px; color: #c7c9ce; }
    .gallery-thumb { width: 100%; height: 160px; object-fit: cover; border-radius: 6px; display: block; }
</style>

<div class="container g-padding-y-80--xs g-padding-y-125--sm">

    <a href="{{ route('kelembagaan') }}" class="g-font-size-14--xs g-font-weight--700 g-margin-b-30--xs g-display-block--xs">
        <i class="ti-arrow-left"></i> Kembali ke Kelembagaan
    </a>

    <div class="row g-margin-t-30--xs">
        {{-- Kolom Logo / Kontak --}}
        <div class="col-md-4 g-full-width--xs g-margin-b-40--xs">
            @if($institution->logo)
                <img src="{{ Storage::url($institution->logo) }}" alt="{{ $institution->name }}" class="lembaga-detail-logo">
            @endif

            <div class="lembaga-contact-box">
                <p class="g-font-size-13--xs g-font-weight--700 text-uppercase g-letter-spacing--1 g-margin-b-15--xs">Informasi</p>
                <p class="g-margin-b-10--xs">
                    <span class="lembaga-badge" style="background-color: {{ $badgeColor }};">
                        {{ $typeLabels[$institution->type] ?? ucfirst($institution->type) }}
                    </span>
                </p>
                @if($institution->contact_person)
                    <p class="g-font-size-14--xs g-color--text g-margin-b-0--xs">
                        <i class="ti-user"></i> {{ $institution->contact_person }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Kolom Deskripsi & Konten --}}
        <div class="col-md-8 g-full-width--xs">
            @if($institution->description)
                <div class="g-margin-b-50--xs">
                    <h3 class="g-font-size-20--xs g-margin-b-15--xs">Tentang Lembaga</h3>
                    <p class="g-color--text" style="line-height: 1.9; white-space: pre-line;">{{ $institution->description }}</p>
                </div>
            @endif

            {{-- Galeri Foto --}}
            @if(!empty($institution->images))
                <div class="g-margin-b-50--xs">
                    <h3 class="g-font-size-20--xs g-margin-b-20--xs">Galeri Foto</h3>
                    <div class="row g-row-col--0">
                        @foreach($institution->images as $img)
                            <div class="col-sm-4 col-xs-6 g-full-width--xs g-margin-b-20--xs">
                                <img src="{{ Storage::url($img['path']) }}" alt="Galeri {{ $institution->name }}" class="gallery-thumb">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Pengurus / Anggota --}}
            @if($institution->members->count())
                <div>
                    <h3 class="g-font-size-20--xs g-margin-b-25--xs">Pengurus / Anggota</h3>
                    <div class="row g-row-col--0">
                        @foreach($institution->members as $member)
                            <div class="col-sm-3 col-xs-6 g-full-width--xs g-margin-b-30--xs member-card">
                                @if($member->photo)
                                    <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}" class="member-card__photo">
                                @else
                                    <div class="member-card__photo-placeholder"><i class="ti-user"></i></div>
                                @endif
                                <h4 class="g-font-size-15--xs g-margin-b-3--xs">{{ $member->name }}</h4>
                                <span class="g-font-size-13--xs g-color--text"><i>{{ $member->position }}</i></span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection