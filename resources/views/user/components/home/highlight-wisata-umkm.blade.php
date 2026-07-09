<div class="g-bg-color--sky-light g-padding-y-80--xs g-padding-y-125--sm">
    <style>
        .wisata-card {
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .wisata-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
        .wisata-card-img {
            transition: transform 0.5s ease;
        }
        .wisata-card:hover .wisata-card-img {
            transform: scale(1.1);
        }
        .wisata-img-wrapper {
            overflow: hidden;
            width: 100%;
            height: 220px;
        }
        .row-flex {
            display: flex;
            flex-wrap: wrap;
        }
    </style>
    <div class="container">
        <!-- Highlight Wisata -->
        <div class="g-text-center--xs g-margin-b-40--xs">
            <h2 class="g-font-size-26--xs g-font-size-36--sm g-font-weight--700">Tempat Wisata</h2>
            <p class="g-font-size-16--xs g-color--dark">Jelajahi keindahan destinasi wisata di Desa Tulungrejo.</p>
        </div>
        <div class="row row-flex g-margin-b-60--xs">
            @forelse($wisata as $w)
            <div class="col-sm-4 g-margin-b-30--xs g-margin-b-0--md" style="display: flex; padding-bottom: 30px;">
                <article class="g-bg-color--white wisata-card" style="border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); width: 100%;">
                    <div class="wisata-img-wrapper">
                        <img class="img-responsive wisata-card-img" src="{{ $w->thumbnail() ? asset('storage/'.$w->thumbnail()->image_path) : asset('images/default-image.png') }}" alt="{{ $w->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="g-padding-x-30--xs g-padding-y-30--xs" style="flex-grow: 1; display: flex; flex-direction: column;">
                        <h3 class="g-font-size-20--xs g-margin-b-10--xs"><a href="{{ route('pariwisata.show', $w->slug) }}" class="g-color--dark g-color--primary--hover" style="text-decoration: none;">{{ $w->name }}</a></h3>
                        <p class="g-font-size-14--xs g-color--dark" style="flex-grow: 1;">{{ Str::limit($w->description, 80) }}</p>
                        <div style="margin-top: 20px;">
                            <a href="{{ route('pariwisata.show', $w->slug) }}" class="text-uppercase s-btn s-btn--xs s-btn--primary-bg g-radius--50 g-padding-x-20--xs g-color--white" style="display: inline-flex; align-items: center;">Lihat Detail <i class="ti-arrow-right g-margin-l-10--xs"></i></a>
                        </div>
                    </div>
                </article>
            </div>
            @empty
            <div class="col-sm-12 text-center"><p>Belum ada data wisata.</p></div>
            @endforelse
            <div class="col-xs-12 text-center g-margin-t-20--xs">
                <a href="{{ route('pariwisata') }}" class="text-uppercase s-btn s-btn--md s-btn--primary-brd g-radius--50">Lihat Semua Wisata</a>
            </div>
        </div>

        <!-- Highlight UMKM -->
        <div class="g-text-center--xs g-margin-b-40--xs">
            <h2 class="g-font-size-26--xs g-font-size-36--sm g-font-weight--700">Produk Unggulan UMKM</h2>
            <p class="g-font-size-16--xs g-color--dark">Dukung ekonomi kreatif masyarakat desa.</p>
        </div>
        <div class="row row-flex">
            @forelse($umkm as $u)
            <div class="col-sm-4 g-margin-b-30--xs g-margin-b-0--md" style="display: flex; padding-bottom: 30px;">
                <article class="g-bg-color--white wisata-card" style="border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); width: 100%;">
                    <div class="wisata-img-wrapper">
                        <img class="img-responsive wisata-card-img" src="{{ $u->thumbnail() ? asset('storage/'.$u->thumbnail()->image_path) : asset('images/default-image.png') }}" alt="{{ $u->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="g-padding-x-30--xs g-padding-y-30--xs" style="flex-grow: 1; display: flex; flex-direction: column;">
                        <h3 class="g-font-size-20--xs g-margin-b-10--xs"><a href="{{ route('umkm.show', $u->slug) }}" class="g-color--dark g-color--primary--hover" style="text-decoration: none;">{{ $u->name }}</a></h3>
                        <p class="g-font-size-14--xs g-color--dark" style="flex-grow: 1;">{{ Str::limit($u->description, 80) }}</p>
                        <div style="margin-top: 20px;">
                            <a href="{{ route('umkm.show', $u->slug) }}" class="text-uppercase s-btn s-btn--xs s-btn--primary-bg g-radius--50 g-padding-x-20--xs g-color--white" style="display: inline-flex; align-items: center;">Lihat Detail <i class="ti-arrow-right g-margin-l-10--xs"></i></a>
                        </div>
                    </div>
                </article>
            </div>
            @empty
            <div class="col-sm-12 text-center"><p>Belum ada data UMKM.</p></div>
            @endforelse
            <div class="col-xs-12 text-center g-margin-t-20--xs">
                <a href="{{ route('umkm') }}" class="text-uppercase s-btn s-btn--md s-btn--primary-brd g-radius--50">Lihat Semua UMKM</a>
            </div>
        </div>
    </div>
</div>
