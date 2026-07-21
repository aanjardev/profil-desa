@extends('layouts.user')

@section('title', $post->title . ' - Berita & Artikel')

@section('content')
<!--========== PAGE CONTENT ==========-->
<div style="background: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}') center center no-repeat fixed; background-size: cover; position: relative; min-height: 100vh;">
    <!-- Light Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(14, 22, 34, 0.71); z-index: 1;"></div>
    
    <div style="position: relative; z-index: 2;">
        <div class="container g-padding-y-80--xs" style="padding-top: 130px;">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8 g-margin-b-20--xs g-margin-b-0--md">
            <article class="g-bg-color--white g-box-shadow__dark-lightest-v2 g-padding-x-30--xs g-padding-y-40--xs" style="border-radius: 12px;">
                <!-- Meta -->
                <div class="g-margin-b-20--xs text-center">
                    <span class="g-font-size-13--xs g-color--primary g-margin-r-15--xs"><i class="ti-tag g-margin-r-5--xs"></i>{{ $post->category ?? 'Umum' }}</span>
                    <span class="g-font-size-13--xs g-color--text g-margin-r-15--xs"><i class="ti-time g-margin-r-5--xs"></i>{{ $post->created_at->translatedFormat('d F Y') }}</span>
                    <span class="g-font-size-13--xs g-color--text g-margin-r-15--xs"><i class="ti-user g-margin-r-5--xs"></i>Oleh: {{ $post->user->name ?? 'Admin' }}</span>
                    <span class="g-font-size-13--xs g-color--text"><i class="ti-eye g-margin-r-5--xs"></i>{{ $post->views }} kali dibaca</span>
                </div>

                <!-- Title -->
                <h1 class="g-font-size-28--xs g-font-size-36--sm g-font-weight--700 text-center g-margin-b-30--xs" style="line-height: 1.3;">
                    {{ $post->title }}
                </h1>

                <!-- Featured Image -->
                @if($post->image)
                    <div class="g-margin-b-30--xs text-center">
                        <img class="img-responsive" src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" style="width: 100%; max-height: 450px; object-fit: cover; border-radius: 12px;">
                    </div>
                @else
                    <div class="g-margin-b-30--xs text-center">
                        <img class="img-responsive" src="{{ asset('images/default-image.png') }}" alt="{{ $post->title }}" style="width: 100%; max-height: 450px; object-fit: cover; border-radius: 12px;">
                    </div>
                @endif

                <!-- Content -->
                <div class="g-font-size-16--xs g-color--dark" style="line-height: 1.8; text-align: justify;">
                    {!! Str::markdown($post->content) !!}
                </div>

                <!-- Supporting Images Slider -->
                @if($post->images && $post->images->count() > 0)
                <div class="g-margin-t-40--xs">
                    <h5 class="g-font-weight--700 g-margin-b-15--xs" style="font-size: 15px; color: #444; border-left: 4px solid #1a73e8; padding-left: 10px;">Galeri Foto</h5>

                    <div id="supportSlider" style="position: relative; user-select: none;">
                        <!-- Slides -->
                        <div id="supportSliderTrack" style="position: relative;">
                            @foreach($post->images as $i => $img)
                            <div class="support-slide" data-index="{{ $i }}"
                                 style="display: {{ $i === 0 ? 'block' : 'none' }};">
                                <!-- Image -->
                                <a href="{{ asset('storage/'.$img->image_path) }}" class="supporting-image-popup"
                                   style="display: block; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 24px rgba(0,0,0,0.13);">
                                    <img src="{{ asset('storage/'.$img->image_path) }}"
                                         alt="{{ $img->caption ?? 'Gambar Pendukung' }}"
                                         style="width: 100%; aspect-ratio: 16/9; object-fit: cover; display: block;">
                                </a>
                                <!-- Caption -->
                                @if($img->caption)
                                <div style="text-align: center; margin-top: 12px; padding: 8px 16px; background: #f8f9fa; border-radius: 8px; border: 1px solid #eee;">
                                    <span style="font-size: 13px; color: #555; font-style: italic; line-height: 1.5;">
                                        <i class="ti-image" style="margin-right: 5px; color: #1a73e8;"></i>{{ $img->caption }}
                                    </span>
                                </div>
                                @else
                                <div style="text-align: center; margin-top: 10px;">
                                    <span style="font-size: 12px; color: #aaa; font-style: italic;">Foto {{ $i + 1 }} dari {{ $post->images->count() }}</span>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        @if($post->images->count() > 1)
                        <!-- Nav Arrows -->
                        <button onclick="supportSlide(-1)" aria-label="Sebelumnya"
                                style="position: absolute; top: calc(50% - 30px); left: -18px; transform: translateY(-50%); z-index: 10;
                                       width: 38px; height: 38px; border-radius: 50%; border: none; cursor: pointer;
                                       background: #fff; box-shadow: 0 2px 12px rgba(0,0,0,0.18);
                                       display: flex; align-items: center; justify-content: center; transition: background .2s;"
                                onmouseover="this.style.background='#1a73e8'; this.querySelector('svg').style.color='#fff'"
                                onmouseout="this.style.background='#fff'; this.querySelector('svg').style.color='#555'">
                            <svg style="width:16px;height:16px;color:#555;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button onclick="supportSlide(1)" aria-label="Berikutnya"
                                style="position: absolute; top: calc(50% - 30px); right: -18px; transform: translateY(-50%); z-index: 10;
                                       width: 38px; height: 38px; border-radius: 50%; border: none; cursor: pointer;
                                       background: #fff; box-shadow: 0 2px 12px rgba(0,0,0,0.18);
                                       display: flex; align-items: center; justify-content: center; transition: background .2s;"
                                onmouseover="this.style.background='#1a73e8'; this.querySelector('svg').style.color='#fff'"
                                onmouseout="this.style.background='#fff'; this.querySelector('svg').style.color='#555'">
                            <svg style="width:16px;height:16px;color:#555;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        <!-- Dot Indicators -->
                        <div id="supportDots" style="display: flex; justify-content: center; gap: 7px; margin-top: 16px; flex-wrap: wrap;">
                            @foreach($post->images as $i => $img)
                            <button onclick="supportGoTo({{ $i }})" aria-label="Slide {{ $i + 1 }}"
                                    class="support-dot"
                                    data-dot="{{ $i }}"
                                    style="width: 9px; height: 9px; border-radius: 50%; border: none; cursor: pointer; padding: 0; transition: all .2s;
                                           background: {{ $i === 0 ? '#1a73e8' : '#ddd' }}; transform: {{ $i === 0 ? 'scale(1.3)' : 'scale(1)' }};"></button>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Tags & Share -->
                <div class="g-margin-t-40--xs" style="border-top: 1px solid #eee; padding-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                    <div class="g-margin-b-10--xs">
                        @if($post->tags)
                            @foreach(explode(',', $post->tags) as $tag)
                                <span class="g-bg-color--primary-opacity-lightest g-color--primary g-padding-x-10--xs g-padding-y-5--xs g-radius--50 g-font-size-12--xs g-margin-r-5--xs">
                                    #{{ trim($tag) }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                    
                    <div class="g-margin-b-10--xs" style="display: flex; align-items: center;">
                        <span class="g-font-size-13--xs g-font-weight--700 g-margin-r-10--xs">Bagikan:</span>
                        <a href="javascript:void(0)" onclick="copyShareLink('{{ request()->fullUrl() }}')" class="g-color--text g-color--primary--hover g-font-size-18--xs" title="Salin Tautan">
                            <i class="ti-share"></i>
                        </a>
                        <span id="copy-toast" style="display: none; font-size: 13px; font-weight: 600; background: #2d3748; color: #fff; padding: 6px 12px; border-radius: 6px; margin-left: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); position: absolute; z-index: 10;">Tautan berhasil disalin, siap untuk dibagikan.</span>
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        @include('user.berita.sidebar')
        </div>
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection

@section('scripts')
<script>
    function copyShareLink(text) {
        // Fallback for older browsers or HTTP connections
        var textArea = document.createElement("textarea");
        textArea.value = text;
        
        // Avoid scrolling to bottom
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            document.execCommand('copy');
            showToast();
        } catch (err) {
            alert('Gagal menyalin tautan. Silakan salin URL di browser Anda secara manual.');
        }

        document.body.removeChild(textArea);
    }

    function showToast() {
        var toast = document.getElementById('copy-toast');
        toast.style.display = 'inline-block';
        setTimeout(function() { 
            toast.style.display = 'none'; 
        }, 3000);
    }

    // ---- Supporting Images Slider ----
    var _supportIndex = 0;

    function supportGoTo(index) {
        var slides = document.querySelectorAll('.support-slide');
        if (!slides.length) return;
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;

        slides[_supportIndex].style.display = 'none';
        slides[index].style.display = 'block';

        // Update dots
        var dots = document.querySelectorAll('.support-dot');
        if (dots[_supportIndex]) {
            dots[_supportIndex].style.background = '#ddd';
            dots[_supportIndex].style.transform = 'scale(1)';
        }
        if (dots[index]) {
            dots[index].style.background = '#1a73e8';
            dots[index].style.transform = 'scale(1.3)';
        }

        _supportIndex = index;
    }

    function supportSlide(dir) {
        supportGoTo(_supportIndex + dir);
    }
    // ---- End Slider ----

    $(document).ready(function() {
        if($.fn.magnificPopup) {
            $('.supporting-image-popup').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        }
    });
</script>
@endsection
