@extends('layouts.user')

@section('title', $umkm->name . ' - UMKM Desa')

@section('content')
<!--========== PARALLAX HEADER ==========-->
<div class="g-padding-y-80--xs" style="background-image: url('{{ $umkm->main_image ? asset('storage/' . $umkm->main_image) : (\App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg')) }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-top: 155px !important; padding-bottom: 100px !important;">
    <!-- Dark Gradient Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.8) 100%); z-index: 1;"></div>
    
    <div class="container text-center" style="position: relative; z-index: 2;">
        @if($umkm->category)
        <span class="g-margin-b-15--xs" style="display: inline-block; background: #dc3545; color: #fff; padding: 6px 18px; border-radius: 30px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.35); border: 1px solid rgba(255,255,255,0.15);">
            {{ $umkm->category }}
        </span>
        @endif
        <h1 class="g-font-size-32--xs g-font-size-44--sm g-font-weight--700 g-color--white g-margin-b-15--xs" style="font-family: 'Montserrat', sans-serif; letter-spacing: -0.5px; margin-top: 10px;">{{ $umkm->name }}</h1>
        @if($umkm->owner_name)
        <p class="g-font-size-16--xs g-color--white-opacity" style="max-width: 600px; margin: 0 auto; line-height: 1.6;">
            Oleh: <strong style="color: #ffffff;">{{ $umkm->owner_name }}</strong>
        </p>
        @endif
    </div>
</div>
<!--========== END PARALLAX HEADER ==========-->

<!--========== PAGE CONTENT ==========-->
<div class="g-bg-color--sky-light g-padding-y-60--xs" style="background-color: #f8fafc !important;">
    <div class="container">
        
        <style>
            /* Sticky info card styling */
            .umkm-detail-card {
                background: #ffffff;
                border-radius: 16px !important;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02) !important;
                padding: 30px !important;
                border: 1px solid #e2e8f0 !important;
            }
            
            .umkm-detail-title {
                font-family: 'Montserrat', sans-serif;
                font-size: 18px !important;
                font-weight: 700 !important;
                color: #1e293b;
                margin-bottom: 20px;
                padding-bottom: 12px;
                border-bottom: 2px solid #f1f5f9;
                position: relative;
            }
            .umkm-detail-title::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 40px;
                height: 2px;
                background-color: #dc3545;
            }
            
            .umkm-detail-list li {
                display: flex;
                align-items: flex-start;
                margin-bottom: 18px;
            }
            .umkm-detail-list li:last-child {
                margin-bottom: 0;
            }
            .umkm-detail-icon {
                font-size: 16px;
                color: #dc3545;
                background: rgba(220, 53, 69, 0.06);
                padding: 8px;
                border-radius: 10px;
                margin-right: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 36px;
                flex-shrink: 0;
            }
            .umkm-detail-label {
                font-weight: 700;
                color: #64748b;
                display: block;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-bottom: 2px;
            }
            .umkm-detail-value {
                color: #1e293b;
                font-size: 14px;
                line-height: 1.5;
            }
            
            /* Social/Contact Buttons */
            .umkm-btn-contact {
                display: flex;
                align-items: center;
                padding: 8px 12px;
                margin-bottom: 8px;
                border-radius: 10px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                text-decoration: none !important;
                color: #475569 !important;
                font-weight: 600;
                font-size: 13px;
                transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            }
            .umkm-btn-contact:last-child {
                margin-bottom: 0;
            }
            .umkm-btn-contact i {
                font-size: 14px;
                margin-right: 12px;
                width: 28px;
                height: 28px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
                flex-shrink: 0;
            }
            
            /* WhatsApp */
            .umkm-btn-wa i {
                color: #25D366;
                background: rgba(37, 211, 102, 0.08);
            }
            .umkm-btn-wa:hover {
                background: #25D366;
                border-color: #25D366;
                color: #ffffff !important;
            }
            .umkm-btn-wa:hover i {
                color: #25D366;
                background: #ffffff;
            }
            
            /* Instagram */
            .umkm-btn-ig i {
                color: #e1306c;
                background: rgba(225, 48, 108, 0.08);
            }
            .umkm-btn-ig:hover {
                background: #e1306c;
                border-color: #e1306c;
                color: #ffffff !important;
            }
            .umkm-btn-ig:hover i {
                color: #e1306c;
                background: #ffffff;
            }
            
            /* Marketplace */
            .umkm-btn-marketplace i {
                color: #f53d2d;
                background: rgba(245, 61, 45, 0.08);
            }
            .umkm-btn-marketplace:hover {
                background: #f53d2d;
                border-color: #f53d2d;
                color: #ffffff !important;
            }
            .umkm-btn-marketplace:hover i {
                color: #f53d2d;
                background: #ffffff;
            }
            
            /* YouTube */
            .umkm-btn-youtube i {
                color: #ff0000;
                background: rgba(255, 0, 0, 0.08);
            }
            .umkm-btn-youtube:hover {
                background: #ff0000;
                border-color: #ff0000;
                color: #ffffff !important;
            }
            .umkm-btn-youtube:hover i {
                color: #ff0000;
                background: #ffffff;
            }
            
            /* Google Maps */
            .umkm-btn-maps i {
                color: #4285F4;
                background: rgba(66, 133, 244, 0.08);
            }
            .umkm-btn-maps:hover {
                background: #4285F4;
                border-color: #4285F4;
                color: #ffffff !important;
            }
            .umkm-btn-maps:hover i {
                color: #4285F4;
                background: #ffffff;
            }
            
            /* Main Content block styling */
            .umkm-details-box {
                background: #ffffff;
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.02);
                padding: 40px;
                border: 1px solid #e2e8f0;
                margin-bottom: 20px;
            }
            
            .umkm-details-section-title {
                font-family: 'Montserrat', sans-serif;
                font-size: 22px !important;
                font-weight: 700 !important;
                color: #1e293b;
                margin-bottom: 25px;
                display: flex;
                align-items: center;
            }
            .umkm-details-section-title::before {
                content: "";
                display: inline-block;
                width: 4px;
                height: 22px;
                background: #dc3545;
                margin-right: 12px;
                border-radius: 4px;
            }
            
            /* Facility pill */
            .facility-pill {
                display: flex;
                align-items: center;
                color: #475569;
                background: #f8fafc;
                padding: 10px 16px;
                border-radius: 10px;
                border: 1px solid #e2e8f0;
                margin-bottom: 12px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .facility-pill:hover {
                border-color: rgba(220, 53, 69, 0.25);
                background: rgba(220, 53, 69, 0.02);
                transform: translateY(-1px);
            }
            .facility-pill i {
                font-size: 16px;
                color: #dc3545;
                margin-right: 8px;
            }
            
            /* Image gallery block */
            .gallery-card {
                display: block;
                height: 200px;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                border: 1px solid #e2e8f0;
                transition: all 0.3s ease;
            }
            .gallery-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 25px rgba(220, 53, 69, 0.12);
                border-color: rgba(220, 53, 69, 0.2);
            }
            .gallery-card img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
            }
            .gallery-card:hover img {
                transform: scale(1.08);
            }

            /* Mobile: sidebar goes below content */
            @media (max-width: 991px) {
                /* Fix Bootstrap 3 pseudo-elements breaking flexbox */
                .umkm-show-row::before,
                .umkm-show-row::after {
                    display: none !important;
                }
                .umkm-show-row .umkm-sidebar-col {
                    margin-top: 20px;
                    order: 2 !important;
                    width: 100% !important;
                }
                .umkm-show-row .umkm-main-col {
                    order: 1 !important;
                    width: 100% !important;
                }
                .umkm-detail-card {
                    position: static !important;
                }
            }
        </style>
        
        <div class="g-margin-b-20--xs" style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #64748b; font-family: 'Montserrat', sans-serif;">
            <a href="{{ route('beranda') }}" style="color: #0ea5e9; text-decoration: none; transition: color 0.2s;"><i class="ti-home"></i> Beranda</a>
            <span style="color: #cbd5e1;">/</span>
            <a href="{{ route('umkm') }}" style="color: #0ea5e9; text-decoration: none; transition: color 0.2s;">UMKM</a>
            <span style="color: #cbd5e1;">/</span>
            <span style="color: #1e293b;">{{ $umkm->name }}</span>
        </div>

        <div class="row umkm-show-row" style="display: flex; flex-wrap: wrap;">
            <!-- Sidebar Info -->
            <div class="col-md-4 g-margin-b-30--xs umkm-sidebar-col">
                <div class="umkm-detail-card" style="position: -webkit-sticky; position: sticky; top: 100px;">
                    <h3 class="umkm-detail-title">Informasi UMKM</h3>
                    
                    <ul class="list-unstyled umkm-detail-list g-margin-b-30--xs">
                        <li>
                            <div class="umkm-detail-icon">
                                <i class="ti-briefcase"></i>
                            </div>
                            <div>
                                <span class="umkm-detail-label">Nama Usaha</span>
                                <span class="umkm-detail-value">{{ $umkm->name }}</span>
                            </div>
                        </li>

                        @if($umkm->owner_name)
                        <li>
                            <div class="umkm-detail-icon">
                                <i class="ti-user"></i>
                            </div>
                            <div>
                                <span class="umkm-detail-label">Pemilik</span>
                                <span class="umkm-detail-value">{{ $umkm->owner_name }}</span>
                            </div>
                        </li>
                        @endif

                        @if($umkm->location)
                        <li>
                            <div class="umkm-detail-icon">
                                <i class="ti-location-pin"></i>
                            </div>
                            <div>
                                <span class="umkm-detail-label">Lokasi</span>
                                <span class="umkm-detail-value">{{ $umkm->location }}</span>
                            </div>
                        </li>
                        @endif

                        @if($umkm->opening_hours)
                        <li>
                            <div class="umkm-detail-icon">
                                <i class="ti-time"></i>
                            </div>
                            <div>
                                <span class="umkm-detail-label">Jam Operasional</span>
                                <span class="umkm-detail-value">{{ $umkm->opening_hours }}</span>
                            </div>
                        </li>
                        @endif

                        @if($umkm->contact_person)
                        <li>
                            <div class="umkm-detail-icon">
                                <i class="ti-mobile"></i>
                            </div>
                            <div>
                                <span class="umkm-detail-label">Narahubung</span>
                                <span class="umkm-detail-value">{{ $umkm->contact_person }}</span>
                            </div>
                        </li>
                        @endif
                    </ul>

                    <!-- Social / Contact Links -->
                    @if($umkm->contact_person || $umkm->instagram_link || $umkm->youtube_link || $umkm->marketplace_link || $umkm->maps_link)
                    <div style="border-top: 2px solid #f1f5f9; padding-top: 20px;">
                        <h4 class="g-font-size-12--xs g-font-weight--700 g-margin-b-15--xs text-uppercase" style="color: #94a3b8; letter-spacing: 1px;">Hubungi & Kunjungi</h4>
                        
                        <div style="display: flex; flex-direction: column;">
                            @if($umkm->contact_person)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->contact_person) }}" target="_blank" class="umkm-btn-contact umkm-btn-wa">
                                    <i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg></i> Hubungi WhatsApp
                                </a>
                            @endif

                            @if($umkm->instagram_link)
                                <a href="{{ $umkm->instagram_link }}" target="_blank" class="umkm-btn-contact umkm-btn-ig">
                                    <i class="ti-instagram"></i> Kunjungi Instagram
                                </a>
                            @endif

                            @if($umkm->marketplace_link)
                                <a href="{{ $umkm->marketplace_link }}" target="_blank" class="umkm-btn-contact umkm-btn-marketplace">
                                    <i class="ti-shopping-cart"></i> Buka Marketplace
                                </a>
                            @endif

                            @if($umkm->youtube_link)
                                <a href="{{ $umkm->youtube_link }}" target="_blank" class="umkm-btn-contact umkm-btn-youtube">
                                    <i class="ti-youtube"></i> Tonton YouTube
                                </a>
                            @endif

                            @if($umkm->maps_link && !(Str::startsWith($umkm->maps_link, '<iframe') || Str::contains($umkm->maps_link, '<iframe')))
                                <a href="{{ $umkm->maps_link }}" target="_blank" class="umkm-btn-contact umkm-btn-maps">
                                    <i class="ti-map-alt"></i> Petunjuk Arah Maps
                                </a>
                            @endif
                        </div>
                    </div>

                    @if($umkm->maps_link && (Str::startsWith($umkm->maps_link, '<iframe') || Str::contains($umkm->maps_link, '<iframe')))
                    <div style="border-top: 2px solid #f1f5f9; padding-top: 20px; margin-top: 20px;">
                        <h4 class="g-font-size-12--xs g-font-weight--700 g-margin-b-15--xs text-uppercase" style="color: #94a3b8; letter-spacing: 1px;">Lokasi Peta</h4>
                        <div style="border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; aspect-ratio: 4/3; width: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.02);" class="umkm-embedded-map">
                            @php
                                $iframeCode = $umkm->maps_link;
                                if (stripos($iframeCode, '<iframe') !== false && stripos($iframeCode, '</iframe>') === false) {
                                    $iframeCode .= '</iframe>';
                                }
                            @endphp
                            {!! str_replace('<iframe ', '<iframe style="width: 100%; height: 100%; border: 0;" ', $iframeCode) !!}
                        </div>
                    </div>
                    @endif

                    @endif

                </div>
            </div>

            <!-- Main Details -->
            <div class="col-md-8 umkm-main-col">
                
                @if($umkm->main_image)
                <div class="g-margin-b-20--xs" style="border-radius: 16px; overflow: hidden; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.04); border: 1px solid #e2e8f0;">
                    <img src="{{ asset('storage/'.$umkm->main_image) }}" alt="{{ $umkm->name }}" style="width: 100%; max-height: 500px; object-fit: cover;">
                </div>
                @endif

                <div class="umkm-details-box">
                    <h2 class="umkm-details-section-title">Deskripsi Usaha</h2>
                    
                    <div class="g-font-size-16--xs" style="line-height: 1.8; color: #475569;">
                        {!! nl2br(e($umkm->description ?? 'Deskripsi belum tersedia.')) !!}
                    </div>

                    @if($umkm->facilities)
                    <div class="g-margin-t-20--xs">
                        <h3 class="g-font-size-18--xs g-font-weight--700 g-margin-b-20--xs" style="color: #1e293b; font-family: 'Montserrat', sans-serif;">Produk / Layanan</h3>
                        <div class="row">
                            @foreach(explode(',', $umkm->facilities) as $facility)
                                <div class="col-sm-6">
                                    <div class="facility-pill">
                                        <i class="ti-check-box"></i>
                                        <span>{{ trim($facility) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                @if(!empty($umkm->supporting_images) && is_array($umkm->supporting_images))
                <div class="umkm-details-box" style="margin-bottom: 0;">
                    <!-- <h2 class="umkm-details-section-title">Galeri Produk</h2> -->
                    
                    <div class="swiper-container js__swiper-gallery" style="padding-bottom: 40px; margin-top: 15px;">
                        <div class="swiper-wrapper umkm-gallery-container">
                            @foreach($umkm->supporting_images as $image)
                                @php
                                    $imagePath = is_array($image) ? ($image['path'] ?? '') : $image;
                                    $imageCaption = is_array($image) ? ($image['caption'] ?? '') : '';
                                @endphp
                                @if($imagePath)
                                <div class="swiper-slide">
                                    <div style="padding: 10px;">
                                        <a href="{{ asset('storage/'.$imagePath) }}" class="gallery-card umkm-gallery-popup" title="{{ $imageCaption }}">
                                            <img src="{{ asset('storage/'.$imagePath) }}" alt="{{ $imageCaption ?: 'Produk ' . $umkm->name }}">
                                        </a>
                                        @if($imageCaption)
                                        <p style="margin: 12px 0 0; font-size: 13px; color: #475569; line-height: 1.5; text-align: center; font-weight: 500;">
                                            {{ $imageCaption }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="swiper-pagination js__swiper-pagination"></div>
                    </div>
                </div>
                @endif
                
            </div>
        </div>
        
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        if (typeof Swiper !== 'undefined') {
            new Swiper('.js__swiper-gallery', {
                slidesPerView: 3,
                spaceBetween: 0,
                pagination: '.js__swiper-pagination',
                paginationClickable: true,
                autoplay: 4000,
                grabCursor: true,
                breakpoints: {
                    992: {
                        slidesPerView: 3,
                    },
                    768: {
                        slidesPerView: 2,
                    },
                    480: {
                        slidesPerView: 1,
                    }
                }
            });
        }

        if($.fn.magnificPopup) {
            $('.umkm-gallery-container').magnificPopup({
                delegate: 'a.umkm-gallery-popup',
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                },
                image: {
                    tError: '<a href="%url%">Gambar</a> tidak dapat dimuat.',
                    titleSrc: function(item) {
                        return item.el.attr('title') || '';
                    }
                },
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
            });
        }
    });
</script>
@endsection
