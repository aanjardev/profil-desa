<!-- FA Questions Text -->
<div id="js__scroll-to-section" class="g-padding-y-80--xs g-padding-y-125--sm">
    <h2 class="g-font-size-32--xs g-font-size-36--md g-text-center--xs g-margin-b-80--xs">Apa yang sering <br> mereka tanyakan?</h2>
    <div class="container">
        <div class="row">
            @forelse($groupedFaqs->chunk(ceil($groupedFaqs->count() / 2)) as $chunkIndex => $chunk)
                <div class="col-md-6 col-xs-12">
                    @foreach($chunk as $category => $faqList)
                        
                        <div class="g-margin-b-40--xs">
                            <h3 class="g-font-size-16--xs g-font-weight--600 text-uppercase" style="color: #333; font-family: 'Montserrat', sans-serif; border-bottom: 2px solid #17bedb; display: inline-block; padding-bottom: 4px; margin-bottom: 15px;">
                                <i class="ti-bookmark-alt" style="color: #17bedb; margin-right: 6px;"></i>{{ $category ?? 'Umum' }}
                            </h3>

                            @foreach($faqList as $index => $faq)
                                @php 
                                    $uniqueId = 'faq-' . $chunkIndex . '-' . Str::slug($category) . '-' . $index; 
                                @endphp
                                
                                <div class="g-margin-b-10--xs">
                                    <div class="g-bg-color--white faq-box-card" style="border-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); transition: all 0.3s ease; overflow: hidden; border-left: 4px solid #17bedb;">
                                        
                                        <a href="#collapseFaq-{{ $uniqueId }}" data-toggle="collapse" aria-expanded="false" class="collapsed toggle-faq-link" style="display: block; padding: 18px 20px; text-decoration: none; color: #333; position: relative;">
                                            <span class="g-font-size-14--xs g-font-weight--600" style=" line-height: 1.5; padding-right: 25px; display: block;">
                                                <span style="color: #17bedb; margin-right: 3px; font-family: 'Moontserrat', sans-serif">Q:</span> {{ $faq->question }}
                                            </span>
                                            <i class="ti-angle-down arrow-icon" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); transition: transform 0.3s ease; font-size: 10px; color: #999;"></i>
                                        </a>

                                        <div id="collapseFaq-{{ $uniqueId }}" class="collapse">
                                            <div class="faq-html-content" style="padding: 0 20px 20px 20px; border-top: 1px solid #f9f9f9; color: #555; font-size: 13px; line-height: 1.6; background-color: #fbfbfb;">
                                                <div style="margin-top: 12px; font-family: 'Moontserrat', sans-serif">
                                                    {!! $faq->parsed_answer !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
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