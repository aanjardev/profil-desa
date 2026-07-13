<div style="background-color:#ffffff; border-top: 1px solid #ebebeb;" class="g-padding-y-80--xs g-padding-y-125--sm">
    <style>
        .agenda-card {
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border-left: 4px solid #f0f0f0;
        }
        .agenda-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
            border-left-color: #d20505;
        }
        .row-flex {
            display: flex;
            flex-wrap: wrap;
        }
        @media (max-width: 767px) {
            .agenda-empty-card {
                display: none !important;
            }
        }
    </style>
    <div class="container">
        <div class="g-text-center--xs g-margin-b-60--xs">
            <h2 class="g-font-size-26--xs g-font-size-36--sm g-font-weight--700">Agenda Kegiatan</h2>
            <span class="section-title-divider"></span>
            <p class="g-font-size-16--xs g-color--dark">Jangan lewatkan berbagai kegiatan menarik di Desa Tulungrejo.</p>
        </div>
        <div class="row row-flex">
            @forelse($agendas as $agenda)
            <div class="col-sm-4 g-margin-b-30--xs g-margin-b-0--md" style="display: flex; padding-bottom: 30px;">
                <article class="g-bg-color--white g-padding-x-30--xs g-padding-y-30--xs agenda-card" style="border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); width: 100%;">
                    <div class="g-margin-b-20--xs" style="display: flex; align-items: center;">
                        <div class="g-padding-x-15--xs g-padding-y-10--xs g-text-center--xs" style="border-radius: 8px; background-color: rgba(0,0,0,0.03);">
                            <span class="g-font-size-30--xs g-font-weight--700 g-color--primary block" style="line-height: 1;">{{ \Carbon\Carbon::parse($agenda->start_date)->format('d') }}</span>
                            <span class="g-font-size-12--xs g-color--dark text-uppercase g-font-weight--600 block" style="line-height: 1; margin-top: 5px;">{{ \Carbon\Carbon::parse($agenda->start_date)->translatedFormat('M Y') }}</span>
                        </div>
                    </div>
                    <h3 class="g-font-size-20--xs g-margin-b-10--xs"><a href="#" class="g-color--dark g-color--primary--hover" style="text-decoration: none;">{{ $agenda->title }}</a></h3>
                    <p class="g-font-size-14--xs g-color--dark g-margin-b-15--xs"><i class="ti-location-pin g-color--primary g-margin-r-5--xs"></i> {{ $agenda->location }}</p>
                    <p class="g-font-size-14--xs g-color--dark" style="flex-grow: 1;">{{ Str::limit($agenda->description, 80) }}</p>
                    <div style="margin-top: 15px;">
                         <a href="#" class="g-font-size-13--xs g-font-weight--600 g-color--primary g-color--dark--hover" style="text-decoration: none; display: inline-flex; align-items: center;">Detail Agenda <i class="ti-arrow-right g-margin-l-5--xs"></i></a>
                    </div>
                </article>
            </div>
            @empty
            <div class="col-xs-12">
                <div class="g-bg-color--white g-padding-y-50--xs g-padding-x-30--xs g-text-center--xs" style="border-radius: 12px; border: 2px dashed #dcdcdc; box-shadow: 0 5px 20px rgba(0,0,0,0.03);">
                    <i class="ti-calendar g-font-size-40--xs g-color--primary g-margin-b-20--xs block" style="opacity: 0.7;"></i>
                    <h4 class="g-font-size-18--xs g-color--dark g-font-weight--600">Agenda Masih Kosong</h4>
                    <p class="g-color--dark g-margin-b-0--xs">Saat ini belum ada agenda kegiatan desa yang dijadwalkan dalam waktu dekat.</p>
                </div>
            </div>
            @endforelse
            @if($agendas->count() > 0 && $agendas->count() < 3)
                @for($i = $agendas->count(); $i < 3; $i++)
                <div class="col-sm-4 g-margin-b-30--xs g-margin-b-0--md agenda-empty-card hidden-xs" style="display: flex; padding-bottom: 30px;">
                    <article class="g-bg-color--white g-padding-x-30--xs g-padding-y-30--xs" style="border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); width: 100%; border: 2px dashed #e2e2e2; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
                        <i class="ti-calendar g-font-size-30--xs g-color--primary g-margin-b-15--xs block" style="opacity: 0.4;"></i>
                        <h4 class="g-font-size-16--xs g-color--dark g-font-weight--600">Jadwal Kosong</h4>
                        <p class="g-font-size-13--xs g-color--dark g-margin-b-0--xs" style="opacity: 0.6;">Belum ada agenda tambahan untuk saat ini.</p>
                    </article>
                </div>
                @endfor
            @endif
            <div class="col-xs-12 text-center g-margin-t-30--xs">
                <a href="{{ route('agenda-kegiatan') }}" class="text-uppercase s-btn s-btn--md s-btn--primary-brd g-radius--50">Semua Agenda</a>
            </div>
        </div>
    </div>
</div>
