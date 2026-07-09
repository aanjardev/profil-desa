<div class="g-bg-color--white g-padding-y-80--xs g-padding-y-125--sm">
    <div class="container">
        <div class="row">
            <!-- Berita Terbaru -->
            <div class="col-md-6 g-margin-b-40--xs g-margin-b-0--md">
                <div class="g-margin-b-30--xs">
                    <h2 class="g-font-size-26--xs g-font-weight--700">Berita Terbaru</h2>
                    <p class="g-color--dark g-font-size-14--xs">Kabar terkini dari Desa Tulungrejo.</p>
                </div>
                <div class="row">
                    @forelse($berita as $post)
                    <div class="col-xs-12 g-margin-b-30--xs">
                        <article class="clearfix g-bg-color--white" style="border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                            <div class="col-xs-4 g-padding-x-0--xs">
                                <img class="img-responsive" src="{{ $post->image ? asset('storage/'.$post->image) : asset('images/default-image.png') }}" alt="Image" style="height: 120px; width: 100%; object-fit: cover;">
                            </div>
                            <div class="col-xs-8 g-padding-x-20--xs g-padding-y-15--xs">
                                <h3 class="g-font-size-16--xs g-margin-b-5--xs">
                                    <a href="#">{{ $post->title }}</a>
                                </h3>
                                <p class="g-font-size-13--xs g-color--dark g-margin-b-10--xs">{{ Str::limit($post->excerpt, 60) }}</p>
                                <span class="g-font-size-12--xs g-color--primary"><i class="ti-time g-margin-r-5--xs"></i> {{ $post->created_at->format('d M Y') }}</span>
                            </div>
                        </article>
                    </div>
                    @empty
                    <div class="col-xs-12">
                        <p>Belum ada berita.</p>
                    </div>
                    @endforelse
                </div>
                <div class="text-right">
                    <a href="{{ route('berita-desa') }}" class="s-btn s-btn--xs s-btn--primary-brd g-radius--50">Lihat Semua Berita</a>
                </div>
            </div>

            <!-- Pengumuman Desa -->
            <div class="col-md-6">
                <div class="g-margin-b-30--xs">
                    <h2 class="g-font-size-26--xs g-font-weight--700">Pengumuman Desa</h2>
                    <p class="g-color--dark g-font-size-14--xs">Informasi penting untuk warga.</p>
                </div>
                <div style="padding: 30px; border-radius: 8px; background: #f9f9f9;">
                    <ul class="list-unstyled g-margin-b-0--xs">
                        @forelse($pengumuman as $peng)
                        <li class="g-margin-b-20--xs" style="border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 15px;">
                            <span class="g-font-size-12--xs g-color--primary g-font-weight--700"><i class="ti-announcement g-margin-r-5--xs"></i> {{ $peng->created_at->format('d M Y') }}</span>
                            <h4 class="g-font-size-16--xs g-margin-t-5--xs g-margin-b-5--xs">
                                <a href="#">{{ $peng->title }}</a>
                            </h4>
                            <p class="g-font-size-13--xs g-color--dark g-margin-b-0--xs">{{ Str::limit($peng->excerpt, 80) }}</p>
                        </li>
                        @empty
                        <li><p>Belum ada pengumuman.</p></li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
