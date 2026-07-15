@extends('layouts.user')
@section('content')

@php
    // Warna diambil dari palet resmi tema (public/23/css/global/global.css)
    $publicTypeColors = [
        'kemasyarakatan' => '#13b1cd',
        'pemerintahan'   => '#222324',
        'ekonomi'        => '#b99769',
        'kepemudaan'     => '#9877ea',
        'keagamaan'      => '#4fc3d9',
        'keamanan'       => '#c54041',
        'lainnya'        => '#656565',
    ];
    $badgeColor = $publicTypeColors[$institution->type] ?? '#6b7280';
    $hasGallery = !empty($institution->images);
    $hasMembers = $institution->members->count() > 0;
@endphp

<style>
    :root { --lp-accent: {{ $badgeColor }}; }

    /* ===== Hero ===== */
    .lp-hero {
        background: linear-gradient(135deg, {{ $badgeColor }} 0%, #1c1c1e 130%);
        padding: 100px 0 90px;
        position: relative;
        overflow: hidden;
    }
    .lp-hero:before {
        content: "";
        position: absolute;
        right: -80px; top: -80px;
        width: 320px; height: 320px;
        border-radius: 50%;
        background: rgba(255,255,255,.06);
    }
    .lp-hero:after {
        content: "";
        position: absolute;
        left: -60px; bottom: -120px;
        width: 260px; height: 260px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
    }
    .lp-hero__crumb { position: relative; z-index: 2; font-size: 13px; color: rgba(255,255,255,.75); margin-bottom: 22px; }
    .lp-hero__crumb a { color: rgba(255,255,255,.75); text-decoration: none; }
    .lp-hero__crumb a:hover { color: #fff; }
    .lp-hero__eyebrow { position: relative; z-index: 2; font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,.8); margin-bottom: 12px; }
    .lp-hero__title { position: relative; z-index: 2; font-size: 40px; font-weight: 600; color: #fff; margin: 0; line-height: 1.25; max-width: 760px; }

    /* ===== Info card mengambang, overlap hero & content ===== */
    .lp-infocard {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 20px 45px rgba(20,20,30,.12);
        margin-top: -60px;
        position: relative;
        z-index: 3;
        padding: 28px 30px;
        display: flex;
        align-items: center;
        gap: 26px;
        flex-wrap: wrap;
    }
    .lp-infocard__logo {
        width: 84px; height: 84px;
        border-radius: 12px;
        background: #f5f6f8;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
        border: 1px solid #eef0f2;
    }
    .lp-infocard__logo img { width: 100%; height: 100%; object-fit: contain; padding: 8px; }
    .lp-infocard__body { flex: 1; min-width: 200px; }
    .lp-infocard__cat {
        display: inline-block;
        font-size: 11px; font-weight: 700; letter-spacing: .6px; text-transform: uppercase;
        color: var(--lp-accent);
        background: color-mix(in srgb, var(--lp-accent) 12%, white);
        padding: 4px 12px;
        border-radius: 20px;
        margin-bottom: 8px;
    }
    .lp-infocard__contact { font-size: 14px; color: #55575c; margin: 0; }
    .lp-infocard__contact i { color: var(--lp-accent); margin-right: 6px; }
    .lp-infocard__back {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px;
        color: #222; text-decoration: none;
        border: 1.5px solid #e6e6e6; border-radius: 30px;
        padding: 10px 18px;
        transition: all .2s ease;
        flex-shrink: 0;
    }
    .lp-infocard__back:hover { border-color: var(--lp-accent); color: var(--lp-accent); text-decoration: none; }

    /* ===== Sticky section nav ===== */
    .lp-subnav {
        position: sticky;
        top: 0;
        z-index: 15;
        background: #fff;
        border-bottom: 1px solid #eee;
        margin-top: 36px;
        box-shadow: 0 4px 12px rgba(20,20,30,.04);
    }
    .lp-subnav__inner { display: flex; gap: 6px; overflow-x: auto; }
    .lp-subnav a {
        display: inline-block;
        padding: 16px 4px;
        margin-right: 30px;
        font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
        color: #9a9ca0;
        text-decoration: none;
        border-bottom: 2.5px solid transparent;
        white-space: nowrap;
        transition: color .2s ease, border-color .2s ease;
    }
    .lp-subnav a:hover { color: #222; }
    .lp-subnav a.is-active { color: var(--lp-accent); border-color: var(--lp-accent); }

    /* ===== Content layout ===== */
    .lp-content { padding: 48px 0 90px; }
    .lp-section { scroll-margin-top: 70px; margin-bottom: 64px; }
    .lp-section:last-child { margin-bottom: 0; }
    .lp-section__title { font-size: 22px; font-weight: 600; color: #1c1c1e; margin: 0 0 22px; display: flex; align-items: center; gap: 10px; }
    .lp-section__title i { color: var(--lp-accent); font-size: 19px; }
    .lp-desc { font-size: 15.5px; line-height: 1.9; color: #4a4c50; white-space: pre-line; }

    /* ===== Sidebar kecil (opsional info tambahan) ===== */
    .lp-side-box { background: #f8f9fb; border-radius: 12px; padding: 22px; margin-bottom: 20px; }
    .lp-side-box__label { font-size: 11px; font-weight: 700; letter-spacing: .6px; text-transform: uppercase; color: #9a9ca0; margin-bottom: 10px; }
    .lp-sticky-wrap { position: sticky; top: 70px; }
    .lp-sticky-wrap .lp-side-box:last-child { margin-bottom: 0; }

    /* ===== Lembaga terkait ===== */
    .lp-related-list { list-style: none; margin: 0 0 14px; padding: 0; }
    .lp-related-item {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid #ecedf0;
        text-decoration: none;
        color: #2d2f33;
        font-size: 13.5px;
        transition: color .2s ease;
    }
    .lp-related-list li:last-child .lp-related-item { border-bottom: none; }
    .lp-related-item:hover { color: var(--lp-accent); text-decoration: none; }
    .lp-related-item__dot { width: 6px; height: 6px; border-radius: 50%; background: var(--lp-accent); flex-shrink: 0; }
    .lp-related-item__name { flex: 1; }
    .lp-related-item i { font-size: 11px; color: #c3c5c9; }
    .lp-related-more {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 12.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px;
        color: var(--lp-accent); text-decoration: none;
    }
    .lp-related-more:hover { text-decoration: underline; color: var(--lp-accent); }

    /* ===== CTA box ===== */
    .lp-cta-box { background: linear-gradient(135deg, var(--lp-accent) 0%, #1c1c1e 140%); }
    .lp-cta-btn {
        display: inline-flex; align-items: center; gap: 8px;
        background: #fff; color: #1c1c1e;
        font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px;
        padding: 11px 18px; border-radius: 8px;
        text-decoration: none;
        transition: transform .2s ease;
    }
    .lp-cta-btn:hover { transform: translateY(-2px); text-decoration: none; color: #1c1c1e; }

    .lp-empty { color: #9a9ca0; font-size: 14px; padding: 20px 0; }
    .lp-member { text-align: center; }
    .lp-member__photo {
        width: 108px; height: 108px; border-radius: 50%;
        margin: 0 auto 14px;
        background: #f0f2f5;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
        border: 3px solid #fff;
        box-shadow: 0 0 0 3px color-mix(in srgb, var(--lp-accent) 25%, white);
    }
    .lp-member__photo img { width: 100%; height: 100%; object-fit: cover; }
    .lp-member__photo i { font-size: 32px; color: #c7c9ce; }
    .lp-member__name { font-size: 14.5px; font-weight: 600; color: #1c1c1e; margin: 0 0 4px; }
    .lp-member__role {
        display: inline-block;
        font-size: 11px; font-weight: 600; color: var(--lp-accent);
        background: color-mix(in srgb, var(--lp-accent) 10%, white);
        padding: 3px 10px; border-radius: 20px;
    }

    /* ===== Galeri ===== */
    .lp-gallery__item {
        border-radius: 10px; overflow: hidden;
        aspect-ratio: 4/3; background: #f0f2f5;
        display: block;
        position: relative;
    }
    .lp-gallery__item img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .35s ease;
    }
    .lp-gallery__item:hover img { transform: scale(1.07); }
    .lp-gallery__item i { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font-size: 26px; color: #cfd2d8; }

    @media (max-width: 767px) {
        .lp-hero { padding: 60px 0 70px; }
        .lp-hero__title { font-size: 26px; }
        .lp-hero__eyebrow { font-size: 11px; }
        .lp-infocard { flex-direction: column; align-items: flex-start; margin-top: -36px; padding: 22px; gap: 16px; }
        .lp-infocard__logo { width: 68px; height: 68px; }
        .lp-infocard__back { width: 100%; justify-content: center; }
        .lp-sticky-wrap { position: static; margin-top: 8px; }

        .lp-subnav { margin-top: 24px; }
        .lp-subnav a { margin-right: 22px; padding: 13px 4px; font-size: 12px; }

        .lp-content { padding: 44px 0 60px; }
        .lp-section { margin-bottom: 44px; }
        .lp-section__title { font-size: 19px; margin-bottom: 20px; }
        .lp-subnav a:first-child { margin-left: 0; }

        .lp-member__photo { width: 84px; height: 84px; }
        .lp-member__name { font-size: 13.5px; }

        .lp-side-box { padding: 18px; }
        .lp-cta-btn { width: 100%; justify-content: center; }
    }
    @media (max-width: 420px) {
        .lp-hero__title { font-size: 22px; }
        .lp-infocard { margin-top: -28px; padding: 18px; }
    }
</style>

<!--========== HERO ==========-->
<div class="lp-hero">
    <div class="container">
        <p class="lp-hero__crumb">
            <a href="{{ route('beranda') }}">Beranda</a> /
            <a href="{{ route('kelembagaan') }}">Kelembagaan</a> /
            <span style="color:#fff;">{{ $institution->name }}</span>
        </p>
        <p class="lp-hero__eyebrow">{{ $typeLabels[$institution->type] ?? ucfirst($institution->type) }}</p>
        <h1 class="lp-hero__title">{{ $institution->name }}</h1>
    </div>
</div>
<!--========== END HERO ==========-->

<div class="container">
    <!-- Info card mengambang -->
    <div class="lp-infocard">
        @if($institution->logo)
            <div class="lp-infocard__logo">
                <img src="{{ Storage::url($institution->logo) }}" alt="{{ $institution->name }}"
                     onerror="this.closest('.lp-infocard__logo').style.display='none';">
            </div>
        @endif
        <div class="lp-infocard__body">
            <span class="lp-infocard__cat">{{ $typeLabels[$institution->type] ?? ucfirst($institution->type) }}</span>
            @if($institution->contact_person)
                <p class="lp-infocard__contact"><i class="ti-user"></i>{{ $institution->contact_person }}</p>
            @endif
        </div>
        <a href="{{ route('kelembagaan') }}" class="lp-infocard__back">
            <i class="ti-arrow-left"></i> Kelembagaan
        </a>
    </div>

    <!-- Sticky sub navigation -->
    <div class="lp-subnav">
        <div class="lp-subnav__inner">
            @if($hasMembers)<a href="#pengurus" class="lp-subnav-link {{ !$hasMembers ? '' : 'is-active' }}">Pengurus</a>@endif
            <a href="#tentang" class="lp-subnav-link {{ $hasMembers ? '' : 'is-active' }}">Tentang</a>
            @if($hasGallery)<a href="#galeri" class="lp-subnav-link">Galeri</a>@endif
        </div>
    </div>
</div>

<!--========== CONTENT ==========-->
<div class="container lp-content">
    <div class="row">
        <div class="col-md-8 g-full-width--xs">

            @if($hasMembers)
                <div class="lp-section" id="pengurus">
                    <h2 class="lp-section__title"><i class="ti-id-badge"></i> Pengurus &amp; Anggota</h2>
                    <div class="row">
                        @foreach($institution->members as $member)
                            <div class="col-sm-4 col-xs-6 g-full-width--xs g-margin-b-30--xs lp-member">
                                <div class="lp-member__photo">
                                    @if($member->photo)
                                        <img src="{{ Storage::url($member->photo) }}" alt="{{ $member->name }}"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        <i class="ti-user" style="display:none;"></i>
                                    @else
                                        <i class="ti-user"></i>
                                    @endif
                                </div>
                                <p class="lp-member__name">{{ $member->name }}</p>
                                <span class="lp-member__role">{{ $member->position }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="lp-section" id="tentang">
                <h2 class="lp-section__title"><i class="ti-info-alt"></i> Tentang Lembaga</h2>
                @if($institution->description)
                    <p class="lp-desc">{{ $institution->description }}</p>
                @else
                    <p class="lp-empty">Belum ada deskripsi untuk lembaga ini.</p>
                @endif
            </div>

            @if($hasGallery)
                <div class="lp-section" id="galeri">
                    <h2 class="lp-section__title"><i class="ti-gallery"></i> Galeri Foto</h2>
                    <div class="row">
                        @foreach($institution->images as $img)
                            <div class="col-sm-4 col-xs-6 g-full-width--xs g-margin-b-20--xs">
                                <a href="{{ Storage::url($img['path']) }}" target="_blank" class="lp-gallery__item">
                                    <img src="{{ Storage::url($img['path']) }}" alt="Galeri {{ $institution->name }}"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <i class="ti-image" style="display:none;"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

        <div class="col-md-4 g-full-width--xs">
            <div class="lp-sticky-wrap">
                <div class="lp-side-box">
                    <p class="lp-side-box__label">Ringkasan</p>
                    <p style="font-size:14px; color:#55575c; margin:0 0 14px;">
                        <strong>{{ $institution->name }}</strong> tergabung dalam kategori
                        <strong>{{ $typeLabels[$institution->type] ?? ucfirst($institution->type) }}</strong>.
                    </p>
                    @if($hasMembers)
                        <p style="font-size:14px; color:#55575c; margin:0 0 8px;">
                            <i class="ti-user" style="color:var(--lp-accent); margin-right:6px;"></i>
                            {{ $institution->members->count() }} pengurus/anggota terdaftar
                        </p>
                    @endif
                    @if($institution->contact_person)
                        <p style="font-size:14px; color:#55575c; margin:0;">
                            <i class="ti-comment-alt" style="color:var(--lp-accent); margin-right:6px;"></i>
                            Narahubung: {{ $institution->contact_person }}
                        </p>
                    @endif
                </div>

                @if($relatedInstitutions->count())
                    <div class="lp-side-box lp-related-box">
                        <p class="lp-side-box__label">Lembaga Lain di Kategori Ini</p>
                        <ul class="lp-related-list">
                            @foreach($relatedInstitutions as $related)
                                <li>
                                    <a href="{{ route('kelembagaan.show', $related) }}" class="lp-related-item">
                                        <span class="lp-related-item__dot"></span>
                                        <span class="lp-related-item__name">{{ $related->name }}</span>
                                        <i class="ti-angle-right"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('kelembagaan') }}?type={{ $institution->type }}" class="lp-related-more">
                            Lihat semua kategori ini <i class="ti-arrow-right"></i>
                        </a>
                    </div>
                @endif

                <div class="lp-side-box lp-cta-box">
                    <p class="lp-side-box__label" style="color:rgba(255,255,255,.7);">Butuh Informasi Lain?</p>
                    <p style="font-size:14px; color:#fff; margin:0 0 16px; line-height:1.7;">
                        Lihat daftar lengkap lembaga desa lainnya atau hubungi kantor desa untuk informasi lebih lanjut.
                    </p>
                    <a href="{{ route('kelembagaan') }}" class="lp-cta-btn">
                        <i class="ti-layout-grid2"></i> Semua Kelembagaan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--========== END CONTENT ==========-->

<script>
(function () {
    // Highlight sub-nav aktif sesuai section yang sedang dilihat
    var links = document.querySelectorAll('.lp-subnav-link');
    var sections = Array.from(links).map(function (l) {
        return document.querySelector(l.getAttribute('href'));
    }).filter(Boolean);

    function onScroll() {
        var pos = window.scrollY + 90;
        var current = sections[0];
        sections.forEach(function (sec) {
            if (sec.offsetTop <= pos) current = sec;
        });
        links.forEach(function (l) {
            l.classList.toggle('is-active', l.getAttribute('href') === '#' + current.id);
        });
    }
    window.addEventListener('scroll', onScroll, { passive: true });
})();
</script>

@endsection