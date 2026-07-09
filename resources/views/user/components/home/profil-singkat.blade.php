<div id="profil" class="g-bg-color--white">
    <div class="container g-padding-y-80--xs g-padding-y-125--sm">
        <div class="row">
            <div class="col-sm-6 g-margin-b-40--xs g-margin-b-0--md">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs g-margin-b-30--xs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab-profil" aria-controls="tab-profil" role="tab" data-toggle="tab" class="g-font-size-14--xs g-font-size-18--md g-font-weight--700 text-uppercase">Profil</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab-sejarah" aria-controls="tab-sejarah" role="tab" data-toggle="tab" class="g-font-size-14--xs g-font-size-18--md g-font-weight--700 text-uppercase">Sejarah</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab-geografis" aria-controls="tab-geografis" role="tab" data-toggle="tab" class="g-font-size-14--xs g-font-size-18--md g-font-weight--700 text-uppercase">Geografis</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab-wilayah" aria-controls="tab-wilayah" role="tab" data-toggle="tab" class="g-font-size-14--xs g-font-size-18--md g-font-weight--700 text-uppercase">Wilayah</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content g-margin-b-40--xs">
                    <div role="tabpanel" class="tab-pane fade in active" id="tab-profil">
                        <div class="g-font-size-14--xs g-font-size-16--md g-color--dark" style="line-height: 1.8;">
                            {!! $profil_singkat !!}
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab-sejarah">
                        <div class="g-font-size-14--xs g-font-size-16--md g-color--dark" style="line-height: 1.8;">
                            {!! $sejarah !!}
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab-geografis">
                        <div class="g-font-size-14--xs g-font-size-16--md g-color--dark" style="line-height: 1.8;">
                            {!! $geografis !!}
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab-wilayah">
                        <div class="g-font-size-14--xs g-font-size-16--md g-color--dark" style="line-height: 1.8;">
                            {!! $pembagian_wilayah !!}
                        </div>
                    </div>
                </div>

                <a href="{{ route('profil-desa') }}" class="text-uppercase s-btn s-btn--md s-btn--primary-brd g-radius--50 g-padding-x-40--xs">Selengkapnya</a>
            </div>
            
            <div class="col-sm-6 text-center">
                @if(isset($setting) && $setting->maps_embed)
                    <div class="g-margin-t-40--xs g-margin-t-0--md" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                        {!! str_replace('<iframe ', '<iframe style="width: 100%; height: 400px; border: 0;" ', $setting->maps_embed) !!}
                    </div>
                @else
                    <!-- Fallback placeholder Map -->
                    <div class="g-bg-color--gray-light g-padding-y-120--xs g-margin-t-40--xs g-margin-t-0--md" style="border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <i class="ti-map-alt g-font-size-40--xs g-color--primary g-margin-b-10--xs"></i>
                        <span class="g-font-size-16--xs g-color--dark">Peta Belum Diatur</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
