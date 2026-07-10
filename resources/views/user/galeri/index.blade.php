@extends('layouts.user')

@section('title', 'Galeri Desa')

@section('content')

<!--========== PARALLAX HEADER ==========-->
<div class="g-padding-y-80--xs" style="background-image: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-top: 130px !important;">
    <!-- Dark Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(26, 32, 44, 0.85); z-index: 1;"></div>
    
    <div class="container text-center" style="position: relative; z-index: 2;">
        <h1 class="g-font-size-32--xs g-font-size-40--sm g-font-weight--700 g-color--white g-margin-b-10--xs">Galeri Desa</h1>
        <p class="g-font-size-16--xs g-color--white-opacity" style="max-width: 600px; margin: 0 auto;">Kumpulan dokumentasi kegiatan, potensi, dan keindahan desa kami.</p>
    </div>
</div>
<!--========== END PARALLAX HEADER ==========-->

<!--========== PAGE CONTENT ==========-->
<div class="g-bg-color--sky-light g-padding-y-60--xs">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-8 g-margin-b-30--xs g-margin-b-0--md">
                
                @if(isset($galleries) && $galleries->count() > 0)
                    <style>
                        .custom-pagination ul.pagination { margin: 0 !important; }
                    </style>
                    <div class="g-margin-b-20--xs" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                        <p class="g-font-size-14--xs" style="color: #4a5568; margin-bottom: 0;">
                            Menampilkan <strong>{{ $galleries->count() }}</strong> dari <strong>{{ $galleries->total() }}</strong> foto
                            @if(request('category'))
                                untuk kategori <strong>{{ request('category') }}</strong>
                                <a href="{{ route('galeri') }}" class="g-color--primary g-margin-l-10--xs" style="font-size: 13px;"><i class="ti-close"></i> Hapus Filter</a>
                            @endif
                        </p>
                        <!-- Pagination (Top) -->
                        <div class="custom-pagination">
                            @if ($galleries->lastPage() > 1)
                                {{ $galleries->links('pagination::bootstrap-4') }}
                            @else
                                <ul class="pagination">
                                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">&lsaquo;</span></li>
                                    <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">&rsaquo;</span></li>
                                </ul>
                            @endif
                        </div>
                    </div>

                    <div class="row" id="gallery-container">
                        @foreach($galleries as $gallery)
                        <div class="col-sm-6 g-margin-b-30--xs">
                            <div style="background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                                <a href="{{ route('galeri.show', $gallery->id) }}" title="{{ $gallery->title }}" style="display: block; position: relative; aspect-ratio: 4/3; overflow: hidden;">
                                    <img src="{{ asset('storage/'.$gallery->image_path) }}" alt="{{ $gallery->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                    <div style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 20px; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); display: flex; align-items: flex-end;">
                                        <div style="color: #fff;">
                                            @if($gallery->category)
                                                <span class="g-font-size-11--xs g-bg-color--primary g-padding-x-10--xs g-padding-y-3--xs g-radius--50 g-margin-b-5--xs" style="display: inline-block;">{{ $gallery->category }}</span>
                                            @endif
                                            <h3 class="g-font-size-16--xs g-font-weight--700 g-margin-b-0--xs" style="color: #fff;">{{ $gallery->title }}</h3>
                                        </div>
                                    </div>
                                </a>
                                @if($gallery->description)
                                <div class="g-padding-x-20--xs g-padding-y-15--xs">
                                    <p class="g-font-size-13--xs g-color--text g-margin-b-0--xs" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $gallery->description }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination (Bottom) -->
                    <div class="g-margin-t-20--xs text-center custom-pagination" style="display: flex; justify-content: center;">
                        @if ($galleries->lastPage() > 1)
                            {{ $galleries->links('pagination::bootstrap-4') }}
                        @else
                            <ul class="pagination">
                                <li class="page-item disabled" aria-disabled="true"><span class="page-link">&lsaquo;</span></li>
                                <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                                <li class="page-item disabled" aria-disabled="true"><span class="page-link">&rsaquo;</span></li>
                            </ul>
                        @endif
                    </div>
                @else
                    <div class="text-center g-padding-y-60--xs g-bg-color--white" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                        <i class="ti-image g-font-size-40--xs g-color--primary g-margin-b-15--xs" style="display: block;"></i>
                        <h4 class="g-font-size-20--xs g-margin-b-10--xs" style="color: #2d3748;">Galeri Kosong</h4>
                        <p class="g-font-size-15--xs" style="color: #718096;">Belum ada foto atau tidak ada hasil yang sesuai dengan pencarian Anda.</p>
                        <a href="{{ route('galeri') }}" class="s-btn s-btn--xs s-btn--primary-bg g-margin-t-20--xs">Kembali ke Semua Galeri</a>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            @include('user.galeri.sidebar')
        </div>
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        if($.fn.magnificPopup) {
            $('.gallery-popup').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1] 
                },
                image: {
                    titleSrc: 'title'
                }
            });
        }
    });
</script>
@endsection
