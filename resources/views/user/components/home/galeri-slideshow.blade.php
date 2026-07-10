<style>
    .modern-gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        display: block;
        margin-bottom: 30px;
        background-color: #000;
    }

    .modern-gallery-img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        display: block;
        opacity: 0.9;
    }

    .modern-gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 30px 20px 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.6) 60%, rgba(0,0,0,0) 100%);
        color: #fff;
        opacity: 0;
        transition: opacity 0.4s ease-in-out;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        height: 100%;
    }

    .modern-gallery-item:hover .modern-gallery-img {
        transform: scale(1.1);
        opacity: 0.5;
    }

    .modern-gallery-item:hover .modern-gallery-overlay {
        opacity: 1;
    }

    .modern-gallery-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: #fff;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        transform: translateY(20px);
        transition: transform 0.4s ease-in-out 0.1s;
    }

    .modern-gallery-item:hover .modern-gallery-title {
        transform: translateY(0);
    }

    .modern-gallery-desc {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.9);
        margin-bottom: 0;
        transform: translateY(20px);
        transition: transform 0.4s ease-in-out 0.15s;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.5;
    }

    .modern-gallery-item:hover .modern-gallery-desc {
        transform: translateY(0);
    }

    .modern-gallery-category {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: var(--color-primary, #17a2b8); /* Using a nice teal/blue fallback */
        color: #fff;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 2;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.4s ease-in-out, transform 0.4s ease-in-out;
    }

    .modern-gallery-item:hover .modern-gallery-category {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<div class="g-bg-color--sky-light g-padding-y-80--xs g-padding-y-125--sm">
    <div class="container">
        <div class="g-text-center--xs g-margin-b-60--xs">
            <h2 class="g-font-size-26--xs g-font-size-36--sm g-font-weight--700">Galeri Foto</h2>
            <p class="g-font-size-16--xs g-color--dark">Momen dan pesona Desa Tulungrejo.</p>
        </div>
        <div class="row" style="display: flex; flex-wrap: wrap; justify-content: center;">
            @forelse($galleries as $gallery)
            <div class="col-sm-4 col-xs-12">
                <a href="{{ $gallery->image_path ? asset('storage/'.$gallery->image_path) : asset('images/default-image.png') }}" 
                   title="{{ $gallery->title }}" 
                   class="modern-gallery-item">
                    
                    @if($gallery->category)
                    <span class="modern-gallery-category">{{ $gallery->category }}</span>
                    @endif
                    
                    <img class="modern-gallery-img" 
                         src="{{ $gallery->image_path ? asset('storage/'.$gallery->image_path) : asset('images/default-image.png') }}" 
                         alt="{{ $gallery->title }}">
                         
                    <div class="modern-gallery-overlay">
                        <h3 class="modern-gallery-title">{{ $gallery->title ?? 'Tanpa Judul' }}</h3>
                        @if($gallery->description)
                        <p class="modern-gallery-desc">{{ Str::limit(strip_tags($gallery->description), 100) }}</p>
                        @endif
                    </div>
                </a>
            </div>
            @empty
            <div class="col-xs-12 text-center"><p>Belum ada foto di galeri.</p></div>
            @endforelse
            <div class="col-xs-12 text-center g-margin-t-20--xs">
                <a href="{{ route('galeri') }}" class="text-uppercase s-btn s-btn--md s-btn--primary-brd g-radius--50">Lihat Semua Foto</a>
            </div>
        </div>
    </div>
</div>
