<div class="g-bg-color--white g-padding-y-80--xs g-padding-y-125--sm">
    <style>
        .berita-title-hover {
            transition: all 0.3s ease;
        }
        .berita-title-hover:hover {
            text-decoration: underline !important;
            color: #d20505ff !important;
        }
    </style>
    <div class="container">
        <div class="g-text-center--xs g-margin-b-60--xs">
            <h2 class="g-font-size-32--xs g-font-size-36--md g-font-weight--700">Berita Terbaru</h2>
            <p class="g-color--dark g-font-size-16--xs">Kabar dan kegiatan terbaru dari Desa Tulungrejo.</p>
        </div>
        
        <div class="row">
            @if($berita->count() > 0)
                <!-- Slider Berita Highlight (Kiri) -->
                <div class="col-md-7 g-margin-b-40--xs g-margin-b-0--md">
                    <div class="swiper-container js__swiper-berita-home" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                        <div class="swiper-wrapper">
                            @foreach($berita->take(3) as $utama)
                            <div class="swiper-slide">
                                <article style="position: relative; width: 100%; aspect-ratio: 16/9; display: flex; align-items: flex-end;">
                                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                        <img src="{{ $utama->image ? asset('storage/'.$utama->image) : asset('images/default-image.png') }}" alt="{{ $utama->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <!-- Gradient Overlay -->
                                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0) 100%); pointer-events: none;"></div>
                                    
                                    <!-- Tombol Baca Berita -->
                                    <div style="position: absolute; top: 20px; right: 20px; z-index: 3;">
                                        <a href="{{ route('berita-desa.show', $utama->slug) }}" class="text-uppercase s-btn s-btn--xs s-btn--primary-brd g-radius--50 g-padding-x-30--xs g-color--white" style="background: rgba(0,0,0,0.4); backdrop-filter: blur(5px);">Baca Berita</a>
                                    </div>
                                    
                                    <!-- Konten Text -->
                                    <div style="position: relative; z-index: 2; width: 100%; padding: 30px; padding-bottom: 40px;">
                                        <div class="g-margin-b-10--xs">
                                            <span class="g-bg-color--primary g-color--white g-font-size-11--xs g-font-weight--700 text-uppercase g-padding-x-10--xs g-padding-y-5--xs g-radius--50 g-margin-r-10--xs" style="display: inline-block;">{{ $utama->category ?? 'Umum' }}</span>
                                            <span class="g-font-size-13--xs g-color--white-opacity g-font-weight--600 g-margin-r-15--xs"><i class="ti-time g-margin-r-5--xs"></i> {{ $utama->created_at->translatedFormat('d F Y') }}</span>
                                            <span class="g-font-size-13--xs g-color--white-opacity g-font-weight--600"><i class="ti-eye g-margin-r-5--xs"></i> {{ $utama->views ?? 0 }} Tayangan</span>
                                        </div>
                                        <h3 class="g-font-size-22--xs g-font-size-28--md g-font-weight--700 g-margin-b-10--xs">
                                            <a href="{{ route('berita-desa.show', $utama->slug) }}" class="g-color--white g-color--primary--hover berita-title-hover" style="text-decoration: none; line-height: 1.3;">{{ $utama->title }}</a>
                                        </h3>
                                        <p class="g-font-size-14--xs g-color--white-opacity g-margin-b-0--xs" style="margin-bottom: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-align: justify;">{{ Str::limit(strip_tags($utama->excerpt ?? $utama->content), 200) }}</p>
                                    </div>
                                </article>
                            </div>
                            @endforeach
                        </div>
                        <!-- Swiper Pagination -->
                        <div class="swiper-pagination swiper-berita-pagination" style="bottom: 10px;"></div>
                    </div>
                </div>

                <!-- Daftar Berita Samping (Kanan) -->
                <div class="col-md-5">
                    <div style="display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                        @foreach($berita->skip(3)->take(4) as $post)
                            <article class="clearfix g-bg-color--white g-margin-b-15--xs" style="border-radius: 8px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,0.06); display: flex; align-items: center;">
                                <div style="flex: 0 0 200px; aspect-ratio: 16/9; overflow: hidden; padding: 10px;">
                                    <img src="{{ $post->image ? asset('storage/'.$post->image) : asset('images/default-image.png') }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                                </div>
                                <div style="flex: 1; padding: 15px 25px 15px 5px;">
                                    <div class="g-margin-b-5--xs">
                                        <span class="g-font-size-11--xs g-color--primary g-font-weight--600 g-margin-r-10--xs"><i class="ti-tag g-margin-r-5--xs"></i>{{ $post->category ?? 'Umum' }}</span>
                                        <span class="g-font-size-11--xs" style="color: #a0aec0;"><i class="ti-time g-margin-r-5--xs"></i>{{ $post->created_at->format('d M Y') }}</span>
                                    </div>
                                    <h3 class="g-font-size-15--xs g-font-weight--700 g-margin-b-5--xs" style="line-height: 1.4;">
                                        <a href="{{ route('berita-desa.show', $post->slug) }}" class="g-color--dark g-color--primary--hover berita-title-hover" style="text-decoration: none;">{{ $post->title }}</a>
                                    </h3>
                                    <p class="g-font-size-12--xs g-color--dark g-margin-b-0--xs hidden-xs" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-align: justify;">{{ Str::limit(strip_tags($post->excerpt ?? $post->content), 120) }}</p>
                                </div>
                            </article>
                        @endforeach

                        @if($berita->count() > 3)
                        <div class="text-right" style="margin-top: 5px;">
                            <a href="{{ route('berita-desa') }}" class="g-font-size-14--xs g-font-weight--600 g-color--primary g-color--dark--hover" style="text-decoration: none; border-bottom: 1px solid #dc3545; padding-bottom: 2px;">Lihat Semua Berita <i class="ti-arrow-right g-margin-l-5--xs"></i></a>
                        </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="col-xs-12 text-center">
                    <p class="g-color--dark">Belum ada berita.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof Swiper !== 'undefined') {
            new Swiper('.js__swiper-berita-home', {
                autoplay: 4000,
                loop: true,
                effect: 'fade',
                pagination: '.swiper-berita-pagination',
                paginationClickable: true,
                speed: 800
            });
        }
    });
</script>
