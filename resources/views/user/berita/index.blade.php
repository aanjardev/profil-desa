@extends('layouts.user')

@section('title', 'Berita & Artikel')

@section('content')

<!--========== HIGHLIGHT & MARQUEE BLOCK ==========-->
<div class="g-padding-y-100--xs" style="background-image: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-bottom: 50px !important;">
    <!-- Dark Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(26, 32, 44, 0.75); z-index: 1;"></div>
    
    <div class="container" style="position: relative; z-index: 2;">
        
        <style>
            .marquee-link:hover, .news-title-link:hover {
                color: #dc3545 !important; /* Red hover color */
                text-decoration: underline !important;
            }
            .marquee-container {
                overflow: hidden;
                white-space: nowrap;
                flex-grow: 1;
                display: flex;
            }
            .marquee-content {
                display: inline-flex;
                animation: marquee-anim 25s linear infinite;
            }
            .marquee-container:hover .marquee-content {
                animation-play-state: paused;
            }
            @keyframes marquee-anim {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
        </style>
        
        <!-- Marquee Info -->
        <div class="g-bg-color--white g-padding-x-20--xs g-padding-y-10--xs g-margin-b-30--xs" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.04); display: flex; align-items: center;">
            <div class="g-color--white g-bg-color--primary g-padding-x-15--xs g-padding-y-5--xs g-radius--50 g-font-size-12--xs g-font-weight--700 text-uppercase g-margin-r-15--xs" style="white-space: nowrap;">Info Terbaru</div>
            <div class="marquee-container">
                <div class="marquee-content">
                    <!-- Set 1 -->
                    @foreach($recentPosts as $recent)
                        <span class="g-margin-r-40--xs">
                            <i class="ti-bolt g-color--primary g-margin-r-5--xs"></i> 
                            <a href="{{ route('berita-desa.show', $recent->slug) }}" class="marquee-link" style="color: #4a5568; text-decoration: none; font-weight: 600;">{{ $recent->title }}</a>
                        </span>
                    @endforeach
                    <!-- Set 2 (Duplicate for seamless loop) -->
                    @foreach($recentPosts as $recent)
                        <span class="g-margin-r-40--xs">
                            <i class="ti-bolt g-color--primary g-margin-r-5--xs"></i> 
                            <a href="{{ route('berita-desa.show', $recent->slug) }}" class="marquee-link" style="color: #4a5568; text-decoration: none; font-weight: 600;">{{ $recent->title }}</a>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Highlight Grid -->
        @if(isset($highlightPosts) && $highlightPosts->count() >= 1 && !request('search') && !request('category') && !request('month'))
        <div class="row">
            <!-- Main Highlight (Left) -->
            <div class="col-md-{{ $highlightPosts->count() > 1 ? '8' : '12' }} g-margin-b-30--xs g-margin-b-0--md">
                @php $mainHighlight = $highlightPosts[0]; @endphp
                <div style="position: relative; aspect-ratio: 16/9; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.15);">
                    <img src="{{ $mainHighlight->image ? asset('storage/'.$mainHighlight->image) : asset('images/default-image.png') }}" alt="{{ $mainHighlight->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; bottom: 0; left: 0; width: 100%; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent); padding: 50px 30px 25px;">
                        <span class="g-bg-color--primary g-color--white g-font-size-11--xs g-font-weight--700 text-uppercase g-padding-x-10--xs g-padding-y-5--xs g-radius--50 g-margin-b-15--xs" style="display: inline-block;">{{ $mainHighlight->category ?? 'Umum' }}</span>
                        <h2 class="g-font-size-24--xs g-font-size-32--sm g-font-weight--700 g-margin-b-10--xs" style="line-height: 1.3;">
                            <a href="{{ route('berita-desa.show', $mainHighlight->slug) }}" class="g-color--white news-title-link" style="text-decoration: none;">{{ $mainHighlight->title }}</a>
                        </h2>
                        <ul class="list-inline g-font-size-13--xs" style="color: #ffffff !important; margin-bottom: 10px;">
                            <li style="color: #ffffff !important;"><i class="ti-time g-margin-r-5--xs" style="color: #ffffff !important;"></i> <span style="color: #ffffff !important;">{{ $mainHighlight->created_at->translatedFormat('d M Y') }}</span></li>
                        </ul>
                        <p class="g-font-size-14--xs g-color--white-opacity" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-align: justify; margin-bottom: 0;">
                            {{ Str::limit(strip_tags($mainHighlight->excerpt ?? $mainHighlight->content), 200) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sub Highlights (Right) -->
            @if($highlightPosts->count() > 1)
            <div class="col-md-4">
                <div style="display: flex; flex-direction: column; gap: 30px;">
                    @foreach($highlightPosts->slice(1, 2) as $subHighlight)
                        <div style="position: relative; aspect-ratio: 16/9; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.15);">
                            <img src="{{ $subHighlight->image ? asset('storage/'.$subHighlight->image) : asset('images/default-image.png') }}" alt="{{ $subHighlight->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; bottom: 0; left: 0; width: 100%; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent); padding: 40px 20px 15px;">
                                <h3 class="g-font-size-16--xs g-font-weight--700 g-margin-b-5--xs" style="line-height: 1.3;">
                                    <a href="{{ route('berita-desa.show', $subHighlight->slug) }}" class="g-color--white news-title-link" style="text-decoration: none;">{{ $subHighlight->title }}</a>
                                </h3>
                                <div style="margin-bottom: 8px;">
                                    <span class="g-font-size-12--xs" style="color: #ffffff !important;"><i class="ti-time g-margin-r-5--xs" style="color: #ffffff !important;"></i> <span style="color: #ffffff !important;">{{ $subHighlight->created_at->translatedFormat('d M Y') }}</span></span>
                                </div>
                                <p class="g-font-size-13--xs g-color--white-opacity" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-align: justify; margin-bottom: 0;">
                                    {{ Str::limit(strip_tags($subHighlight->excerpt ?? $subHighlight->content), 120) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
<!--========== END HIGHLIGHT & MARQUEE BLOCK ==========-->

<!--========== PAGE CONTENT ==========-->
<div class="g-bg-color--sky-light g-padding-y-40--xs">
    <div class="container">
        <div class="row">
            <!-- Main Content (List) -->
            <div class="col-md-8 g-margin-b-30--xs g-margin-b-0--md">
                
                <!-- Filter Status -->
                @if(request('search') || request('category') || request('month'))
                <div class="g-margin-b-30--xs g-bg-color--white g-padding-x-20--xs g-padding-y-20--xs" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                    <h4 class="g-font-size-16--xs g-font-weight--400 g-margin-b-0--xs" style="color: #4a5568;">
                        Hasil untuk: 
                        @if(request('search')) <strong>"{{ request('search') }}"</strong> @endif
                        @if(request('category')) Kategori <strong>{{ request('category') }}</strong> @endif
                        @if(request('month') && request('year')) Bulan <strong>{{ \Carbon\Carbon::create()->month((int)request('month'))->translatedFormat('F') }} {{ request('year') }}</strong> @endif
                        <a href="{{ route('berita-desa') }}" class="pull-right g-color--primary" style="font-size: 13px;"><i class="ti-close"></i> Hapus Filter</a>
                    </h4>
                </div>
                @endif

                @if($posts->count() > 0)
                    <style>
                        .list-card-responsive { flex-direction: column !important; }
                        .list-card-img { width: 100%; aspect-ratio: 16/9; }
                        @media (min-width: 768px) {
                            .list-card-responsive { flex-direction: row !important; }
                            .list-card-img { width: 40%; aspect-ratio: 16/9; flex-shrink: 0; }
                        }
                        .custom-pagination ul.pagination { margin: 0 !important; }
                    </style>
                    
                    <!-- Top Pagination & Info -->
                    <div class="g-margin-b-30--xs" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px; flex-wrap: wrap; gap: 15px;">
                        <p class="g-font-size-14--xs" style="color: #4a5568; margin-bottom: 0;">
                            Menampilkan <strong>{{ $posts->count() }}</strong> dari <strong>{{ $posts->total() }}</strong> berita
                        </p>
                        <div class="custom-pagination">
                            @if ($posts->lastPage() > 1)
                                {{ $posts->links('pagination::bootstrap-4') }}
                            @else
                                <ul class="pagination">
                                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                                    <li class="page-item active"><span class="page-link">1</span></li>
                                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                                </ul>
                            @endif
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 30px;">
                        @foreach($posts as $post)
                            <!-- Horizontal List Item -->
                            <article class="list-card-responsive" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; display: flex; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.05)';">
                                <a href="{{ route('berita-desa.show', $post->slug) }}" class="list-card-img" style="display: block; overflow: hidden; position: relative;">
                                    <img src="{{ $post->image ? asset('storage/'.$post->image) : asset('images/default-image.png') }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </a>
                                <div style="padding: 25px; flex-grow: 1; display: flex; flex-direction: column; justify-content: center;">
                                    <div class="g-margin-b-10--xs">
                                        <span class="g-font-size-12--xs g-color--primary g-margin-r-10--xs g-font-weight--700"><i class="ti-tag g-margin-r-5--xs"></i>{{ $post->category ?? 'Umum' }}</span>
                                        <span class="g-font-size-12--xs" style="color: #a0aec0;"><i class="ti-time g-margin-r-5--xs"></i>{{ $post->created_at->translatedFormat('d M Y') }}</span>
                                    </div>
                                    <h3 class="g-font-size-20--xs g-font-weight--700 g-margin-b-15--xs" style="line-height: 1.4;">
                                        <a href="{{ route('berita-desa.show', $post->slug) }}" class="news-title-link" style="color: #2d3748; text-decoration: none;">{{ $post->title }}</a>
                                    </h3>
                                    <p class="g-font-size-14--xs" style="color: #718096; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0; text-align: justify;">
                                        {{ Str::limit(strip_tags($post->excerpt ?? $post->content), 300) }}
                                    </p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    
                    <!-- Bottom Pagination -->
                    <div class="g-margin-t-40--xs text-center custom-pagination" style="display: flex; justify-content: center;">
                        @if ($posts->lastPage() > 1)
                            {{ $posts->links('pagination::bootstrap-4') }}
                        @else
                            <ul class="pagination">
                                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                                <li class="page-item active"><span class="page-link">1</span></li>
                                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                            </ul>
                        @endif
                    </div>
                @else
                    <div class="text-center g-padding-y-60--xs g-bg-color--white" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                        <i class="ti-info-alt g-font-size-40--xs g-color--primary g-margin-b-15--xs" style="display: block;"></i>
                        <h4 class="g-font-size-20--xs g-margin-b-10--xs" style="color: #2d3748;">Berita Tidak Ditemukan</h4>
                        <p class="g-font-size-15--xs" style="color: #718096;">Belum ada berita yang diterbitkan atau sesuai dengan pencarian Anda.</p>
                        <a href="{{ route('berita-desa') }}" class="s-btn s-btn--xs s-btn--primary-bg g-margin-t-20--xs">Kembali ke Semua Berita</a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            @include('user.berita.sidebar')
        </div>
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection
