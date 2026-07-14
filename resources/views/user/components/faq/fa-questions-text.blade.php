<!-- FA Questions Text -->
<div id="js__scroll-to-section" class="g-padding-y-80--xs g-padding-y-125--sm">
    <h2 class="g-font-size-32--xs g-font-size-36--md g-text-center--xs g-margin-b-80--xs">Apa yang sering <br> mereka tanyakan?</h2>
    <div class="container">
        <div class="row">
            @forelse($groupedFaqs as $category => $faqList)
                <div class="col-md-3 col-sm-6 col-xs-12 g-margin-b-40--xs">
                
                    <div style="margin-bottom: 20px;">
                        <h3 class="g-font-size-15--xs g-font-weight--600 text-uppercase" style="color: #333; font-family: 'Montserrat', sans-serif; border-bottom: 2px solid rgb(220, 53, 69); display: inline-block; padding-bottom: 4px; margin: 0;">
                            <i class="ti-bookmark-alt" style="color: rgb(220, 53, 69); margin-right: 6px;"></i>{{ $category ?? 'Umum' }}
                        </h3>
                    </div>

                    @foreach($faqList as $index => $faq)
                        @php 
                            $uniqueId = 'faq-' . Str::slug($category) . '-' . $index; 
                        @endphp
                        
                        <div class="g-margin-b-10--xs">
                            <div class="g-bg-color--white faq-box-card" style="border-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); transition: all 0.3s ease; overflow: hidden; border-left: 4px solid rgb(220, 53, 69);">
                                
                                <a href="#collapseFaq-{{ $uniqueId }}" data-toggle="collapse" aria-expanded="false" class="collapsed toggle-faq-link" style="display: block; padding: 15px 15px; text-decoration: none; color: #333; position: relative;">
                                    <span class="g-font-size-15--xs g-font-weight--600" style="line-height: 1.4; padding-right: 20px; display: block; font-family: 'Montserrat', sans-serif;">
                                        <span style="color: rgb(220, 53, 69); margin-right: 2px;">Q:</span> {{ $faq->question }}
                                    </span>
                                    <i class="ti-angle-down arrow-icon" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); transition: transform 0.3s ease; font-size: 9px; color: #999;"></i>
                                </a>

                                <div id="collapseFaq-{{ $uniqueId }}" class="collapse">
                                    <div class="faq-html-content" style="padding: 20px 15px; border-top: 1px solid #f9f9f9; color: #555; font-size: 12px; line-height: 1.6; background-color: #fbfbfb;">
                                        <div style="margin-top: 10px; font-family: 'Montserrat', sans-serif;">
                                            {!! $faq->parsed_answer !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            @empty
                <div class="not-available-faq col-xs-12 text-center g-padding-y-60--xs">
                    <i class="ti-comments g-font-size-40--xs"></i>
                    <p class="g-font-size-16--xs g-color--gray">Belum ada daftar tanya jawab (FAQ) yang diaktifkan oleh admin.</p>
                </div>
            @endforelse
        </div>
        
    </div>
</div>
<!-- End FA Questions Text -->