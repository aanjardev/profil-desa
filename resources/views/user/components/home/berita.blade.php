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
                @php $utama = $berita->first(); @endphp
                <!-- Berita Highlight Besar (Kiri) -->
                <div class="col-md-7 g-margin-b-40--xs g-margin-b-0--md">
                    <article class="g-radius--10" style="position: relative; overflow: hidden; aspect-ratio: 16/9; display: flex; align-items: flex-end; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                            <img src="{{ $utama->image ? asset('storage/'.$utama->image) : asset('images/default-image.png') }}" alt="{{ $utama->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        </div>
                        <!-- Gradient Overlay -->
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0) 100%); pointer-events: none;"></div>
                        
                        <!-- Tombol Baca Berita -->
                        <div style="position: absolute; top: 20px; right: 20px; z-index: 3;">
                            <a href="{{ route('berita-desa.show', $utama->slug) }}" class="text-uppercase s-btn s-btn--xs s-btn--primary-brd g-radius--50 g-padding-x-30--xs g-color--white" style="background: rgba(0,0,0,0.3); backdrop-filter: blur(5px);">Baca Berita</a>
                        </div>
                        
                        <!-- Konten Text -->
                        <div style="position: relative; z-index: 2; width: 100%; padding: 30px;">
                            <span class="g-font-size-12--xs g-color--primary g-font-weight--700 g-margin-b-10--xs block text-uppercase"><i class="ti-time g-margin-r-5--xs"></i> {{ $utama->created_at->translatedFormat('d F Y') }}</span>
                            <h3 class="g-font-size-22--xs g-font-size-28--md g-font-weight--700 g-margin-b-10--xs">
                                <a href="{{ route('berita-desa.show', $utama->slug) }}" class="g-color--white g-color--primary--hover berita-title-hover" style="text-decoration: none; line-height: 1.3;">{{ $utama->title }}</a>
                            </h3>
                            <p class="g-font-size-14--xs g-color--white-opacity g-margin-b-0--xs" style="margin-bottom: 0;">{{ Str::limit($utama->excerpt, 120) }}</p>
                        </div>
                    </article>
                </div>

                <!-- Daftar Berita Samping (Kanan) -->
                <div class="col-md-5">
                    <div style="display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                        @foreach($berita->skip(1)->take(3) as $post)
                            <article class="clearfix g-bg-color--white g-margin-b-20--xs" style="border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex;">
                                <div style="flex: 0 0 140px; aspect-ratio: 16/9; overflow: hidden;">
                                    <img src="{{ $post->image ? asset('storage/'.$post->image) : asset('images/default-image.png') }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div class="g-padding-x-20--xs g-padding-y-15--xs" style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
                                    <span class="g-font-size-11--xs g-color--primary g-font-weight--600 g-margin-b-5--xs block"><i class="ti-time g-margin-r-5--xs"></i> {{ $post->created_at->format('d M Y') }}</span>
                                    <h3 class="g-font-size-15--xs g-font-weight--700 g-margin-b-5--xs" style="line-height: 1.4;">
                                        <a href="{{ route('berita-desa.show', $post->slug) }}" class="g-color--dark g-color--primary--hover berita-title-hover" style="text-decoration: none;">{{ Str::limit($post->title, 60) }}</a>
                                    </h3>
                                    <p class="g-font-size-12--xs g-color--dark g-margin-b-0--xs hidden-xs">{{ Str::limit($post->excerpt, 50) }}</p>
                                </div>
                            </article>
                        @endforeach

                        @if($berita->count() > 1)
                        <div class="text-right" style="margin-top: -10px;">
                            <a href="{{ route('berita-desa') }}" class="g-font-size-14--xs g-font-weight--600 g-color--primary g-color--dark--hover" style="text-decoration: none;">Lihat Semua Berita <i class="ti-arrow-right g-margin-l-5--xs"></i></a>
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
