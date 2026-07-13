@extends('layouts.user')

@section('title', 'Pariwisata Desa')

@section('content')
<!--========== PARALLAX HEADER ==========-->
<div class="g-padding-y-80--xs" style="background-image: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-top: 140px !important; padding-bottom: 90px !important;">
    <!-- Dark Gradient Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.8) 100%); z-index: 1;"></div>
    
    <div class="container text-center" style="position: relative; z-index: 2;">
        <span class="text-uppercase g-font-size-12--xs g-font-weight--700 g-color--primary g-letter-spacing--2" style="background: rgba(220, 53, 69, 0.15); padding: 6px 16px; border-radius: 50px; display: inline-block; margin-bottom: 15px; border: 1px solid rgba(220, 53, 69, 0.25);">Potensi Wisata</span>
        <h1 class="g-font-size-32--xs g-font-size-42--sm g-font-weight--700 g-color--white g-margin-b-15--xs" style="font-family: 'Montserrat', sans-serif; letter-spacing: -0.5px;">Pariwisata Desa</h1>
        <p class="g-font-size-16--xs g-color--white-opacity" style="max-width: 600px; margin: 0 auto; line-height: 1.6;">Jelajahi keindahan dan pesona destinasi wisata unggulan yang ada di desa kami.</p>
    </div>
</div>
<!--========== END PARALLAX HEADER ==========-->

<!--========== PAGE CONTENT ==========-->
<div class="g-bg-color--sky-light g-padding-y-60--xs" style="background-color: #f8fafc !important;">
    <div class="container">
        
        <style>
            /* Card Styles */
            .wisata-card {
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
            .wisata-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(220, 53, 69, 0.08) !important;
                border-color: rgba(220, 53, 69, 0.2) !important;
            }
            
            /* Image Container & Scale */
            .wisata-img-container {
                position: relative;
                height: 230px;
                overflow: hidden;
                background: #f1f5f9;
            }
            .wisata-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
            }
            .wisata-card:hover .wisata-img {
                transform: scale(1.08);
            }

            /* Content styling */
            .wisata-info-title {
                font-family: 'Montserrat', sans-serif;
                font-size: 19px !important;
                font-weight: 700 !important;
                line-height: 1.4;
                margin-bottom: 12px !important;
            }
            .wisata-info-title a {
                color: #1e293b !important;
                text-decoration: none !important;
                transition: color 0.2s ease;
            }
            .wisata-info-title a:hover {
                color: #dc3545 !important;
            }
            
            /* Meta text */
            .wisata-meta-item {
                font-size: 13px !important;
                display: flex;
                align-items: center;
                margin-bottom: 8px;
                color: #64748b;
            }
            .wisata-meta-item i {
                font-size: 14px;
                width: 20px;
                color: #dc3545;
                opacity: 0.85;
            }
            
            .wisata-meta-location {
                line-height: 1.5;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            .wisata-meta-description {
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
            .wisata-btn-detail {
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
            .wisata-btn-detail:hover {
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

            /* Universal Search Bar styling (inline) */

            /* Mobile Responsive */
            @media (max-width: 767px) {
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
                .wisata-img-container {
                    height: 180px;
                }
                .wisata-info-title {
                    font-size: 16px !important;
                }
                .wisata-card .g-padding-25--xs {
                    padding: 18px !important;
                }
                .wisata-btn-detail {
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
        
        <!-- Top Search Bar -->
        <div style="max-width: 800px; margin: -20px auto 30px auto;">
            <form action="{{ route('pariwisata') }}" method="GET">
                <div class="input-group" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); border-radius: 50px; overflow: hidden; background: #fff; border: 1px solid #e2e8f0;">
                    <input type="text" name="search" class="form-control" placeholder="Cari wisata, destinasi, atau lokasi..." value="{{ request('search') }}" style="height: 56px !important; border: none !important; padding-left: 25px !important; font-size: 15px; box-shadow: none !important;">
                    <span class="input-group-btn">
                        <button class="btn" type="submit" style="height: 56px !important; border: none !important; background: #dc3545 !important; color: #fff !important; padding: 0 30px !important; font-size: 16px !important; font-weight: 600; transition: all 0.3s ease;"><i class="ti-search g-margin-r-5--xs"></i> Cari</button>
                    </span>
                </div>
            </form>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-md-12 g-margin-b-30--xs">
                
                @if(request('search'))
                <div class="filter-reset-bar">
                    <h4 class="g-font-size-15--xs g-font-weight--400" style="color: #4a5568;">
                        <span>
                            Hasil pencarian: <strong>"{{ request('search') }}"</strong>
                        </span>
                        <a href="{{ route('pariwisata') }}" class="g-color--primary" style="font-size: 13px; font-weight: 600; text-decoration: none;"><i class="ti-close" style="font-weight: bold; margin-right: 2px;"></i> Hapus Pencarian</a>
                    </h4>
                </div>
                @endif

        @if($tourisms->count() > 0)
            
            <!-- Top Pagination / Results Bar -->
            <div class="results-info-bar g-margin-b-30--xs">
                <div class="g-font-size-14--xs" style="color: #64748b;">
                    <span class="hidden-xs">Menampilkan <strong>{{ $tourisms->firstItem() }}</strong> - <strong>{{ $tourisms->lastItem() }}</strong> dari <strong>{{ $tourisms->total() }}</strong> Wisata</span>
                    <span class="visible-xs" style="font-size: 13px;"><strong>{{ $tourisms->firstItem() }}-{{ $tourisms->lastItem() }}</strong> dari <strong>{{ $tourisms->total() }}</strong> Wisata</span>
                </div>
                <div class="custom-pagination">
                    @if ($tourisms->lastPage() > 1)
                        {{ $tourisms->links('pagination::bootstrap-4') }}
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
                @foreach($tourisms as $tourism)
                <div class="col-md-4 col-sm-6 g-margin-b-30--xs">
                    <article class="wisata-card">
                        
                        <!-- Image Container -->
                        <div class="wisata-img-container">
                            @if($tourism->main_image)
                                <img src="{{ asset('storage/'.$tourism->main_image) }}" alt="{{ $tourism->name }}" class="wisata-img">
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%;">
                                    <i class="ti-image" style="font-size: 44px; color: #cbd5e0;"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Card Content -->
                        <div class="g-padding-25--xs" style="flex-grow: 1; display: flex; flex-direction: column; padding: 25px !important;">
                            <h3 class="wisata-info-title">
                                <a href="{{ route('pariwisata.show', $tourism->slug) }}">{{ $tourism->name }}</a>
                            </h3>
                            
                            @if($tourism->opening_hours)
                            <p class="wisata-meta-item">
                                <i class="ti-time"></i> {{ $tourism->opening_hours }}
                            </p>
                            @endif
                            
                            @if($tourism->location)
                            <p class="wisata-meta-item wisata-meta-location">
                                <i class="ti-location-pin"></i> {{ $tourism->location }}
                            </p>
                            @endif

                            @if($tourism->description)
                            <p class="wisata-meta-description">
                                {{ strip_tags($tourism->description) }}
                            </p>
                            @endif

                            @if($tourism->tickets && is_array($tourism->tickets) && count($tourism->tickets) > 0)
                                @php
                                    $cheapest = min(array_column($tourism->tickets, 'price'));
                                @endphp
                                <p class="wisata-meta-item" style="margin-top: 8px; font-weight: 600; color: #10b981;">
                                    <i class="ti-ticket" style="color: #10b981;"></i> {{ $cheapest > 0 ? 'Mulai Rp ' . number_format((float)$cheapest, 0, ',', '.') : 'Gratis / Free' }}
                                </p>
                            @endif

                            @if($tourism->facilities)
                            <div style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 6px;">
                                @php
                                    $facilities = array_slice(explode(',', $tourism->facilities), 0, 3);
                                @endphp
                                @foreach($facilities as $facility)
                                    <span style="font-size: 10px; background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 4px; font-weight: 600;">{{ trim($facility) }}</span>
                                @endforeach
                                @if(count(explode(',', $tourism->facilities)) > 3)
                                    <span style="font-size: 10px; background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 4px; font-weight: 600;">+{{ count(explode(',', $tourism->facilities)) - 3 }}</span>
                                @endif
                            </div>
                            @endif

                            <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid #f1f5f9; display: flex; gap: 10px;">
                                <a href="{{ route('pariwisata.show', $tourism->slug) }}" class="wisata-btn-detail" style="flex: 1;">Lihat Detail</a>
                                @if($tourism->maps_link && !(Str::startsWith($tourism->maps_link, '<iframe') || Str::contains($tourism->maps_link, '<iframe')))
                                    <a href="{{ $tourism->maps_link }}" target="_blank" class="wisata-btn-detail" style="flex: 0 0 auto; width: 42px; padding: 0 !important; background: #4285F4 !important; border-color: #4285F4 !important; display: flex; align-items: center; justify-content: center;" title="Buka Maps">
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
                    <span class="hidden-xs">Menampilkan <strong>{{ $tourisms->firstItem() }}</strong> - <strong>{{ $tourisms->lastItem() }}</strong> dari <strong>{{ $tourisms->total() }}</strong> Wisata</span>
                    <span class="visible-xs" style="font-size: 13px;"><strong>{{ $tourisms->firstItem() }}-{{ $tourisms->lastItem() }}</strong> dari <strong>{{ $tourisms->total() }}</strong> Wisata</span>
                </div>
                <div class="custom-pagination">
                    @if ($tourisms->lastPage() > 1)
                        {{ $tourisms->links('pagination::bootstrap-4') }}
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
                <i class="ti-map-alt g-font-size-60--xs g-color--primary g-margin-b-20--xs" style="display: block; opacity: 0.8;"></i>
                <h4 class="g-font-size-22--xs g-margin-b-10--xs" style="color: #1e293b; font-family: 'Montserrat', sans-serif; font-weight: 700;">Data Wisata Tidak Ditemukan</h4>
                <p class="g-font-size-15--xs" style="color: #64748b; margin-bottom: 0; max-width: 500px; margin: 0 auto;">Belum ada data wisata yang ditambahkan atau tidak ada yang sesuai dengan pencarian Anda.</p>
                @if(request('search'))
                    <a href="{{ route('pariwisata') }}" class="text-uppercase s-btn s-btn--sm s-btn--primary-bg g-radius--50 g-margin-t-20--xs" style="border-radius: 30px; font-weight: 600; padding: 10px 24px;">Reset Pencarian</a>
                @endif
            </div>
        @endif
            
            </div> <!-- End Main Content -->
        </div>
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection
