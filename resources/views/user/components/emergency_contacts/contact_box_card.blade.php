<div class="container g-padding-y-80--xs">
    <div class="row">
        @forelse($contacts as $index => $contact)
            <div class="col-xs-12 g-margin-b-20--xs">
                <div class="g-bg-color--white contact-box-card">  
                    <a href="#collapseContact-{{ $index }}" data-toggle="collapse" aria-expanded="false" class="contact-box-name collapsed toggle-collapse-link">
                        <span class="g-font-size-16--xs g-font-weight--600 text-uppercase">
                            {{ $contact->name }}
                        </span>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <span class="g-font-size-14--xs g-font-weight--600" style="color: #444; font-family: 'Montserrat', sans-serif;">
                                {{ $contact->phone }}
                            </span>
                            <i class="ti-angle-down arrow-icon" style="transition: transform 0.3s ease; font-size: 11px; color: #999;"></i>
                        </div>
                    </a>
                    <div id="collapseContact-{{ $index }}" class="collapse">
                        <div class="detail-contact-info">                
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