<div class="g-bg-color--white g-padding-y-80--xs g-padding-y-125--sm">
    <div class="container">
        <div class="g-text-center--xs g-margin-b-60--xs">
            <h2 class="g-font-size-26--xs g-font-size-36--sm g-font-weight--700">Agenda Kegiatan</h2>
            <p class="g-font-size-16--xs g-color--dark">Jangan lewatkan berbagai kegiatan menarik di Desa Tulungrejo.</p>
        </div>
        <div class="row">
            @forelse($agendas as $agenda)
            <div class="col-sm-4 g-margin-b-30--xs g-margin-b-0--md">
                <article class="g-bg-color--dark-light g-padding-x-30--xs g-padding-y-30--xs" style="border-radius: 8px;">
                    <div class="g-margin-b-20--xs">
                        <span class="g-font-size-30--xs g-font-weight--700 g-color--primary">{{ \Carbon\Carbon::parse($agenda->start_date)->format('d') }}</span>
                        <span class="g-font-size-16--xs g-color--dark text-uppercase" style="margin-left: 5px;">{{ \Carbon\Carbon::parse($agenda->start_date)->format('M Y') }}</span>
                    </div>
                    <h3 class="g-font-size-20--xs g-margin-b-10--xs"><a href="#">{{ $agenda->title }}</a></h3>
                    <p class="g-color--dark g-margin-b-20--xs"><i class="ti-location-pin g-color--primary g-margin-r-5--xs"></i> {{ $agenda->location }}</p>
                    <p class="g-font-size-14--xs g-color--dark">{{ Str::limit($agenda->description, 60) }}</p>
                </article>
            </div>
            @empty
            <div class="col-xs-12 text-center"><p>Belum ada agenda terdekat.</p></div>
            @endforelse
            <div class="col-xs-12 text-center g-margin-t-30--xs">
                <a href="{{ route('agenda-kegiatan') }}" class="text-uppercase s-btn s-btn--md s-btn--primary-brd g-radius--50">Semua Agenda</a>
            </div>
        </div>
    </div>
</div>
