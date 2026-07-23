<div class="container g-padding-y-80--xs">
    @if($serviceInfo)
        <div class="row">
            <div class="col-md-8 col-sm-10 col-xs-12" style="margin: 0 auto; float: none;">
                <div class="g-bg-color--white" style="padding: 50px 40px; border-radius: 12px; box-shadow: 0 4px 25px rgba(0,0,0,0.05); background: #fff; text-align: center;">
                    
                    <div style="margin-bottom: 25px;">
                        <h3 style="font-size: 26px; font-weight: 700; color: #1e293b; margin: 0; font-family: 'Montserrat', sans-serif;">
                            {{ $serviceInfo->service_name }}
                        </h3>
                        <div style="width: 50px; height: 4px; background-color: #dc3545; border-radius: 2px; margin: 15px auto 0;"></div>
                    </div>
                    
                    @if($serviceInfo->description)
                        <p style="white-space: pre-line; font-size: 15px; color: #475569; line-height: 1.8; font-family: 'Montserrat', sans-serif; margin-bottom: 30px;">
                            {{ $serviceInfo->description }}
                        </p>
                    @else
                        <div class="text-center" style="padding: 30px 0; border: 2px dashed #f1f5f9; border-radius: 8px; margin-bottom: 30px;">
                            <i class="ti-info-alt g-font-size-26--xs" style="color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                            <p class="g-font-size-13--xs" style="color: #64748b; font-family: 'Montserrat', sans-serif; margin-bottom: 0;">Detail informasi persyaratan belum di-upload oleh admin pelayanan.</p>
                        </div>
                    @endif

                    <div style="padding: 25px; background: #f8fafc; border-radius: 10px; margin-bottom: 35px; border: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 10px;">
                        <p style="margin-bottom: 0; font-size: 14px; color: #64748b; font-family: 'Montserrat', sans-serif;">
                            <i class="ti-user" style="color: #94a3b8; margin-right: 6px;"></i> Petugas: <strong style="color: #1e293b;">{{ $serviceInfo->officer_name ?? 'Belum Ditentukan' }}</strong>
                        </p>
                        <p style="margin-bottom: 0; font-size: 14px; color: #64748b; font-family: 'Montserrat', sans-serif;">
                            <i class="ti-time" style="color: #94a3b8; margin-right: 6px;"></i> Jam Operasional: <span style="color: #dc3545; font-weight: 600;">{{ $serviceInfo->office_hours ?? '-' }}</span>
                        </p>
                    </div>
                 
                    <div class="text-center">
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
                               style="display: inline-flex; align-items: center; justify-content: center; background-color: #25D366; color: white; font-weight: 600; font-size: 16px; text-decoration: none; font-family: 'Montserrat', sans-serif; padding: 16px 35px; border-radius: 50px; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3); transition: all 0.3s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 10px;"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg> Hubungi via WhatsApp
                            </a>
                        @else
                            <div style="display: inline-flex; align-items: center; justify-content: center; background-color: #f1f5f9; color: #94a3b8; font-weight: 600; font-size: 16px; font-family: 'Montserrat', sans-serif; padding: 15px 30px; border-radius: 50px;">
                                WhatsApp Tidak Tersedia
                            </div>
                        @endif
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