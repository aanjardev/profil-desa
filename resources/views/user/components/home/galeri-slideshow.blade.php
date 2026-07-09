<div class="g-bg-color--sky-light g-padding-y-80--xs g-padding-y-125--sm">
    <div class="container">
        <div class="g-text-center--xs g-margin-b-60--xs">
            <h2 class="g-font-size-26--xs g-font-size-36--sm g-font-weight--700">Galeri Foto</h2>
            <p class="g-font-size-16--xs g-color--dark">Momen dan pesona Desa Tulungrejo.</p>
        </div>
        <div class="row">
            @forelse($galleries as $gallery)
            <div class="col-sm-4 col-xs-6 g-margin-b-30--xs">
                <a href="{{ $gallery->image_path ? asset('storage/'.$gallery->image_path) : asset('images/default-image.png') }}" title="{{ $gallery->title }}" style="display:block; overflow:hidden; border-radius:8px;">
                    <img class="img-responsive" src="{{ $gallery->image_path ? asset('storage/'.$gallery->image_path) : asset('images/default-image.png') }}" alt="{{ $gallery->title }}" style="width: 100%; height: 250px; object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                </a>
            </div>
            @empty
            <div class="col-xs-12 text-center"><p>Belum ada foto di galeri.</p></div>
            @endforelse
            <div class="col-xs-12 text-center g-margin-t-30--xs">
                <a href="{{ route('galeri') }}" class="text-uppercase s-btn s-btn--md s-btn--primary-brd g-radius--50">Lihat Semua Foto</a>
            </div>
        </div>
    </div>
</div>
