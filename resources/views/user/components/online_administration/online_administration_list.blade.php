<div class="container g-padding-y-80--xs">
    @if($serviceInfo)
        <div class="row">
            <div class="col-md-4 col-sm-5 g-margin-b-30--xs g-margin-b-0--md">
                <div class="list-group vertical-tabs-wrapper online_administration_list_menu" role="tablist">
                    @foreach($menus as $key => $menu)
                        <a href="#tab-{{ $menu['id'] }}" class="list-group-item vertical-tab-item {{ $key === 0 ? 'active' : '' }}" data-toggle="tab" role="tab">
                            {{ $menu['title'] }}
                            <i class="ti-angle-right pull-right"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-md-8 col-sm-7">
                <div class="tab-content g-bg-color--white online_administration_content">
                    
                    <div class="tab-only-content">
                        <div class="g-margin-b-30--xs online_administration_tab_content">
                            <h3 class="g-font-size-22--xs g-font-weight--600"> {{ $serviceInfo->service_name }} </h3>
                            
                            @if($serviceInfo->description)
                                <p> {{ $serviceInfo->description }} </p>
                            @else
                                <div class="text-center online_administration_description">
                                    <i class="ti-info-alt g-font-size-26--xs"></i>
                                    <p class="g-color--gray-dark g-font-size-13--xs">Detail informasi persyaratan belum di-upload oleh admin pelayanan.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="online_administration_detail_1">
                        <div class="row online_administration_detail_2">
                            <div class="col-sm-7 col-xs-12 g-margin-b-15--xs g-margin-b-0--sm online_administration_name_hours">
                                <p><i class="ti-user"></i> Petugas: <strong>{{ $serviceInfo->officer_name ?? 'Belum Ditentukan' }}</strong></p>
                                <p><i class="ti-time"></i> Jam Operasional: <span class="text-primary" style="font-weight: 500;">{{ $serviceInfo->office_hours ?? '-' }}</span></p>
                            </div>
                         
                            <div class="col-sm-5 col-xs-12 online_administration_phone">
                                @if($serviceInfo->phone)
                                    @php
                                        $waAdmin = preg_replace('/[^0-9]/', '', $serviceInfo->phone);
                                        if (substr($waAdmin, 0, 1) === '0') {
                                            $waAdmin = '62' . substr($waAdmin, 1);
                                        }
                                    @endphp
                                    <a href="https://wa.me/{{ $waAdmin }}?text=Halo%20{{ rawurlencode($serviceInfo->officer_name ?? 'Admin') }},%20saya%20ingin%20mengajukan%20permohonan%20administrasi%20online." target="_blank" rel="noopener noreferrer" class="btn-block text-center">
                                        <i class="ti-comments"></i> Hubungi Petugas
                                    </a>
                                @else
                                    <button class="btn-block text-center" disabled>
                                        WhatsApp Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-xs-12 text-center online_administration_not_available">
                <div class="online_administration_not_available_detail">
                    <i class="ti-folder g-font-size-60--xs"></i>
                    <h3 class="g-font-size-20--xs g-font-weight--600">Layanan Belum Di-up</h3>
                    <p class="g-font-size-14--xs g-color--gray-dark">
                        Layanan administrasi online saat ini belum di-up atau dikonfigurasi aktif oleh pihak admin pelayanan Desa Tulungrejo.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>