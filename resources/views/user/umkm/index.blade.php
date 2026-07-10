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
        </style>
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-8 g-margin-b-30--xs g-margin-b-0--md">
                
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
                    Menampilkan <strong>{{ $umkms->firstItem() }}</strong> - <strong>{{ $umkms->lastItem() }}</strong> dari <strong>{{ $umkms->total() }}</strong> UMKM
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
                <div class="col-sm-6 g-margin-b-30--xs">
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

                            <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                                <a href="{{ route('umkm.show', $umkm->slug) }}" class="umkm-btn-detail">Lihat Detail</a>
                            </div>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>

            <!-- Bottom Pagination -->
            <div class="results-info-bar g-margin-t-10--xs">
                <div class="g-font-size-14--xs" style="color: #64748b;">
                    Menampilkan <strong>{{ $umkms->firstItem() }}</strong> - <strong>{{ $umkms->lastItem() }}</strong> dari <strong>{{ $umkms->total() }}</strong> UMKM
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
            
            </div> <!-- End Main Content col-md-8 -->
            
            <!-- Sidebar -->
            @include('user.umkm.sidebar')
        </div>
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection
