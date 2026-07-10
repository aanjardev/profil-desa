<div class="g-bg-color--sky-light g-padding-y-80--xs g-padding-y-125--sm">
    <style>
        .modern-card {
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
        }
        
        .modern-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        }
        
        .modern-card-img-wrapper {
            position: relative;
            height: 240px;
            overflow: hidden;
        }
        
        .modern-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        
        .modern-card:hover .modern-card-img {
            transform: scale(1.1);
        }
        
        .modern-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.95);
            color: #333;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            z-index: 2;
        }

        .modern-badge-primary {
            background: #dc3545; /* Changed to red */
            color: #fff;
        }
        
        .modern-card-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .modern-meta {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 8px;
            font-size: 13px;
            color: #888;
        }
        
        .modern-meta span {
            display: inline-flex;
            align-items: center;
            margin-right: 15px;
            margin-bottom: 5px;
        }
        
        .modern-meta i {
            margin-right: 6px;
            color: #dc3545; /* Changed to red */
            font-size: 14px;
        }
        
        .modern-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
            line-height: 1.3;
            margin-top: 0;
        }
        
        .modern-title a {
            color: #222;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .modern-card:hover .modern-title a {
            color: #dc3545; /* Changed to red */
        }
        
        .modern-desc {
            color: #555;
            font-size: 14px;
            line-height: 1.6;
            text-align: justify;
            margin-bottom: 15px;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .modern-footer {
            border-top: 1px solid #f0f0f0;
            padding-top: 15px;
            display: flex;
            align-items: center;
        }
        
        .modern-btn {
            color: #dc3545; /* Changed to red */
            font-weight: 700;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .modern-btn i {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }
        
        .modern-btn:hover, .modern-btn:focus {
            color: #c82333; /* Darker red on hover */
            text-decoration: none;
        }
        
        .modern-btn:hover i {
            transform: translateX(5px);
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
        <div class="row row-flex g-margin-b-60--xs" style="justify-content: center;">
            @forelse($wisata as $w)
            <div class="col-sm-4 col-xs-12 g-margin-b-30--xs g-margin-b-0--md" style="display: flex; padding-bottom: 30px;">
                <article class="modern-card">
                    <div class="modern-card-img-wrapper">
                        <span class="modern-badge modern-badge-primary">Wisata</span>
                        <img class="modern-card-img" src="{{ $w->main_image ? asset('storage/'.$w->main_image) : asset('images/default-image.png') }}" alt="{{ $w->name }}">
                    </div>
                    <div class="modern-card-body">
                        <div class="modern-meta">
                            @if($w->location)
                            <span><i class="ti-location-pin"></i> {{ Str::limit($w->location, 25) }}</span>
                            @endif
                        </div>
                        <h3 class="modern-title"><a href="{{ route('pariwisata.show', $w->slug) }}">{{ $w->name }}</a></h3>
                        <p class="modern-desc">{{ strip_tags($w->description) }}</p>
                        <div class="modern-footer">
                            <a href="{{ route('pariwisata.show', $w->slug) }}" class="modern-btn">
                                Lihat Detail <i class="ti-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            @empty
            <div class="col-sm-12 text-center"><p>Belum ada data wisata.</p></div>
            @endforelse
            
            @if($wisata->count() > 0)
            <div class="col-xs-12 text-center g-margin-t-20--xs" style="width: 100%;">
                <a href="{{ route('pariwisata') }}" class="text-uppercase s-btn s-btn--md s-btn--primary-brd g-radius--50">Lihat Semua Wisata</a>
            </div>
            @endif
        </div>

        <!-- Highlight UMKM -->
        <div class="g-text-center--xs g-margin-b-40--xs g-margin-t-60--xs">
            <h2 class="g-font-size-26--xs g-font-size-36--sm g-font-weight--700">Produk Unggulan UMKM</h2>
            <p class="g-font-size-16--xs g-color--dark">Dukung ekonomi kreatif masyarakat desa.</p>
        </div>
        <div class="row row-flex" style="justify-content: center;">
            @forelse($umkm as $u)
            <div class="col-sm-4 col-xs-12 g-margin-b-30--xs g-margin-b-0--md" style="display: flex; padding-bottom: 30px;">
                <article class="modern-card">
                    <div class="modern-card-img-wrapper">
                        @if($u->category)
                        <span class="modern-badge">{{ $u->category }}</span>
                        @endif
                        <img class="modern-card-img" src="{{ $u->main_image ? asset('storage/'.$u->main_image) : asset('images/default-image.png') }}" alt="{{ $u->name }}">
                    </div>
                    <div class="modern-card-body">
                        <div class="modern-meta">
                            @if($u->location)
                            <span><i class="ti-location-pin"></i> {{ Str::limit($u->location, 20) }}</span>
                            @endif
                            @if($u->owner_name)
                            <span><i class="ti-user"></i> {{ Str::limit($u->owner_name, 15) }}</span>
                            @endif
                        </div>
                        <h3 class="modern-title"><a href="{{ route('umkm.show', $u->slug) }}">{{ $u->name }}</a></h3>
                        <p class="modern-desc">{{ strip_tags($u->description) }}</p>
                        <div class="modern-footer">
                            <a href="{{ route('umkm.show', $u->slug) }}" class="modern-btn">
                                Lihat Detail <i class="ti-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            @empty
            <div class="col-sm-12 text-center"><p>Belum ada data UMKM.</p></div>
            @endforelse
            
            @if($umkm->count() > 0)
            <div class="col-xs-12 text-center g-margin-t-20--xs" style="width: 100%;">
                <a href="{{ route('umkm') }}" class="text-uppercase s-btn s-btn--md s-btn--primary-brd g-radius--50">Lihat Semua UMKM</a>
            </div>
            @endif
        </div>
    </div>
</div>
