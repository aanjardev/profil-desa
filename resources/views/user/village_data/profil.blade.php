@extends('layouts.user')

@section('title', 'Profil Desa')

@section('content')
<!--========== PARALLAX HEADER ==========-->
<div class="g-padding-y-80--xs" style="background-image: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-top: 130px !important;">
    <!-- Dark Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(26, 32, 44, 0.85); z-index: 1;"></div>
    
    <div class="container text-center" style="position: relative; z-index: 2;">
        <h1 class="g-font-size-32--xs g-font-size-40--sm g-font-weight--700 g-color--white g-margin-b-10--xs">Profil Desa</h1>
        <p class="g-font-size-16--xs g-color--white-opacity" style="max-width: 600px; margin: 0 auto;">Mengenal lebih dekat identitas, sejarah, dan kondisi Desa kami tercinta.</p>
    </div>
</div>
<!--========== END PARALLAX HEADER ==========-->

<!--========== PAGE CONTENT ==========-->
<style>
    .profil-sidebar-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        padding: 20px;
        border: 1px solid #e2e8f0;
        position: -webkit-sticky;
        position: sticky;
        top: 100px;
    }
    #profil-nav a {
        transition: all 0.2s ease;
        color: #718096;
    }
    #profil-nav a:hover, #profil-nav a.active {
        background: #f8f9fa;
        color: #dc3545 !important;
    }
    /* CSS scroll offset — ensures anchor targets clear the sticky header */
    #profil-singkat, #sejarah, #geografis, #wilayah-dusun {
        scroll-margin-top: 130px;
    }
    
    @media (max-width: 991px) {
        #profil-sidebar-col {
            position: -webkit-sticky !important;
            position: sticky !important;
            top: 100px !important;
            z-index: 999;
            background: #f8fafc !important; /* Matches g-bg-color--sky-light background */
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            margin-bottom: 25px !important;
        }
        .profil-sidebar-card {
            position: static !important;
            padding: 10px !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
            border: 1px solid #e2e8f0 !important;
        }
        #profil-nav {
            display: flex !important;
            flex-wrap: nowrap !important;
            width: 100% !important;
            padding-bottom: 0;
            margin-bottom: 0;
            gap: 6px;
        }
        #profil-nav li {
            flex: 1 1 0% !important;
            text-align: center;
            margin-bottom: 0 !important;
        }
        #profil-nav li a {
            display: block !important;
            text-align: center;
            white-space: nowrap !important;
            padding: 8px 4px !important;
            font-size: 12px !important;
        }
        /* Mobile: larger scroll offset to clear both sticky header + tab bar */
        #profil-singkat, #sejarah, #geografis, #wilayah-dusun {
            scroll-margin-top: 220px;
        }
    }
</style>

<div class="g-bg-color--sky-light g-padding-y-60--xs">
    <div class="container">
        <div class="row" style="display: flex; flex-wrap: wrap;">
            <div id="profil-sidebar-col" class="col-md-3 col-xs-12 g-margin-b-30--xs g-margin-b-0--md">
                <!-- Sidebar Navigation -->
                <div class="profil-sidebar-card">
                    <h3 class="g-font-size-16--xs g-font-weight--700 g-margin-b-15--xs hidden-xs" style="color: #2d3748; padding-bottom: 10px; border-bottom: 2px solid #e2e8f0;">Navigasi Profil</h3>
                    <ul class="list-unstyled g-margin-b-0--xs" id="profil-nav">
                        <li class="g-margin-b-10--xs">
                            <a href="#profil-singkat" class="g-color--text g-color--primary--hover active" style="display: block; font-weight: 600; padding: 8px 12px; border-radius: 6px; background: #f8f9fa; color: #dc3545;">
                                <span class="hidden-xs">Profil Singkat</span>
                                <span class="visible-xs">Profil</span>
                            </a>
                        </li>
                        <li class="g-margin-b-10--xs">
                            <a href="#sejarah" class="g-color--text g-color--primary--hover" style="display: block; font-weight: 600; padding: 8px 12px; border-radius: 6px;">
                                <span class="hidden-xs">Sejarah Desa</span>
                                <span class="visible-xs">Sejarah</span>
                            </a>
                        </li>
                        <li class="g-margin-b-10--xs">
                            <a href="#geografis" class="g-color--text g-color--primary--hover" style="display: block; font-weight: 600; padding: 8px 12px; border-radius: 6px;">
                                <span class="hidden-xs">Kondisi Geografis</span>
                                <span class="visible-xs">Geografis</span>
                            </a>
                        </li>
                        <li class="g-margin-b-0--xs">
                            <a href="#wilayah-dusun" class="g-color--text g-color--primary--hover" style="display: block; font-weight: 600; padding: 8px 12px; border-radius: 6px;">
                                <span class="hidden-xs">Pembagian Wilayah</span>
                                <span class="visible-xs">Wilayah</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-9">
                <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 40px; border: 1px solid #e2e8f0;">
                    
                    @php
                        $sections = ['profil-singkat', 'sejarah', 'geografis', 'wilayah-dusun'];
                    @endphp

                    @foreach($sections as $index => $key)
                        @if(isset($identities[$key]))
                            <div id="{{ $key }}" style="{{ $index > 0 ? 'padding-top: 40px; margin-top: 40px; border-top: 1px dashed #e2e8f0;' : '' }}">
                                <h2 class="g-font-size-24--xs g-font-weight--700 g-margin-b-20--xs" style="color: #2d3748;">
                                    <span style="display: inline-block; width: 4px; height: 24px; background: #dc3545; vertical-align: middle; margin-right: 10px; border-radius: 4px;"></span>
                                    {{ $identities[$key]->title }}
                                </h2>
                                
                                @if($identities[$key]->image_path)
                                    <div class="g-margin-b-25--xs">
                                        <img src="{{ asset('storage/'.$identities[$key]->image_path) }}" alt="{{ $identities[$key]->title }}" class="img-responsive" style="border-radius: 12px; width: 100%; max-height: 400px; object-fit: cover;">
                                    </div>
                                @endif
                                
                                <div class="g-font-size-15--xs" style="line-height: 1.8; color: #4a5568;">
                                    {!! nl2br(e($identities[$key]->content)) !!}
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Simple smooth scroll and active state for navigation
        $('#profil-nav a').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Stop theme smooth scroll bubble
            
            var target = $(this).attr('href');
            var targetEl = $(target);
            
            // Remove active styles from all
            $('#profil-nav a').removeClass('active').css({'background': 'transparent', 'color': '#718096'});
            
            // Add active style to clicked
            $(this).addClass('active').css({'background': '#f8f9fa', 'color': '#dc3545'});
            
            if (targetEl.length) {
                // Smooth scroll (offset for sticky nav, larger on mobile due to sticky tabs)
                var offset = $(window).width() < 992 ? 220 : 120;
                $('html, body').animate({
                    scrollTop: targetEl.offset().top - offset
                }, 500);
            }
        });

        // Update active class on scroll
        $(window).on('scroll', function() {
            var scrollPos = $(document).scrollTop();
            var offset = $(window).width() < 992 ? 230 : 130;
            $('#profil-nav a').each(function() {
                var currLink = $(this);
                var refElement = $(currLink.attr('href'));
                if (refElement.length) {
                    var elementTop = refElement.offset().top - offset;
                    var elementBottom = elementTop + refElement.outerHeight();
                    if (scrollPos >= elementTop && scrollPos < elementBottom) {
                        $('#profil-nav a').removeClass('active').css({'background': 'transparent', 'color': '#718096'});
                        currLink.addClass('active').css({'background': '#f8f9fa', 'color': '#dc3545'});
                    }
                }
            });
        });
    });
</script>
@endsection
