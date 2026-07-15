<div class="container g-padding-y-80--xs">
    <div class="row">
        @forelse($contacts as $index => $contact)
            <div class="col-xs-12 g-margin-b-20--xs">
                <div class="g-bg-color--white contact-box-card">  
                    <div data-toggle="collapse" data-target="#collapseContact-{{ $index }}" aria-expanded="false" class="contact-box-name collapsed toggle-collapse-link" style="cursor: pointer; display: flex; justify-content: space-between; align-items: center; padding: 20px;">
                        <span class="g-font-size-16--xs g-font-weight--600 text-uppercase">
                            {{ $contact->name }}
                        </span>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            @php
                                $waPhone = preg_replace('/[^0-9]/', '', $contact->phone);
                                if (substr($waPhone, 0, 1) == '0') {
                                    $waPhone = '62' . substr($waPhone, 1);
                                }
                            @endphp
                            
                            @if($waPhone)
                                <a href="https://wa.me/{{ $waPhone }}" target="_blank" class="btn btn-xs" style="background: #25D366; color: #fff; border-radius: 20px; font-weight: 600; padding: 6px 14px; font-size: 12px; letter-spacing: 0.5px; border: none; text-transform: none; text-decoration: none;" onclick="event.stopPropagation();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 4px; display: inline-block; vertical-align: text-top;"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg> Hubungi
                                </a>
                            @endif

                            <span class="g-font-size-14--xs g-font-weight--600 hidden-xs" style="color: #444; font-family: 'Montserrat', sans-serif;">
                                {{ $contact->phone }}
                            </span>
                            <i class="ti-angle-down arrow-icon" style="transition: transform 0.3s ease; font-size: 11px; color: #999;"></i>
                        </div>
                    </div>
                    <div id="collapseContact-{{ $index }}" class="collapse">
                        <div class="detail-contact-info">
                            <div class="visible-xs" style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 5px;">Nomor Telepon</label>
                                <span style="font-size: 15px; font-weight: 600; color: #1e293b; font-family: 'Montserrat', sans-serif;">
                                    <i class="ti-mobile" style="color: #dc3545; margin-right: 5px;"></i> {{ $contact->phone }}
                                </span>
                            </div>                
                            @if($contact->category)
                                <div class="category-contact-info">
                                    <label>Kategori</label>
                                    <span>{{ $contact->category }}</span>
                                </div>
                            @endif
                            <div class="description-contact-info">
                                <label>Deskripsi Singkat</label>
                                <p> {{ $contact->description ?? 'Tidak ada deskripsi operasional yang dicantumkan.' }}</p>
                            </div>
                            <div class="address-contact-info">
                                <label>Alamat Lengkap</label>
                                <p>
                                    <i class="ti-location-pin"></i> 
                                    {{ $contact->address ?? 'Alamat tidak tersedia.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="not-available-contact col-xs-12 text-center g-padding-y-60--xs">
                <i class="ti-alert g-font-size-40--xs"></i>
                <p class="g-font-size-16--xs g-color--gray">Belum ada data kontak darurat yang diaktifkan oleh admin.</p>
            </div>
        @endforelse
    </div>
</div>