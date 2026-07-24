@extends('layouts.user')

@section('title', 'Agenda Kegiatan Desa')

@section('content')

<!--========== PARALLAX HEADER ==========-->
<div class="g-padding-y-80--xs" style="background-image: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-top: 130px !important;">
    <!-- Dark Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(26, 32, 44, 0.85); z-index: 1;"></div>
    
    <div class="container text-center" style="position: relative; z-index: 2;">
        <h1 class="g-font-size-32--xs g-font-size-40--sm g-font-weight--700 g-color--white g-margin-b-10--xs">Agenda Kegiatan Desa</h1>
        <p class="g-font-size-16--xs g-color--white-opacity" style="max-width: 600px; margin: 0 auto;">Informasi lengkap mengenai jadwal, acara, dan kegiatan mendatang di desa kami.</p>
    </div>
</div>
<!--========== END PARALLAX HEADER ==========-->

<!--========== PAGE CONTENT ==========-->
<div class="g-bg-color--sky-light g-padding-y-60--xs">
    <div class="container">

        <div class="row">
            <!-- Main Content (List) -->
            <div class="col-md-8 g-margin-b-30--xs g-margin-b-0--md">
                
                <!-- Filter Status -->
                @if(request('search') || request('category') || request('month'))
                <div class="g-margin-b-30--xs g-bg-color--white g-padding-x-20--xs g-padding-y-20--xs" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                    <h4 class="g-font-size-16--xs g-font-weight--400 g-margin-b-0--xs" style="color: #4a5568;">
                        Hasil untuk: 
                        @if(request('search')) <strong>"{{ request('search') }}"</strong> @endif
                        @if(request('category')) Kategori <strong>{{ request('category') }}</strong> @endif
                        @if(request('month') && request('year')) Bulan <strong>{{ \Carbon\Carbon::create()->month((int)request('month'))->translatedFormat('F') }} {{ request('year') }}</strong> @endif
                        <a href="{{ route('agenda-kegiatan') }}" class="pull-right g-color--primary" style="font-size: 13px;"><i class="ti-close"></i> Hapus Filter</a>
                    </h4>
                </div>
                @endif

                @if(isset($agendas) && $agendas->count() > 0)
                    <style>
                        .custom-pagination ul.pagination { margin: 0 !important; }
                        /* Mobile: header agenda row jadi column */
                        @media (max-width: 767px) {
                            .agenda-card-header {
                                flex-direction: column !important;
                                align-items: flex-start !important;
                            }
                            .agenda-mobile-date {
                                display: inline-flex !important;
                                align-items: center;
                                padding-left: 10px;
                            }
                        }
                    </style>
                    
                    <!-- Top Pagination & Info -->
                    <div class="g-margin-b-30--xs" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px; flex-wrap: wrap; gap: 15px;">
                        <p class="g-font-size-14--xs" style="color: #4a5568; margin-bottom: 0;">
                            Menampilkan <strong>{{ $agendas->count() }}</strong> dari <strong>{{ $agendas->total() }}</strong> agenda
                        </p>
                        <div class="custom-pagination">
                            @if ($agendas->lastPage() > 1)
                                {{ $agendas->links('pagination::bootstrap-4') }}
                            @else
                                <ul class="pagination">
                                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                                    <li class="page-item active"><span class="page-link">1</span></li>
                                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                                </ul>
                            @endif
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 30px;">
                        @foreach($agendas as $agenda)
                            <!-- Full Detail Card -->
                            <article style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 30px; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.05)';">
                                <div class="agenda-card-header g-margin-b-15--xs" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; cursor: pointer;" data-toggle="collapse" data-target="#collapseAgenda{{ $agenda->id }}" aria-expanded="false" aria-controls="collapseAgenda{{ $agenda->id }}">
                                    <div>
                                        <span class="g-font-size-12--xs g-color--primary g-padding-x-10--xs g-padding-y-5--xs g-radius--50 g-font-weight--700 g-margin-b-10--xs" style="display: inline-block; border: 1.5px solid #dc3545; background: rgba(220,53,69,0.06);"><i class="ti-tag g-margin-r-5--xs"></i>{{ $agenda->category ?? 'Lainnya' }}</span>
                                        {{-- Tanggal 1 baris hanya di mobile --}}
                                        <span class="visible-xs agenda-mobile-date g-font-size-13--xs" style="display: none; color: #4a5568; margin-bottom: 8px;">
                                            <i class="ti-calendar g-color--primary g-margin-r-5--xs"></i>
                                            {{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('d F Y') }}
                                            @if($agenda->end_date && $agenda->end_date != $agenda->start_date)
                                                &ndash; {{ \Carbon\Carbon::parse($agenda->end_date)->translatedFormat('d F Y') }}
                                            @endif
                                        </span>
                                        <h2 class="g-font-size-24--xs g-font-weight--700" style="color: #2d3748; line-height: 1.4; margin-top: 10px; margin-bottom: 5px;">{{ $agenda->title }}</h2>
                                        <p class="g-font-size-13--xs g-color--primary g-margin-b-0--xs"><i class="ti-angle-down"></i> Klik untuk info lengkap</p>
                                    </div>
                                    <div class="hidden-xs text-right" style="min-width: 120px;">
                                        <div style="background: #f8f9fa; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; display: inline-block; text-align: center;">
                                            <div style="font-size: 24px; font-weight: 700; color: #dc3545; line-height: 1;">{{ \Carbon\Carbon::parse($agenda->start_date)->format('d') }}</div>
                                            <div style="font-size: 13px; font-weight: 600; color: #4a5568; text-transform: uppercase;">{{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('M Y') }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="collapse" id="collapseAgenda{{ $agenda->id }}">
                                    <div class="g-bg-color--sky-light g-padding-x-20--xs g-padding-y-20--xs g-margin-b-20--xs g-margin-t-20--xs" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                                        <div class="row">
                                            <div class="col-sm-6 g-margin-b-15--xs">
                                                <strong class="g-color--dark g-font-size-14--xs" style="display: block; margin-bottom: 5px;"><i class="ti-calendar g-color--primary g-margin-r-5--xs"></i> Tanggal</strong>
                                                <span class="g-color--text g-font-size-14--xs">
                                                    {{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('d F Y') }}
                                                    @if($agenda->end_date && $agenda->end_date != $agenda->start_date)
                                                        - {{ \Carbon\Carbon::parse($agenda->end_date)->translatedFormat('d F Y') }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="col-sm-6 g-margin-b-15--xs">
                                                <strong class="g-color--dark g-font-size-14--xs" style="display: block; margin-bottom: 5px;"><i class="ti-time g-color--primary g-margin-r-5--xs"></i> Waktu</strong>
                                                <span class="g-color--text g-font-size-14--xs">
                                                    {{ $agenda->start_time ? \Carbon\Carbon::parse($agenda->start_time)->format('H:i') : 'TBA' }} 
                                                    @if($agenda->end_time) - {{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }} @endif
                                                    WIB
                                                </span>
                                            </div>
                                            <div class="col-sm-6 g-margin-b-15--xs g-margin-b-0--sm">
                                                <strong class="g-color--dark g-font-size-14--xs" style="display: block; margin-bottom: 5px;"><i class="ti-location-pin g-color--primary g-margin-r-5--xs"></i> Lokasi</strong>
                                                <span class="g-color--text g-font-size-14--xs">
                                                    {{ $agenda->location }}
                                                    @if($agenda->maps_link)
                                                        <br><a href="{{ $agenda->maps_link }}" target="_blank" class="g-color--primary g-font-size-13--xs" style="text-decoration: underline;">Buka di Google Maps</a>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong class="g-color--dark g-font-size-14--xs" style="display: block; margin-bottom: 5px;"><i class="ti-target g-color--primary g-margin-r-5--xs"></i> Sasaran Peserta</strong>
                                                <span class="g-color--text g-font-size-14--xs">{{ $agenda->audience ?? 'Umum' }}</span>
                                            </div>
                                        </div>
                                        <hr style="margin: 15px 0; border-top: 1px dashed #cbd5e0;">
                                        <div class="row">
                                            <div class="col-sm-6 g-margin-b-15--xs g-margin-b-0--sm">
                                                <strong class="g-color--dark g-font-size-14--xs" style="display: block; margin-bottom: 5px;"><i class="ti-user g-color--primary g-margin-r-5--xs"></i> Penyelenggara</strong>
                                                <span class="g-color--text g-font-size-14--xs">{{ $agenda->organizer ?? '-' }}</span>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong class="g-color--dark g-font-size-14--xs" style="display: block; margin-bottom: 5px;"><i class="ti-id-badge g-color--primary g-margin-r-5--xs"></i> Kontak Person</strong>
                                                <span class="g-color--text g-font-size-14--xs">{{ $agenda->contact_person ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="g-font-size-15--xs g-color--dark" style="line-height: 1.8; text-align: justify;">
                                        {!! $agenda->description !!}
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    
                    <!-- Bottom Pagination -->
                    <div class="g-margin-t-40--xs text-center custom-pagination" style="display: flex; justify-content: center;">
                        @if ($agendas->lastPage() > 1)
                            {{ $agendas->links('pagination::bootstrap-4') }}
                        @else
                            <ul class="pagination">
                                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                                <li class="page-item active"><span class="page-link">1</span></li>
                                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                            </ul>
                        @endif
                    </div>
                @else
                    <div class="text-center g-padding-y-60--xs g-bg-color--white" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                        <i class="ti-calendar g-font-size-40--xs g-color--primary g-margin-b-15--xs" style="display: block;"></i>
                        <h4 class="g-font-size-20--xs g-margin-b-10--xs" style="color: #2d3748;">Agenda Tidak Ditemukan</h4>
                        <p class="g-font-size-15--xs" style="color: #718096;">Belum ada agenda kegiatan atau tidak ada hasil yang sesuai dengan pencarian Anda.</p>
                        <a href="{{ route('agenda-kegiatan') }}" class="s-btn s-btn--xs s-btn--primary-bg g-margin-t-20--xs">Kembali ke Semua Agenda</a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            @include('user.agenda.sidebar')
        </div>
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection
