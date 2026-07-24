@extends('layouts.user')

@section('title', 'Monografi Desa')

@section('content')
<!--========== PARALLAX HEADER ==========-->
<div class="g-padding-y-80--xs" style="background-image: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-top: 130px !important;">
    <!-- Dark Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(26, 32, 44, 0.85); z-index: 1;"></div>
    
    <div class="container text-center" style="position: relative; z-index: 2;">
        <h1 class="g-font-size-32--xs g-font-size-40--sm g-font-weight--700 g-color--white g-margin-b-10--xs">Monografi Desa</h1>
        <p class="g-font-size-16--xs g-color--white-opacity" style="max-width: 600px; margin: 0 auto;">Data statistik kependudukan dan informasi umum wilayah desa.</p>
    </div>
</div>
<!--========== END PARALLAX HEADER ==========-->

<!--========== PAGE CONTENT ==========-->
<div class="g-bg-color--sky-light g-padding-y-60--xs">
    <div class="container">
        
        <!-- Demografi Content -->
        @if(isset($demografi) && $demografi->content)
        <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 40px; border: 1px solid #e2e8f0; margin-bottom: 40px;">
            <h2 class="g-font-size-24--xs g-font-weight--700 g-margin-b-20--xs" style="color: #2d3748;">
                <span style="display: inline-block; width: 4px; height: 24px; background: #dc3545; vertical-align: middle; margin-right: 10px; border-radius: 4px;"></span>
                {{ $demografi->title ?? 'Demografi Penduduk' }}
            </h2>
            
            @if($demografi->image_path)
                <div class="g-margin-b-25--xs">
                    <img src="{{ asset('storage/'.$demografi->image_path) }}" alt="{{ $demografi->title }}" class="img-responsive" style="border-radius: 12px; width: 100%; max-height: 400px; object-fit: cover;">
                </div>
            @endif
            
            <div class="g-font-size-15--xs" style="line-height: 1.8; color: #4a5568;">
                {!! nl2br(e($demografi->content)) !!}
            </div>
        </div>
        @endif

        <!-- Highlight Statistics -->
        @if($statistics->count() > 0)
        <div class="row g-margin-b-40--xs">
            @foreach($statistics as $stat)
                @php
                    $icon = $stat->icon ?: 'ti-bar-chart';
                    $suffix = '';
                    if ($stat->key === 'luas_wilayah') {
                        $icon = 'ti-map-alt';
                        $suffix = ' ha';
                    } elseif ($stat->key === 'jumlah_penduduk') {
                        $icon = 'ti-user';
                        $suffix = ' penduduk';
                    } elseif ($stat->key === 'jumlah_rt_rw') {
                        $icon = 'ti-home';
                        $suffix = ' RT/RW';
                    }
                @endphp
            <div class="col-sm-6 col-md-4 g-margin-b-30--xs">
                <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 30px 20px; border: 1px solid #e2e8f0; text-align: center; height: 100%; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="g-margin-b-15--xs">
                        <i class="{{ $icon }} g-color--primary" style="font-size: 40px; display: inline-block; padding: 15px; background: rgba(220, 53, 69, 0.1); border-radius: 50%;"></i>
                    </div>
                    <h3 class="g-font-size-28--xs g-font-weight--700 g-color--dark g-margin-b-5--xs">{{ $stat->value }}{{ $suffix }}</h3>
                    <p class="g-font-size-14--xs g-font-weight--600" style="color: #718096; margin-bottom: 0;">{{ $stat->label }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Demografi Penduduk per RT/RW -->
        @if($rtRws->count() > 0)
        <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 40px; border: 1px solid #e2e8f0;">
            <div class="text-center g-margin-b-30--xs">
                <h2 class="g-font-size-24--xs g-font-weight--700 g-margin-b-10--xs" style="color: #2d3748;">Data Kependudukan per Wilayah</h2>
                <p class="g-font-size-15--xs" style="color: #718096;">Sebaran jumlah penduduk dan Kepala Keluarga di masing-masing RT dan RW.</p>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center" style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; margin-bottom: 0;">
                    <thead class="g-bg-color--dark g-color--white">
                        <tr>
                            <th style="padding: 15px; vertical-align: middle; width: 15%; text-align: center;">RW</th>
                            <th style="padding: 15px; vertical-align: middle; width: 15%; text-align: center;">RT</th>
                            <th style="padding: 15px; vertical-align: middle; width: 20%; text-align: center;">Ketua Lingkungan</th>
                            <th style="padding: 15px; vertical-align: middle; width: 15%; text-align: center;">Jumlah KK</th>
                            <th style="padding: 15px; vertical-align: middle; width: 10%; text-align: center;">Laki-laki</th>
                            <th style="padding: 15px; vertical-align: middle; width: 10%; text-align: center;">Perempuan</th>
                            <th style="padding: 15px; vertical-align: middle; width: 15%; text-align: center;">Total Penduduk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalKk = 0;
                            $totalMale = 0;
                            $totalFemale = 0;
                        @endphp
                        
                        @foreach($rtRws as $data)
                            @php
                                // We sum up the totals here (you might want to exclude RW summary rows from total if they are duplicate data)
                                // Assuming each row in the DB is an independent block of data, if it's an RT row it has rt_number
                                // If it's just an RW row, we check if we should sum it or not. Usually we sum all RTs.
                                // Let's sum only if it's an RT, or if it's an RW and there are no RTs. 
                                // For simplicity, we just sum them as provided in DB. Let's assume all rows are mutually exclusive areas.
                                $totalKk += $data->total_kk;
                                $totalMale += $data->total_male;
                                $totalFemale += $data->total_female;
                            @endphp
                            <tr style="{{ $data->is_rw ? 'background-color: #f8f9fa; font-weight: bold;' : '' }}">
                                <td style="padding: 12px; vertical-align: middle;">{{ str_pad($data->rw_number, 2, '0', STR_PAD_LEFT) }}</td>
                                <td style="padding: 12px; vertical-align: middle;">{{ $data->rt_number ? str_pad($data->rt_number, 2, '0', STR_PAD_LEFT) : '-' }}</td>
                                <td style="padding: 12px; vertical-align: middle;">
                                    {{ $data->head_name ?? '-' }}
                                    @if($data->is_rw)
                                        <br><span style="font-size: 11px; color: #dc3545; font-weight: 600;">(Ketua RW)</span>
                                    @elseif($data->rt_number)
                                        <br><span style="font-size: 11px; color: #718096;">(Ketua RT)</span>
                                    @endif
                                </td>
                                <td style="padding: 12px; vertical-align: middle;">{{ number_format($data->total_kk, 0, ',', '.') }}</td>
                                <td style="padding: 12px; vertical-align: middle;">{{ number_format($data->total_male, 0, ',', '.') }}</td>
                                <td style="padding: 12px; vertical-align: middle;">{{ number_format($data->total_female, 0, ',', '.') }}</td>
                                <td style="padding: 12px; vertical-align: middle; font-weight: 700; color: #2d3748;">{{ number_format($data->total_penduduk, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="g-bg-color--primary-opacity-lightest">
                        <tr>
                            <td colspan="3" style="padding: 15px; font-weight: 700; text-align: right; color: #2d3748;">TOTAL KESELURUHAN</td>
                            <td style="padding: 15px; font-weight: 700; color: #dc3545;">{{ number_format($totalKk, 0, ',', '.') }}</td>
                            <td style="padding: 15px; font-weight: 700; color: #dc3545;">{{ number_format($totalMale, 0, ',', '.') }}</td>
                            <td style="padding: 15px; font-weight: 700; color: #dc3545;">{{ number_format($totalFemale, 0, ',', '.') }}</td>
                            <td style="padding: 15px; font-weight: 700; color: #dc3545; font-size: 16px;">{{ number_format($totalMale + $totalFemale, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @endif

        @if($statistics->isEmpty() && $rtRws->isEmpty())
        <div class="text-center g-padding-y-60--xs g-bg-color--white" style="border-radius: 12px; border: 1px solid #e2e8f0;">
            <i class="ti-bar-chart-alt g-font-size-40--xs g-color--primary g-margin-b-15--xs" style="display: block;"></i>
            <h4 class="g-font-size-20--xs g-margin-b-10--xs" style="color: #2d3748;">Data Monografi Belum Tersedia</h4>
            <p class="g-font-size-15--xs" style="color: #718096; margin-bottom: 0;">Data statistik kependudukan sedang dalam proses pembaruan.</p>
        </div>
        @endif

    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection
