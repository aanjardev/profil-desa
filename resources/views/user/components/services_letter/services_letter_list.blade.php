<style>
    .letter-sidebar-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        position: -webkit-sticky;
        position: sticky;
        top: 100px;
        z-index: 10;
        overflow: hidden;
    }
    .vertical-tab-letter-item {
        transition: all 0.2s ease;
    }
    .vertical-tab-letter-item.active {
        background-color: #f8f9fa !important;
        color: #dc3545 !important;
        border-left: 4px solid #dc3545 !important;
    }
    .letter-section {
        scroll-margin-top: 130px;
    }
    
    @media (max-width: 991px) {
        .letter-mobile-nav {
            position: -webkit-sticky !important;
            position: sticky !important;
            top: 100px !important;
            z-index: 999;
            margin-bottom: 25px !important;
            padding-top: 15px;
            padding-bottom: 10px;
            background: #f8fafc;
        }
        .letter-section {
            scroll-margin-top: 150px;
        }
        
        /* Custom Modern Dropdown Styles */
        .custom-modern-dropdown {
            width: 100%;
        }
        .modern-dropdown-toggle {
            width: 100%;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 14px 20px !important;
            background: #fff !important;
            border: 2px solid #e2e8f0 !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important;
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 600 !important;
            font-size: 15px !important;
            color: #1e293b !important;
            transition: all 0.3s ease !important;
        }
        .modern-dropdown-toggle:hover, .modern-dropdown-toggle:focus, .custom-modern-dropdown.open .modern-dropdown-toggle {
            border-color: #dc3545 !important;
            box-shadow: 0 4px 20px rgba(220, 53, 69, 0.15) !important;
            background: #fff !important;
            outline: none !important;
        }
        .dropdown-content-left {
            display: flex;
            align-items: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 15px;
        }
        .selected-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .modern-dropdown-toggle .toggle-icon {
            font-size: 12px;
            color: #64748b;
            transition: transform 0.3s ease;
        }
        .custom-modern-dropdown.open .modern-dropdown-toggle .toggle-icon {
            transform: rotate(180deg);
        }
        .modern-dropdown-menu {
            width: 100%;
            margin-top: 8px !important;
            padding: 10px !important;
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
            max-height: 350px !important;
            overflow-y: auto !important;
            background: #fff !important;
        }
        .modern-dropdown-menu::-webkit-scrollbar {
            width: 6px;
        }
        .modern-dropdown-menu::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .modern-dropdown-menu li a {
            padding: 12px 15px !important;
            border-radius: 8px !important;
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            color: #475569 !important;
            transition: all 0.2s ease !important;
            margin-bottom: 4px;
            white-space: normal !important;
            line-height: 1.5;
        }
        .dropdown-item-content {
            display: flex;
            align-items: flex-start;
        }
        .item-icon {
            margin-right: 10px;
            color: #94a3b8;
            margin-top: 2px;
        }
        .modern-dropdown-menu li a:hover, .modern-dropdown-menu li a.active {
            background-color: #fef2f2 !important;
            color: #dc3545 !important;
        }
        .modern-dropdown-menu li a:hover .item-icon, .modern-dropdown-menu li a.active .item-icon {
            color: #dc3545 !important;
        }
    }
</style>

<div class="container g-padding-y-80--xs"> 
        @if($letters->count() > 0)
            <div class="row" style="display: flex; flex-wrap: wrap;">
                <div class="col-md-4 hidden-sm hidden-xs" id="letter-sidebar-col">
                    <div class="list-group vertical-tabs-wrapper letter-sidebar-card">
                        @foreach($letters as $key => $letter)
                            <a href="#letter-tab-{{ $letter->id }}" class="list-group-item vertical-tab-letter-item {{ $key === 0 ? 'active' : '' }}" style="padding: 18px 20px; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 14px; border: none; border-bottom: 1px solid #eee; border-left: 4px solid transparent; color: #555; white-space: normal; word-wrap: break-word; line-height: 1.5;">
                                {{ $letter->letter_name ?? 'Nama Surat Tidak Ditemukan' }}
                                <i class="ti-angle-right pull-right hidden-sm hidden-xs" style="margin-top: 3px; font-size: 11px;"></i>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-8 col-sm-12 col-xs-12">
                    <!-- Mobile Navigation Dropdown (Custom Modern) -->
                    <div class="visible-xs visible-sm letter-mobile-nav">
                        <div class="dropdown custom-modern-dropdown">
                            <button class="btn dropdown-toggle modern-dropdown-toggle" type="button" id="mobileLetterNav" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <div class="dropdown-content-left">
                                    <i class="ti-menu-alt" style="margin-right: 10px; color: #dc3545;"></i>
                                    <span id="selectedLetterText" class="selected-text">{{ $letters->first()->letter_name ?? 'Pilih Surat...' }}</span>
                                </div>
                                <i class="ti-angle-down toggle-icon"></i>
                            </button>
                            <ul class="dropdown-menu modern-dropdown-menu" aria-labelledby="mobileLetterNav">
                                @foreach($letters as $key => $letter)
                                    <li>
                                        <a href="#letter-tab-{{ $letter->id }}" class="mobile-nav-item {{ $key === 0 ? 'active' : '' }}" data-title="{{ $letter->letter_name }}">
                                            <div class="dropdown-item-content">
                                                <span class="item-icon"><i class="ti-file"></i></span>
                                                <span class="item-text">{{ $letter->letter_name }}</span>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 40px; border: 1px solid #e2e8f0;">
                        
                       @foreach($letters as $key => $letter)
                            <div class="letter-section" id="letter-tab-{{ $letter->id }}" style="{{ $key > 0 ? 'padding-top: 40px; margin-top: 40px; border-top: 1px dashed #e2e8f0;' : '' }}">
                                
                                <div class="tab-main-body" style="margin-bottom: 30px;">
                                    <div style="display: flex; align-items: center; margin-bottom: 25px;">
                                        <div style="width: 4px; height: 26px; background-color: #dc3545; border-radius: 2px; margin-right: 12px;"></div>
                                        <h3 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0; font-family: 'Montserrat', sans-serif;">
                                            {{ $letter->letter_name }}
                                        </h3>
                                    </div>

                                    <div class="g-margin-b-15--xs">
                                        <span style="font-size: 12px; text-transform: uppercase; color: #dc3545; font-family: 'Montserrat', sans-serif; font-weight: 600; letter-spacing: 0.5px;">Persyaratan Dokumen:</span>
                                    </div>

                                    <div class="letter-requirements-content" style="color: #475569; font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.8;">
                                        {!! $letter->parsed_requirements !!}
                                    </div>
                                </div>
                                <div style="padding-top: 20px; border-top: 1px dashed #e2e8f0;">
                                    <div class="row" style="display: flex; align-items: center;">
                                        <div class="col-xs-6">
                                            <p style="margin-bottom: 4px; font-family: 'Montserrat', sans-serif; font-size: 12px; color: #1e293b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Estimasi Waktu</p>
                                            <span style="font-family: 'Montserrat', sans-serif; font-size: 14px; font-weight: 600; color: #1e293b;">
                                                <i class="ti-timer" style="color: #dc3545; margin-right: 5px;"></i> {{ $letter->estimated_time ?? 'Tidak ditentukan' }}
                                            </span>
                                        </div>
                                        <div class="col-xs-6">
                                            <p style="margin-bottom: 4px; font-family: 'Montserrat', sans-serif; font-size: 12px; color: #1e293b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Biaya Layanan</p>
                                            <span style="font-family: 'Montserrat', sans-serif; font-size: 14px; font-weight: 600; color: #25D366;">
                                                <i class="ti-wallet" style="margin-right: 5px;"></i> {{ $letter->fee ?? 'Gratis' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-xs-12 text-center" style="padding: 80px 0;">
                    <i class="ti-files g-font-size-60--xs" style="font-family: 'Montserrat', sans-serif; color: #ccc; display: block; margin-bottom: 20px;"></i>
                    <h3 class="g-font-size-20--xs g-font-weight--600" style="color: #444; font-family: 'Montserrat', sans-serif;">Data Belum Tersedia</h3>
                    <p class="g-font-size-14--xs g-color--gray-dark" style="font-family: 'Montserrat', sans-serif; max-width: 500px; color: #dc3545; margin: 0 auto; line-height: 1.6;">
                        Belum ada jenis layanan surat yang di-up oleh pihak admin pelayanan Desa Tulungrejo.
                    </p>
                </div>
            </div>
        @endif

    </div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Smooth scroll on click
        $('.vertical-tab-letter-item').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var target = $(this).attr('href');
            var targetEl = $(target);
            
            $('.vertical-tab-letter-item').removeClass('active');
            $(this).addClass('active');
            
            if (targetEl.length) {
                var offset = $(window).width() < 992 ? 150 : 130;
                $('html, body').animate({
                    scrollTop: targetEl.offset().top - offset
                }, 500);
            }
        });

        // Custom Mobile Dropdown Change
        $('.mobile-nav-item').on('click', function(e) {
            e.preventDefault();
            
            var target = $(this).attr('href');
            var title = $(this).data('title');
            
            // Update button text and active state
            $('#selectedLetterText').text(title);
            $('.mobile-nav-item').removeClass('active');
            $(this).addClass('active');
            
            if (target) {
                var offset = 140;
                $('html, body').animate({
                    scrollTop: $(target).offset().top - offset
                }, 500);
            }
        });

        // Update active nav item on scroll (Scrollspy)
        $(window).on('scroll', function() {
            var scrollPos = $(document).scrollTop();
            var offset = $(window).width() < 992 ? 160 : 140;
            
            $('.vertical-tab-letter-item').each(function() {
                var currLink = $(this);
                var refElement = $(currLink.attr('href'));
                
                if (refElement.length) {
                    var elementTop = refElement.offset().top - offset;
                    var elementBottom = elementTop + refElement.outerHeight();
                    
                    if (scrollPos >= elementTop && scrollPos < elementBottom) {
                        $('.vertical-tab-letter-item').removeClass('active');
                        currLink.addClass('active');
                        
                        // Update mobile custom dropdown
                        if ($(window).width() < 992) {
                            var mobileItem = $('.mobile-nav-item[href="' + currLink.attr('href') + '"]');
                            if (mobileItem.length && !mobileItem.hasClass('active')) {
                                $('.mobile-nav-item').removeClass('active');
                                mobileItem.addClass('active');
                                $('#selectedLetterText').text(mobileItem.data('title'));
                            }
                        }
                    }
                }
            });
        });
    });
</script>
@endsection