@extends('layouts.user')

@section('title', 'UMKM Desa')

@section('content')
<!--========== PARALLAX HEADER ==========-->
<div class="g-padding-y-80--xs" style="background-image: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-top: 140px !important; padding-bottom: 90px !important;">
    <!-- Dark Gradient Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.8) 100%); z-index: 1;"></div>
    
    <div class="container text-center" style="position: relative; z-index: 2;">
        <span class="text-uppercase g-font-size-12--xs g-font-weight--700 g-color--primary g-letter-spacing--2" style="background: rgba(220, 53, 69, 0.15); padding: 6px 16px; border-radius: 50px; display: inline-block; margin-bottom: 15px; border: 1px solid rgba(220, 53, 69, 0.25);">Potensi Ekonomi</span>
        <h1 class="g-font-size-32--xs g-font-size-42--sm g-font-weight--700 g-color--white g-margin-b-15--xs" style="font-family: 'Montserrat', sans-serif; letter-spacing: -0.5px;">UMKM Desa</h1>
        <p class="g-font-size-16--xs g-color--white-opacity" style="max-width: 600px; margin: 0 auto; line-height: 1.6;">Dukung potensi lokal melalui ragam Usaha Mikro, Kecil, dan Menengah dari desa kami.</p>
    </div>
</div>
<!--========== END PARALLAX HEADER ==========-->

<!--========== PAGE CONTENT ==========-->
<div class="g-bg-color--sky-light g-padding-y-60--xs" style="background-color: #f8fafc !important;">
    <div class="container">
        
        <style>
            /* Card Styles */
            .umkm-card {
                background: #ffffff;
                border-radius: 16px !important;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02) !important;
                overflow: hidden;
                border: 1px solid #e2e8f0 !important;
                height: 100%;
                display: flex;
                flex-direction: column;
                transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), border-color 0.4s ease !important;
            }
            .umkm-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(220, 53, 69, 0.08) !important;
                border-color: rgba(220, 53, 69, 0.2) !important;
            }
            
            /* Image Container & Scale */
            .umkm-img-container {
                position: relative;
                height: 230px;
                overflow: hidden;
                background: #f1f5f9;
            }
            .umkm-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
            }
            .umkm-card:hover .umkm-img {
                transform: scale(1.08);
            }
            
            /* Category Badge */
            .umkm-badge {
                position: absolute;
                top: 15px;
                left: 15px;
                background: rgba(220, 53, 69, 0.95) !important;
                backdrop-filter: blur(4px);
                -webkit-backdrop-filter: blur(4px);
                color: #ffffff !important;
                padding: 6px 14px !important;
                border-radius: 30px !important;
                font-size: 11px !important;
                font-weight: 700 !important;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                box-shadow: 0 4px 10px rgba(220, 53, 69, 0.2);
                z-index: 2;
                border: none !important;
            }

            /* Content styling */
            .umkm-info-title {
                font-family: 'Montserrat', sans-serif;
                font-size: 19px !important;
                font-weight: 700 !important;
                line-height: 1.4;
                margin-bottom: 12px !important;
            }
            .umkm-info-title a {
                color: #1e293b !important;
                text-decoration: none !important;
                transition: color 0.2s ease;
            }
            .umkm-info-title a:hover {
                color: #dc3545 !important;
            }
            
            /* Meta text */
            .umkm-meta-item {
                font-size: 13px !important;
                display: flex;
                align-items: center;
                margin-bottom: 8px;
                color: #64748b;
            }
            .umkm-meta-item i {
                font-size: 14px;
                width: 20px;
                color: #dc3545;
                opacity: 0.85;
            }
            .umkm-meta-owner {
                font-weight: 600;
                color: #dc3545;
                background: rgba(220, 53, 69, 0.05);
                padding: 4px 10px;
                border-radius: 6px;
                display: inline-flex;
                align-items: center;
                margin-bottom: 10px;
            }
            .umkm-meta-owner i {
                margin-right: 4px;
                color: #dc3545;
            }
            
            .umkm-meta-location {
                line-height: 1.5;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            .umkm-meta-description {
                font-size: 13px !important;
                line-height: 1.6;
                color: #64748b;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
                margin-top: 10px;
                margin-bottom: 5px;
            }
            
            /* Buttons */
            .umkm-btn-detail {
                background: #dc3545 !important;
                border: 1px solid #dc3545 !important;
                color: #ffffff !important;
                font-weight: 600 !important;
                font-size: 13px !important;
                letter-spacing: 0.5px;
                padding: 11px 20px !important;
                border-radius: 30px !important;
                transition: all 0.3s ease !important;
                width: 100%;
                text-align: center;
                display: inline-block;
                text-transform: uppercase;
                box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15) !important;
                text-decoration: none !important;
            }
            .umkm-btn-detail:hover {
                background: #c82333 !important;
                border-color: #bd2130 !important;
                box-shadow: 0 6px 16px rgba(220, 53, 69, 0.25) !important;
                transform: translateY(-1px);
                color: #ffffff !important;
            }
            
            /* Filter Reset Bar */
            .filter-reset-bar {
                border-radius: 14px;
                border: 1px solid #e2e8f0;
                background: #ffffff;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
                padding: 16px 20px;
                margin-bottom: 30px;
            }
            .filter-reset-bar h4 {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                margin: 0;
            }
            
            /* Top / Bottom Results bar */
            .results-info-bar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: #ffffff;
                padding: 15px 25px;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.02);
                border: 1px solid #e2e8f0;
            }
            
            .custom-pagination ul.pagination { margin: 0 !important; }
            .custom-pagination nav { display: flex; align-items: center; }
            .custom-pagination p { margin-bottom: 0 !important; }

            /* Mobile Search Bar */
            .mobile-search-bar {
                display: none;
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 16px;
                margin-bottom: 20px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            }

            /* Mobile Responsive */
            @media (max-width: 767px) {
                .mobile-search-bar {
                    display: block;
                }
                .results-info-bar {
                    padding: 10px 14px;
                    gap: 6px;
                }
                .results-info-bar .g-font-size-14--xs {
                    font-size: 12px !important;
                }
                .custom-pagination .pagination > li > span,
                .custom-pagination .pagination > li > a {
                    padding: 4px 10px !important;
                    font-size: 12px !important;
                }
                .umkm-img-container {
                    height: 180px;
                }
                .umkm-info-title {
                    font-size: 16px !important;
                }
                .umkm-card .g-padding-25--xs {
                    padding: 18px !important;
                }
                .umkm-btn-detail {
                    padding: 10px 16px !important;
                    font-size: 12px !important;
                }
                .filter-reset-bar {
                    padding: 12px 16px;
                }
                .filter-reset-bar h4 {
                    font-size: 13px !important;
                    flex-direction: column;
                    gap: 8px;
                }
            }
        </style>
        
        <!-- Top Search Bar & Categories -->
        <div style="max-width: 900px; margin: -20px auto 30px auto;">
            <form action="{{ route('umkm') }}" method="GET">
                <div class="input-group" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); border-radius: 50px; overflow: hidden; background: #fff; border: 1px solid #e2e8f0;">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk atau nama UMKM..." value="{{ request('search') }}" style="height: 56px !important; border: none !important; padding-left: 25px !important; font-size: 15px; box-shadow: none !important;">
                    <span class="input-group-btn">
                        <button class="btn" type="submit" style="height: 56px !important; border: none !important; background: #dc3545 !important; color: #fff !important; padding: 0 30px !important; font-size: 16px !important; font-weight: 600; transition: all 0.3s ease;"><i class="ti-search g-margin-r-5--xs"></i> Cari</button>
                    </span>
                </div>
            </form>

            @if(isset($categories) && $categories->count() > 0)
            <div style="margin-top: 20px; text-align: center;">
                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;">
                    <a href="{{ route('umkm') }}" class="btn-category {{ !request('category') ? 'active' : '' }}" style="padding: 6px 16px; border-radius: 30px; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid #e2e8f0; {{ !request('category') ? 'background: #dc3545; color: #fff; border-color: #dc3545;' : 'background: #fff; color: #475569;' }}">
                        Semua Kategori
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('umkm', ['category' => $cat->category]) }}" class="btn-category {{ request('category') == $cat->category ? 'active' : '' }}" style="padding: 6px 16px; border-radius: 30px; font-size: 13px; font-weight: 600; text-decoration: none; border: 1px solid #e2e8f0; {{ request('category') == $cat->category ? 'background: #dc3545; color: #fff; border-color: #dc3545;' : 'background: #fff; color: #475569;' }}">
                            {{ $cat->category }} <span style="margin-left: 4px; opacity: 0.8; font-size: 11px;">({{ $cat->total }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
            <style>
                .btn-category {
                    transition: all 0.3s ease;
                }
                .btn-category:not(.active):hover {
                    background: #f8fafc !important;
                    border-color: #cbd5e1 !important;
                    color: #1e293b !important;
                }
            </style>
            @endif
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-md-12 g-margin-b-30--xs g-margin-b-0--md">
                
                @if(request('search') || request('category'))
                <div class="filter-reset-bar">
                    <h4 class="g-font-size-15--xs g-font-weight--400" style="color: #4a5568;">
                        <span>
                            Hasil pencarian: 
                            @if(request('search')) <strong>"{{ request('search') }}"</strong> @endif
                            @if(request('category')) Kategori <strong>{{ request('category') }}</strong> @endif
                        </span>
                        <a href="{{ route('umkm') }}" class="g-color--primary" style="font-size: 13px; font-weight: 600; text-decoration: none;"><i class="ti-close" style="font-weight: bold; margin-right: 2px;"></i> Hapus Filter</a>
                    </h4>
                </div>
                @endif

        @if($umkms->count() > 0)
            
            <!-- Top Pagination / Results Bar -->
            <div class="results-info-bar g-margin-b-30--xs">
                <div class="g-font-size-14--xs" style="color: #64748b;">
                    <span class="hidden-xs">Menampilkan <strong>{{ $umkms->firstItem() }}</strong> - <strong>{{ $umkms->lastItem() }}</strong> dari <strong>{{ $umkms->total() }}</strong> UMKM</span>
                    <span class="visible-xs" style="font-size: 13px;"><strong>{{ $umkms->firstItem() }}-{{ $umkms->lastItem() }}</strong> dari <strong>{{ $umkms->total() }}</strong> UMKM</span>
                </div>
                <div class="custom-pagination">
                    @if ($umkms->lastPage() > 1)
                        {{ $umkms->links('pagination::bootstrap-4') }}
                    @else
                        <ul class="pagination">
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">&lsaquo;</span></li>
                            <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">&rsaquo;</span></li>
                        </ul>
                    @endif
                </div>
            </div>

            <div class="row" style="display: flex; flex-wrap: wrap;">
                @foreach($umkms as $umkm)
                <div class="col-md-4 col-sm-6 g-margin-b-30--xs">
                    <article class="umkm-card">
                        
                        <!-- Image Container -->
                        <div class="umkm-img-container">
                            @if($umkm->main_image)
                                <img src="{{ asset('storage/'.$umkm->main_image) }}" alt="{{ $umkm->name }}" class="umkm-img">
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%;">
                                    <i class="ti-image" style="font-size: 44px; color: #cbd5e0;"></i>
                                </div>
                            @endif
                            @if($umkm->category)
                            <span class="umkm-badge">
                                {{ $umkm->category }}
                            </span>
                            @endif
                        </div>

                        <!-- Card Content -->
                        <div class="g-padding-25--xs" style="flex-grow: 1; display: flex; flex-direction: column; padding: 25px !important;">
                            <h3 class="umkm-info-title">
                                <a href="{{ route('umkm.show', $umkm->slug) }}">{{ $umkm->name }}</a>
                            </h3>
                            
                            @if($umkm->owner_name)
                            <div>
                                <span class="umkm-meta-owner">
                                    <i class="ti-user"></i> {{ $umkm->owner_name }}
                                </span>
                            </div>
                            @endif
                            
                            @if($umkm->location)
                            <p class="umkm-meta-item umkm-meta-location">
                                <i class="ti-location-pin"></i> {{ $umkm->location }}
                            </p>
                            @endif

                            @if($umkm->description)
                            <p class="umkm-meta-description">
                                {{ strip_tags($umkm->description) }}
                            </p>
                            @endif

                            @if($umkm->opening_hours)
                            <p class="umkm-meta-item" style="margin-top: 8px;">
                                <i class="ti-time"></i> {{ $umkm->opening_hours }}
                            </p>
                            @endif

                            @if($umkm->facilities)
                            <div style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 6px;">
                                @php
                                    $facilities = array_slice(explode(',', $umkm->facilities), 0, 3);
                                @endphp
                                @foreach($facilities as $facility)
                                    <span style="font-size: 10px; background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 4px; font-weight: 600;">{{ trim($facility) }}</span>
                                @endforeach
                                @if(count(explode(',', $umkm->facilities)) > 3)
                                    <span style="font-size: 10px; background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 4px; font-weight: 600;">+{{ count(explode(',', $umkm->facilities)) - 3 }}</span>
                                @endif
                            </div>
                            @endif

                            <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid #f1f5f9; display: flex; gap: 10px;">
                                <a href="{{ route('umkm.show', $umkm->slug) }}" class="umkm-btn-detail" style="flex: 1;">Lihat Detail</a>
                                @if($umkm->contact_person)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->contact_person) }}" target="_blank" class="umkm-btn-detail" style="flex: 0 0 auto; width: 42px; padding: 0 !important; background: #25D366 !important; border-color: #25D366 !important; display: flex; align-items: center; justify-content: center;" title="Hubungi WhatsApp">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="display: inline-block; vertical-align: middle;"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg>
                                    </a>
                                @endif
                                @if($umkm->maps_link && !(Str::startsWith($umkm->maps_link, '<iframe') || Str::contains($umkm->maps_link, '<iframe')))
                                    <a href="{{ $umkm->maps_link }}" target="_blank" class="umkm-btn-detail" style="flex: 0 0 auto; width: 42px; padding: 0 !important; background: #4285F4 !important; border-color: #4285F4 !important; display: flex; align-items: center; justify-content: center;" title="Buka Maps">
                                        <i class="ti-map-alt" style="font-size: 16px;"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>

            <!-- Bottom Pagination -->
            <div class="results-info-bar g-margin-t-10--xs">
                <div class="g-font-size-14--xs" style="color: #64748b;">
                    <span class="hidden-xs">Menampilkan <strong>{{ $umkms->firstItem() }}</strong> - <strong>{{ $umkms->lastItem() }}</strong> dari <strong>{{ $umkms->total() }}</strong> UMKM</span>
                    <span class="visible-xs" style="font-size: 13px;"><strong>{{ $umkms->firstItem() }}-{{ $umkms->lastItem() }}</strong> dari <strong>{{ $umkms->total() }}</strong> UMKM</span>
                </div>
                <div class="custom-pagination">
                    @if ($umkms->lastPage() > 1)
                        {{ $umkms->links('pagination::bootstrap-4') }}
                    @else
                        <ul class="pagination">
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">&lsaquo;</span></li>
                            <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">&rsaquo;</span></li>
                        </ul>
                    @endif
                </div>
            </div>

        @else
            <div class="text-center g-padding-y-60--xs g-bg-color--white" style="border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 10px 30px rgba(0,0,0,0.02); padding: 50px 30px !important;">
                <i class="ti-package g-font-size-60--xs g-color--primary g-margin-b-20--xs" style="display: block; opacity: 0.8;"></i>
                <h4 class="g-font-size-22--xs g-margin-b-10--xs" style="color: #1e293b; font-family: 'Montserrat', sans-serif; font-weight: 700;">Data UMKM Tidak Ditemukan</h4>
                <p class="g-font-size-15--xs" style="color: #64748b; margin-bottom: 0; max-width: 500px; margin: 0 auto;">Belum ada data UMKM yang ditambahkan atau tidak ada yang sesuai dengan pencarian Anda.</p>
                @if(request('search') || request('category'))
                    <a href="{{ route('umkm') }}" class="text-uppercase s-btn s-btn--sm s-btn--primary-bg g-radius--50 g-margin-t-20--xs" style="border-radius: 30px; font-weight: 600; padding: 10px 24px;">Reset Pencarian</a>
                @endif
            </div>
        @endif
            
            </div> <!-- End Main Content col-md-12 -->
        </div>
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection
