@extends('layouts.user')
@section('content')

<!--========== PROMO BLOCK ==========-->
<div class="g-bg-position--center js__parallax-window" style="background: url('{{ asset('23/img/1920x1080/09.jpg') }}') 50% 0 no-repeat fixed;">
    <div class="g-container--md g-text-center--xs g-padding-y-150--xs">
        <p class="text-uppercase g-font-size-14--xs g-font-weight--700 g-color--white-opacity g-letter-spacing--2 g-margin-b-25--xs">Profil Desa</p>
        <h1 class="g-font-size-40--xs g-font-size-50--sm g-font-size-60--md g-color--white g-letter-spacing--1">Kelembagaan Desa</h1>
    </div>
</div>
<!--========== END PROMO BLOCK ==========-->

<!--========== PAGE CONTENT ==========-->
@php
    // Warna badge/nav kategori khusus halaman publik (tema Bootstrap/Megakit, bukan Tailwind)
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
@endphp

<style>
    .lembaga-nav-wrap {
        position: sticky;
        top: 0;
        z-index: 20;
        background: #fff;
        border-bottom: 1px solid #eee;
    }
    .lembaga-nav {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 8px;
        padding: 18px 0;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .lembaga-nav::-webkit-scrollbar { display: none; }
    .lembaga-nav-item {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 9px 18px;
        border-radius: 30px;
        border: 1.5px solid #e6e6e6;
        color: #6b7280;
        background: #fff;
        cursor: pointer;
        transition: all .2s ease;
        white-space: nowrap;
    }
    .lembaga-nav-item:hover { border-color: #cfcfcf; color: #333; }
    .lembaga-nav-item.-is-active {
        color: #fff;
        border-color: transparent;
    }
    .lembaga-nav-item .count-dot {
        background: rgba(255,255,255,.35);
        font-size: 11px;
        font-weight: 700;
        padding: 1px 7px;
        border-radius: 20px;
    }
    .lembaga-nav-item:not(.-is-active) .count-dot { background: #f1f1f1; color: #9a9a9a; }

    .lembaga-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 6px;
        overflow: hidden;
        transition: box-shadow .25s ease, transform .25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .lembaga-card:hover { box-shadow: 0 15px 35px rgba(0,0,0,.08); transform: translateY(-4px); }
    .lembaga-card__logo-wrap {
        height: 190px;
        background: #f7f7f9;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .lembaga-card__logo-wrap img { max-height: 100%; max-width: 100%; object-fit: contain; padding: 20px; }
    .lembaga-card__logo-wrap .lembaga-placeholder-icon { font-size: 46px; color: #cfd2d8; }
    .lembaga-card__body { padding: 22px 24px 24px; flex: 1; display: flex; flex-direction: column; justify-content: flex-start; }
    .lembaga-badge {
        display: block;
        box-sizing: border-box;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 7px 14px;
        border-radius: 4px 0 0 4px;
        color: #fff;
        margin-bottom: 14px;
        margin-right: -24px;
        text-align: left;
    }
    .lembaga-card__desc { color: #767676; font-size: 14px; line-height: 1.7; margin-bottom: 20px; }
    .lembaga-card__link {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: inherit;
    }
    .lembaga-section-title { margin-bottom: 35px; }
    .lembaga-empty { text-align: center; padding: 80px 20px; color: #9a9a9a; }
    .lembaga-cat-section { display: none; }
    .lembaga-cat-section.-is-visible { display: block; }

    /* Grid kartu: pastikan tinggi kolom seragam meski kontennya beda (ada/tidak ada logo) */
    .lembaga-grid-row {
        display: flex;
        flex-wrap: wrap;
        margin-left: -15px;
        margin-right: -15px;
    }
    .lembaga-grid-row > [class*="col-"] {
        display: flex;
        padding-left: 15px;
        padding-right: 15px;
    }
    .lembaga-card__logo-wrap {
        flex-shrink: 0;
    }
</style>

{{-- Nav Kategori --}}
<div class="lembaga-nav-wrap">
    <div class="container">
        <div class="lembaga-nav" id="lembagaNav">
            <div class="lembaga-nav-item -is-active" data-cat="semua" style="background-color:#222324; border-color:#222324;">
                Semua
                <span class="count-dot">{{ $institutions->flatten()->count() }}</span>
            </div>
            @foreach($institutions as $type => $group)
                <div class="lembaga-nav-item" data-cat="{{ $type }}" data-color="{{ $publicTypeColors[$type] ?? '#6b7280' }}">
                    {{ $typeLabels[$type] ?? ucfirst($type) }}
                    <span class="count-dot">{{ $group->count() }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="container g-padding-y-60--xs g-padding-y-90--sm" id="lembagaContent">

    @php $hasAnyData = $institutions->flatten()->count() > 0; @endphp

    @if(!$hasAnyData)
        <div class="lembaga-empty">
            <i class="ti-home" style="font-size: 46px; color: #d5d5d5; display: block; margin-bottom: 16px;"></i>
            <h3 class="g-font-size-20--xs g-margin-b-10--xs">Belum Ada Data Lembaga</h3>
            <p>Data lembaga desa akan segera ditambahkan oleh admin.</p>
        </div>
    @else
        @foreach($institutions as $type => $group)
            <div class="lembaga-cat-section {{ $loop->first ? '-is-visible' : '' }}" data-cat-section="{{ $type }}">
                <div class="lembaga-section-title">
                    <p class="text-uppercase g-font-size-13--xs g-font-weight--700 g-letter-spacing--2 g-margin-b-10--xs"
                       style="color: {{ $publicTypeColors[$type] ?? '#6b7280' }};">
                        Kategori
                    </p>
                    <h2 class="g-font-size-26--xs g-font-size-30--sm">{{ $typeLabels[$type] ?? ucfirst($type) }}</h2>
                </div>

                <div class="row lembaga-grid-row">
                    @foreach($group as $institution)
                        <div class="col-md-4 col-sm-6 g-full-width--xs g-margin-b-30--xs">
                            <div class="lembaga-card">
                                @if($institution->logo)
                                    <div class="lembaga-card__logo-wrap">
                                        <img src="{{ Storage::url($institution->logo) }}" alt="{{ $institution->name }}"
                                             onerror="this.closest('.lembaga-card__logo-wrap').style.display='none';">
                                    </div>
                                @endif
                                <div class="lembaga-card__body">
                                    <span class="lembaga-badge" style="background-color: {{ $publicTypeColors[$type] ?? '#6b7280' }};">
                                        {{ $typeLabels[$type] ?? ucfirst($type) }}
                                    </span>
                                    <h3 class="g-font-size-18--xs g-margin-b-10--xs">{{ $institution->name }}</h3>
                                    @if($institution->description)
                                        <p class="lembaga-card__desc">{{ \Illuminate\Support\Str::limit(strip_tags($institution->description), 110) }}</p>
                                    @endif
                                    <a href="{{ route('kelembagaan.show', $institution) }}" class="lembaga-card__link">
                                        Lihat Detail <i class="ti-arrow-right" style="font-size: 11px; margin-left: 3px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif

</div>
<!--========== END PAGE CONTENT ==========-->

<script>
(function () {
    var navItems = document.querySelectorAll('#lembagaNav .lembaga-nav-item');
    var sections = document.querySelectorAll('.lembaga-cat-section');

    function activate(item) {
        var cat = item.getAttribute('data-cat');

        navItems.forEach(function (nav) {
            nav.classList.remove('-is-active');
            nav.style.backgroundColor = '#fff';
            nav.style.borderColor = '#e6e6e6';
            nav.style.color = '#6b7280';
        });
        item.classList.add('-is-active');
        var color = item.getAttribute('data-color') || '#222324';
        item.style.backgroundColor = color;
        item.style.borderColor = color;
        item.style.color = '#fff';

        sections.forEach(function (section) {
            var isMatch = (cat === 'semua') || (section.getAttribute('data-cat-section') === cat);
            if (isMatch) {
                if (typeof jQuery !== 'undefined') {
                    jQuery(section).stop(true, true).hide().removeClass('-is-visible').slideDown(300, function () {
                        section.classList.add('-is-visible');
                    });
                } else {
                    section.classList.add('-is-visible');
                }
            } else {
                if (typeof jQuery !== 'undefined') {
                    jQuery(section).stop(true, true).slideUp(200, function () {
                        section.classList.remove('-is-visible');
                    });
                } else {
                    section.classList.remove('-is-visible');
                }
            }
        });
    }

    navItems.forEach(function (item) {
        item.addEventListener('click', function () {
            activate(item);
        });
    });

    // Dipanggil dari dropdown navbar: /kelembagaan?type=ekonomi
    var params = new URLSearchParams(window.location.search);
    var typeParam = params.get('type');
    if (typeParam) {
        var target = document.querySelector('#lembagaNav .lembaga-nav-item[data-cat="' + typeParam + '"]');
        if (target) {
            activate(target);
            window.scrollTo({ top: document.getElementById('lembagaContent').offsetTop - 90, behavior: 'smooth' });
        }
    }
})();
</script>

@endsection