<div class="container g-padding-y-80--xs">
    @if($serviceInfo)
        <div class="row">
            <!-- Sisi Kiri: Menu Tab -->
            <div class="col-md-4 col-sm-5 g-margin-b-30--xs g-margin-b-0--md">
                <div class="online_administration_list_menu">
                    <div class="online_administration_menu_title">Layanan Administrasi Online</div>
                    @foreach($menus as $key => $menu)
                        <a href="#tab-{{ $menu['id'] }}" class="list-group-item vertical-tab-item {{ $key === 0 ? 'active' : '' }}" data-toggle="tab" role="tab">
                            {{ $menu['title'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Sisi Ranan: Box Detail Layanan -->
            <div class="col-md-8 col-sm-7">
                <div class="tab-content g-bg-color--white" style="padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); min-height: 400px; display: flex; flex-direction: column; justify-content: space-between; background: #fff;">
                    
                    <div class="tab-only-content">
                        <div class="g-margin-b-30--xs">
                            <div style="display: flex; align-items: center; margin-bottom: 25px; padding-top: 10px;">
                                <div style="width: 4px; height: 26px; background-color: #dc3545; border-radius: 2px; margin-right: 12px;"></div>
                                <h3 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0; font-family: 'Montserrat', sans-serif;">
                                    {{ $serviceInfo->service_name }}
                                </h3>
                            </div>
                            
                            @if($serviceInfo->description)
                                <p style="white-space: pre-line; font-size: 14px; color: #475569; line-height: 1.8; font-family: 'Montserrat', sans-serif;">
                                    {{ $serviceInfo->description }}
                                </p>
                            @else
                                <div class="text-center" style="padding: 40px 0; border: 2px dashed #f1f5f9; border-radius: 8px;">
                                    <i class="ti-info-alt g-font-size-26--xs" style="color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                                    <p class="g-font-size-13--xs" style="color: #64748b; font-family: 'Montserrat', sans-serif; margin-bottom: 0;">Detail informasi persyaratan belum di-upload oleh admin pelayanan.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div style="margin-top: 40px; padding-top: 25px; border-top: 1px dashed #e2e8f0;">
                        <div class="row" style="display: flex; align-items: center; flex-wrap: wrap; justify-content: space-between;">
                            
                            {{-- Info Petugas & Jam --}}
                            <div class="col-sm-7 col-xs-12 g-margin-b-15--xs g-margin-b-0--sm" style="font-family: 'Montserrat', sans-serif;">
                                <p style="margin-bottom: 6px; font-size: 13px; color: #64748b;">
                                    <i class="ti-user" style="color: #94a3b8; margin-right: 6px;"></i> Petugas: <strong style="color: #1e293b;">{{ $serviceInfo->officer_name ?? 'Belum Ditentukan' }}</strong>
                                </p>
                                <p style="margin-bottom: 0; font-size: 13px; color: #64748b;">
                                    <i class="ti-time" style="color: #94a3b8; margin-right: 6px;"></i> Jam Operasional: <span style="color: #dc3545; font-weight: 600;">{{ $serviceInfo->office_hours ?? '-' }}</span>
                                </p>
                            </div>
                         
                            <div class="col-sm-5 col-xs-12 text-right" style="text-align: right;">
                                @if($serviceInfo->phone)
                                    @php
                                        $waAdmin = preg_replace('/[^0-9]/', '', $serviceInfo->phone);
                                        if (substr($waAdmin, 0, 1) === '0') {
                                            $waAdmin = '62' . substr($waAdmin, 1);
                                        }
                                    @endphp
                                    <a href="https://wa.me/{{ $waAdmin }}?text=Halo%20{{ rawurlencode($serviceInfo->officer_name ?? 'Admin') }},%20saya%20ingin%20mengajukan%20permohonan%20administrasi%20online." 
                                       target="_blank" 
                                       rel="noopener noreferrer" 
                                       style="display: inline-flex; align-items: center; color: #dc3545; font-weight: 600; font-size: 14px; text-decoration: none; font-family: 'Montserrat', sans-serif; transition: color 0.2s;">
                                        <i class="ti-comments" style="margin-right: 6px; font-size: 16px;"></i> Hubungi Petugas
                                    </a>
                                @else
                                    <span style="color: #cbd5e1; font-weight: 600; font-size: 14px; font-family: 'Montserrat', sans-serif;">
                                        WhatsApp Tidak Tersedia
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    @else
        <!-- Tampilan jika tabel database kosong -->
        <div class="row online_administration_not_available">
            <div class="col-xs-12 text-center">
                <div class="online_administration_not_available_detail">
                    <i class="ti-folder g-font-size-50--xs"></i>
                    <h3 class="g-font-size-20--xs g-font-weight--500">Layanan Belum Di-up</h3>
                    <p class="g-font-size-14--xs g-color--gray-dark" style="line-height: 1.6; margin-bottom: 0; font-family: 'Montserrat', sans-serif; color: #dc3545;">
                        Layanan administrasi online saat ini belum di-up atau dikonfigurasi aktif oleh pihak admin pelayanan Desa Tulungrejo.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>