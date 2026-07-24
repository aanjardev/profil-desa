@extends('layouts.user')

@section('title', 'Data Penduduk')

@section('content')
<!--========== PARALLAX HEADER ==========-->
<div class="g-padding-y-80--xs" style="background-image: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-top: 130px !important;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(26, 32, 44, 0.85); z-index: 1;"></div>
    <div class="container text-center" style="position: relative; z-index: 2;">
        <h1 class="g-font-size-32--xs g-font-size-40--sm g-font-weight--700 g-color--white g-margin-b-10--xs">Data Penduduk</h1>
        <p class="g-font-size-16--xs g-color--white-opacity" style="max-width: 600px; margin: 0 auto;">Informasi statistik penduduk desa berdasarkan Rukun Warga (RW) dan Rukun Tetangga (RT).</p>
    </div>
</div>
<!--========== END PARALLAX HEADER ==========-->

<!--========== PAGE CONTENT ==========-->
<div class="g-bg-color--sky-light g-padding-y-60--xs">
    <div class="container">
        
        <!-- Summary Cards -->
        <div class="row g-margin-b-40--xs">
            <div class="col-sm-3 col-xs-6 g-margin-b-20--xs g-margin-b-0--sm">
                <div style="background: #fff; border-radius: 12px; padding: 25px 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; height: 100%;">
                    <i class="ti-user g-font-size-30--xs" style="color: #4299e1; margin-bottom: 15px; display: block;"></i>
                    <h3 style="font-size: 28px; font-weight: 700; color: #2d3748; margin-bottom: 5px;">{{ number_format($totalDesaMale, 0, ',', '.') }}</h3>
                    <p style="font-size: 13px; color: #718096; margin: 0; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Laki-laki</p>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6 g-margin-b-20--xs g-margin-b-0--sm">
                <div style="background: #fff; border-radius: 12px; padding: 25px 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; height: 100%;">
                    <i class="ti-user g-font-size-30--xs" style="color: #ed64a6; margin-bottom: 15px; display: block;"></i>
                    <h3 style="font-size: 28px; font-weight: 700; color: #2d3748; margin-bottom: 5px;">{{ number_format($totalDesaFemale, 0, ',', '.') }}</h3>
                    <p style="font-size: 13px; color: #718096; margin: 0; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Perempuan</p>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6 g-margin-b-20--xs g-margin-b-0--sm">
                <div style="background: #fff; border-radius: 12px; padding: 25px 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; height: 100%;">
                    <i class="ti-id-badge g-font-size-30--xs" style="color: #48bb78; margin-bottom: 15px; display: block;"></i>
                    <h3 style="font-size: 28px; font-weight: 700; color: #2d3748; margin-bottom: 5px;">{{ number_format($totalDesaKk, 0, ',', '.') }}</h3>
                    <p style="font-size: 13px; color: #718096; margin: 0; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Total KK</p>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <div style="background: #2d3748; border-radius: 12px; padding: 25px 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1); height: 100%;">
                    <i class="ti-pie-chart g-font-size-30--xs" style="color: #cbd5e0; margin-bottom: 15px; display: block;"></i>
                    <h3 style="font-size: 28px; font-weight: 700; color: #fff; margin-bottom: 5px;">{{ number_format($totalDesaPenduduk, 0, ',', '.') }}</h3>
                    <p style="font-size: 13px; color: #a0aec0; margin: 0; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Total Penduduk</p>
                </div>
            </div>
        </div>

        @forelse($groupedData as $dusunName => $rwGroup)
            <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 30px; border: 1px solid #e2e8f0; margin-bottom: 30px;">
                <h2 class="g-font-size-24--xs g-font-weight--700 g-color--dark g-margin-b-20--xs">
                    <span style="display: inline-block; padding: 5px 15px; background: #ebf4ff; color: #3182ce; border-radius: 8px; margin-right: 10px; font-size: 18px;">
                        <i class="ti-location-pin"></i> Dusun: {{ $dusunName }}
                    </span>
                    Statistik Kependudukan
                </h2>

                <div class="table-responsive">
                    <table class="table table-hover table-striped" style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; margin-bottom: 0;">
                        <thead class="g-bg-color--dark g-color--white">
                            <tr>
                                <th style="padding: 15px; border-bottom: none; width: 15%;">RT / RW</th>
                                @if($hasHeadName)
                                <th style="padding: 15px; border-bottom: none; width: 25%;">Ketua</th>
                                @endif
                                <th style="padding: 15px; border-bottom: none; width: 15%; text-align: center;">Laki-laki</th>
                                <th style="padding: 15px; border-bottom: none; width: 15%; text-align: center;">Perempuan</th>
                                <th style="padding: 15px; border-bottom: none; width: 15%; text-align: center;">Total Penduduk</th>
                                <th style="padding: 15px; border-bottom: none; width: 15%; text-align: center;">Jumlah KK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rwGroup as $rw => $rtList)
                                <!-- Header per RW -->
                                <tr style="background-color: #f7fafc; border-top: 2px solid #e2e8f0;">
                                    <td colspan="{{ $hasHeadName ? 6 : 5 }}" style="padding: 10px 15px; font-weight: 700; color: #4a5568;">
                                        <i class="ti-map-alt g-margin-r-5--xs"></i> RW {{ $rw }}
                                    </td>
                                </tr>
                                
                                @foreach($rtList as $item)
                                <tr>
                                    <td style="padding: 15px; vertical-align: middle; font-weight: 700; padding-left: 30px;">
                                        @if($item->rt_number)
                                            RT {{ $item->rt_number }}
                                        @else
                                            <span style="color: #3182ce;">Tingkat RW</span>
                                        @endif
                                    </td>
                                    @if($hasHeadName)
                                    <td style="padding: 15px; vertical-align: middle;">
                                        <strong>{{ $item->head_name ?: '-' }}</strong>
                                        @if($item->head_phone)
                                            <div style="font-size: 12px; color: #718096;"><i class="ti-mobile"></i> {{ $item->head_phone }}</div>
                                        @endif
                                    </td>
                                    @endif
                                    <td style="padding: 15px; vertical-align: middle; text-align: center; color: #4299e1; font-weight: 600;">
                                        {{ number_format($item->total_male, 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; text-align: center; color: #ed64a6; font-weight: 600;">
                                        {{ number_format($item->total_female, 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; text-align: center; font-weight: 700; background-color: #f7fafc;">
                                        {{ number_format($item->total_penduduk, 0, ',', '.') }}
                                    </td>
                                    <td style="padding: 15px; vertical-align: middle; text-align: center; color: #48bb78; font-weight: 600;">
                                        {{ number_format($item->total_kk, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                                
                                <!-- Subtotal for this RW -->
                                <tr style="background-color: #edf2f7; font-weight: 700;">
                                    <td @if($hasHeadName) colspan="2" @endif style="padding: 15px; text-align: right; color: #2d3748; padding-right: 20px;">Subtotal RW {{ $rw }} :</td>
                                    <td style="padding: 15px; text-align: center; color: #2b6cb0;">{{ number_format($rtList->sum('total_male'), 0, ',', '.') }}</td>
                                    <td style="padding: 15px; text-align: center; color: #b83280;">{{ number_format($rtList->sum('total_female'), 0, ',', '.') }}</td>
                                    <td style="padding: 15px; text-align: center; color: #2d3748;">{{ number_format($rtList->sum(function($q){ return $q->total_male + $q->total_female; }), 0, ',', '.') }}</td>
                                    <td style="padding: 15px; text-align: center; color: #276749;">{{ number_format($rtList->sum('total_kk'), 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            
                            @php
                                $dusunTotalMale = 0;
                                $dusunTotalFemale = 0;
                                $dusunTotalKk = 0;
                                foreach($rwGroup as $r) {
                                    $dusunTotalMale += $r->sum('total_male');
                                    $dusunTotalFemale += $r->sum('total_female');
                                    $dusunTotalKk += $r->sum('total_kk');
                                }
                                $dusunTotalPenduduk = $dusunTotalMale + $dusunTotalFemale;
                            @endphp
                            
                            <!-- Total for this Dusun -->
                            <tr style="background-color: #e2e8f0; font-weight: 700;">
                                <td @if($hasHeadName) colspan="2" @endif style="padding: 15px; text-align: right; color: #1a202c; font-size: 16px;">Total {{ $dusunName }} :</td>
                                <td style="padding: 15px; text-align: center; color: #2b6cb0; font-size: 16px;">{{ number_format($dusunTotalMale, 0, ',', '.') }}</td>
                                <td style="padding: 15px; text-align: center; color: #b83280; font-size: 16px;">{{ number_format($dusunTotalFemale, 0, ',', '.') }}</td>
                                <td style="padding: 15px; text-align: center; color: #1a202c; font-size: 16px;">{{ number_format($dusunTotalPenduduk, 0, ',', '.') }}</td>
                                <td style="padding: 15px; text-align: center; color: #22543d; font-size: 16px;">{{ number_format($dusunTotalKk, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="text-center g-padding-y-40--xs" style="background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <i class="ti-face-sad g-font-size-40--xs g-color--primary g-margin-b-15--xs" style="display: block;"></i>
                <h4 class="g-font-size-18--xs g-font-weight--700 g-color--dark">Data Penduduk Belum Tersedia</h4>
                <p class="g-font-size-14--xs g-color--text">Belum ada data kependudukan RT/RW yang ditambahkan.</p>
            </div>
        @endforelse

    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection
