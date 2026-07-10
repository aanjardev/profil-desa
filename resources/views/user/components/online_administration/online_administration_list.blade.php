<div class="container">
    {{-- Memeriksa apakah data serviceInfo ada di database --}}
    @if($serviceInfo)
        <div class="row">
            <div class="col-md-4 col-sm-5 g-margin-b-30--xs g-margin-b-0--md">
                <div class="list-group vertical-tabs-wrapper" role="tablist" style="box-shadow: 0 4px 12px rgba(0,0,0,0.03); border-radius: 4px; overflow: hidden; background: #fff;">
                    @foreach($menus as $key => $menu)
                        <a href="#tab-{{ $menu['id'] }}" class="list-group-item vertical-tab-item {{ $key === 0 ? 'active' : '' }}" data-toggle="tab" role="tab" style="padding: 18px 20px; font-weight: 600; font-size: 14px; border: none; border-bottom: 1px solid #eee; color: #555; transition: all 0.2s ease;">
                            {{ $menu['title'] }}
                            <i class="ti-angle-right pull-right" style="margin-top: 3px; font-size: 11px;"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-md-8 col-sm-7">
                <div class="tab-content g-bg-color--white" style="padding: 40px; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); min-height: 400px; display: flex; flex-direction: column; justify-content: space-between;">
                    
                    <div class="tab-only-content">
                        <div class="g-margin-b-30--xs">
                            <h3 class="g-font-size-22--xs g-font-weight--600" style="color: #333; margin-bottom: 10px;">
                                {{ $serviceInfo->service_name }}
                            </h3>
                            
                            {{-- Kondisi jika deskripsi kosong dari admin, munculkan informasi placeholder --}}
                            @if($serviceInfo->description)
                                <p style="font-size: 14px; color: #666; line-height: 1.7;">
                                    {{ $serviceInfo->description }}
                                </p>
                            @else
                                <div class="text-center" style="padding: 40px 0; border: 2px dashed #f5f5f5; border-radius: 4px;">
                                    <i class="ti-info-alt g-font-size-26--xs" style="color: #ccc; display: block; margin-bottom: 10px;"></i>
                                    <p class="g-color--gray-dark g-font-size-13--xs" style="margin-bottom: 0;">Detail informasi persyaratan belum di-upload oleh admin pelayanan.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div style="margin-top: 40px; padding-top: 20px; border-top: 1px dashed #eee;">
                        <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                            <div class="col-sm-7 col-xs-12 g-margin-b-15--xs g-margin-b-0--sm">
                                <p style="margin-bottom: 3px; font-size: 13px; color: #888;">
                                    <i class="ti-user" style="margin-right: 5px;"></i> Petugas: <strong>{{ $serviceInfo->officer_name ?? 'Belum Ditentukan' }}</strong>
                                </p>
                                <p style="margin-bottom: 0; font-size: 13px; color: #888;">
                                    <i class="ti-time" style="margin-right: 5px;"></i> Jam Operasional: <span class="text-primary" style="font-weight: 500;">{{ $serviceInfo->office_hours ?? '-' }}</span>
                                </p>
                            </div>
                         
                            <div class="col-sm-5 col-xs-12">
                                @if($serviceInfo->phone)
                                    @php
                                        // UBAH DISINI: Menggunakan kolom phone sesuai migration
                                        $waAdmin = preg_replace('/[^0-9]/', '', $serviceInfo->phone);
                                        if (substr($waAdmin, 0, 1) === '0') {
                                            $waAdmin = '62' . substr($waAdmin, 1);
                                        }
                                    @endphp
                                    <a href="https://wa.me/{{ $waAdmin }}?text=Halo%20{{ rawurlencode($serviceInfo->officer_name ?? 'Admin') }},%20saya%20ingin%20mengajukan%20permohonan%20administrasi%20online." target="_blank" rel="noopener noreferrer" class="btn-block text-center" style="padding: 12px 20px; background-color: #25D366; color: #fff; font-weight: 600; text-transform: uppercase; font-size: 12px; border-radius: 4px; box-shadow: 0 4px 10px rgba(37, 211, 102, 0.2); text-decoration: none; display: block;">
                                        <i class="ti-comments" style="margin-right: 5px; font-size: 14px;"></i> Hubungi Petugas
                                    </a>
                                @else
                                    <button class="btn-block text-center" disabled style="padding: 12px 20px; background-color: #ccc; color: #fff; font-weight: 600; text-transform: uppercase; font-size: 12px; border-radius: 4px; border: none; cursor: not-allowed;">
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
            <div class="col-xs-12 text-center" style="padding: 80px 0;">
                <div style="max-width: 550px; margin: 0 auto;">
                    <i class="ti-folder g-font-size-60--xs" style="color: #ccc; display: block; margin-bottom: 20px;"></i>
                    <h3 class="g-font-size-20--xs g-font-weight--600" style="color: #444; font-family: 'Montserrat', sans-serif;">Layanan Belum Di-up</h3>
                    <p class="g-font-size-14--xs g-color--gray-dark" style="line-height: 1.6; margin-bottom: 0;">
                        Layanan administrasi online saat ini belum di-up atau dikonfigurasi aktif oleh pihak admin pelayanan Desa Tulungrejo.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>