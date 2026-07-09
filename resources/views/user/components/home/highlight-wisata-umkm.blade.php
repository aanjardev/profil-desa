<div class="g-bg-color--sky-light g-padding-y-80--xs g-padding-y-125--sm">
    <div class="container">
        <!-- Highlight Wisata -->
        <div class="g-text-center--xs g-margin-b-40--xs">
            <h2 class="g-font-size-26--xs g-font-size-36--sm g-font-weight--700">Highlight Wisata</h2>
            <p class="g-font-size-16--xs g-color--dark">Jelajahi keindahan destinasi wisata di Desa Tulungrejo.</p>
        </div>
        <div class="row g-margin-b-60--xs">
            @forelse($wisata as $w)
            <div class="col-sm-4 g-margin-b-30--xs g-margin-b-0--md">
                <article class="g-bg-color--white" style="border-radius: 8px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                    <img class="img-responsive" src="{{ $w->thumbnail() ? asset('storage/'.$w->thumbnail()->image_path) : asset('images/default-image.png') }}" alt="{{ $w->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                    <div class="g-padding-x-30--xs g-padding-y-30--xs">
                        <h3 class="g-font-size-20--xs"><a href="#">{{ $w->name }}</a></h3>
                        <p class="g-font-size-14--xs g-color--dark">{{ Str::limit($w->description, 80) }}</p>
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
        <div class="row">
            @forelse($umkm as $u)
            <div class="col-sm-4 g-margin-b-30--xs g-margin-b-0--md">
                <article class="g-bg-color--white" style="border-radius: 8px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                    <img class="img-responsive" src="{{ $u->thumbnail() ? asset('storage/'.$u->thumbnail()->image_path) : asset('images/default-image.png') }}" alt="{{ $u->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                    <div class="g-padding-x-30--xs g-padding-y-30--xs">
                        <h3 class="g-font-size-20--xs"><a href="#">{{ $u->name }}</a></h3>
                        <p class="g-font-size-14--xs g-color--dark">{{ Str::limit($u->description, 80) }}</p>
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
