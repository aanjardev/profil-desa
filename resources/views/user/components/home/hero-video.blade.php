<div class="s-promo-block-v4 g-bg-color--dark" style="position: relative; overflow: hidden; height: 100vh; display: flex; align-items: center; justify-content: center;">
    <!-- YouTube Video Background -->
    @php
        // Convert watch?v=ID to embed/ID
        $videoUrl = $setting->youtube_video_url ?? 'https://www.youtube.com/watch?v=LXb3EKWsInQ';
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $videoUrl, $match);
        $videoId = $match[1] ?? 'LXb3EKWsInQ';
    @endphp
    <style>
        @keyframes fadeInVideo {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        .hero-video-fade {
            opacity: 0;
            animation: fadeInVideo 2s ease-in-out 3s forwards;
        }
    </style>
    <div class="hero-video-fade" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 1;">
        <iframe 
            src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&controls=0&loop=1&playlist={{ $videoId }}&modestbranding=1&rel=0&iv_load_policy=3&cc_load_policy=0&disablekb=1&playsinline=1" 
            frameborder="0" 
            allow="autoplay; encrypted-media" 
            allowfullscreen 
            style="width: 100vw; height: 56.25vw; min-height: 100vh; min-width: 177.77vh; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(1.15);">
        </iframe>
    </div>
    
    <!-- Dark Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 2;"></div>

    <!-- Content Overlay -->
    <div class="container g-text-center--xs g-padding-y-100--xs" style="position: relative; z-index: 3;">
        <h1 class="g-font-size-18--xs g-font-size-50--sm g-font-size-60--md g-color--white g-font-weight--700 g-margin-b-10--xs g-margin-b-20--sm" style="text-transform: uppercase; letter-spacing: 2px;">
            Selamat Datang di
        </h1>
        <h2 class="g-font-size-28--xs g-font-size-60--sm g-font-size-80--md g-color--primary g-font-weight--800 g-margin-b-10--xs" style="text-transform: uppercase; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
            {{ 'Desa ' . ($setting->village_name ?? 'Tulungrejo') }}
        </h2>
        <h3 class="g-font-size-14--xs g-font-size-24--md g-color--white g-font-weight--400 g-margin-b-30--xs" style="text-transform: uppercase; letter-spacing: 1px; text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">
            Kecamatan {{ $setting->subdistrict ?? 'Bumiaji' }}, Kota {{ $setting->city ?? 'Batu' }}, {{ $setting->province ?? 'Jawa Timur' }}
        </h3>
        <p class="g-font-size-14--xs g-font-size-22--md g-color--white-opacity g-margin-b-50--xs" style="max-width: 800px; margin-left: auto; margin-right: auto;">
            Membangun Desa yang Mandiri, Sejahtera, dan Berbudaya
        </p>
        <div>
            <a href="#profil" class="text-uppercase s-btn s-btn--md s-btn--primary-bg g-radius--50 g-padding-x-40--xs g-margin-b-20--xs g-margin-r-10--sm">
                Jelajahi Desa
            </a>
            <a href="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&controls=0&rel=0&iv_load_policy=3&cc_load_policy=0&disablekb=1&modestbranding=1&playsinline=1" class="js__popup__clean_video text-uppercase s-btn s-btn--md s-btn--white-brd g-radius--50 g-padding-x-40--xs g-margin-b-20--xs">
                <i class="ti-control-play g-margin-r-5--xs"></i> Tonton Video Profil
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if(typeof $ !== 'undefined' && $.fn.magnificPopup) {
            $('.js__popup__clean_video').magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: true,
                iframe: {
                    patterns: {
                        youtube: {
                            index: 'youtube.com/embed/',
                            id: function(url) { return url; }, // Return the whole URL
                            src: '%id%' // Use the whole URL as src
                        }
                    }
                }
            });
        }
    });
</script>
