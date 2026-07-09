@extends('layouts.user')
@section('content')
<!--========== PAGE CONTENT ==========-->
<div class="g-bg-position--center" style="background-color:#f37979; padding-top: 140px; padding-bottom: 20px;">
    <div class="container">
        <div class="g-text-center--xs">
            <div class="g-margin-t-40--xs g-margin-b-60--xs g-margin-b-80--sm">
                <h1 class="g-font-size-32--xs g-font-size-50--sm g-font-size-60--md g-margin-b-30--xs">Kontak Darurat</h1>
                <p class="text-uppercase g-font-size-20--md g-font-weight--300">Daftar kontak penting yang siap membantu masyarakat Desa kapan pun dibutuhkan.</p>
            </div>                
        </div>
    </div>
    <div class="container">
        <div class="row">
            @forelse($contacts as $index => $contact)
                <div class="col-xs-12 g-margin-b-20--xs">
                    <div class="g-bg-color--white contact-box-card">
                        
                        <a href="#collapseContact-{{ $index }}" data-toggle="collapse" aria-expanded="false" class="contact-box-name collapsed toggle-collapse-link">
                            <span class="g-font-size-16--xs g-font-weight--600 text-uppercase">
                                {{ $contact->name }}
                            </span>
                            <i class="ti-angle-down arrow-icon"></i>
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

                                <div class="phone-contact-info">
                                    <div class="detail-phone-contact-info">
                                        <span>
                                            <i class="ti-headphone-alt"></i>{{ $contact->phone }}
                                        </span>
                                    </div>
                                    
                                    <div class="row g-row-col--5">
                                        <div class="col-xs-12">
                                            @php
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $contact->phone);
                                                if (substr($cleanPhone, 0, 1) === '0') {
                                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                                }
                                            @endphp
                                            <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ rawurlencode($contact->name) }},%20saya%20memerlukan%20bantuan%20darurat." target="_blank" rel="noopener noreferrer" class="text-center" style="display: block; padding: 8px; font-size: 11px; font-weight: 600; text-transform: uppercase; background-color: #25D366; color: #fff; border-radius: 3px; text-decoration: none;">
                                                <i class="ti-comments" style="margin-right: 3px;"></i> WhatsApp
                                            </a>
                                        </div>
                                    </div>
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
</div>

    
<style>
    .toggle-collapse-link[aria-expanded="true"] .arrow-icon {
        transform: translateY(-50%) rotate(-180deg) !important;
        color: #17bedb !important;
    }
    .col-md-4:hover .g-bg-color--white {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.06) !important;
    }
</style>
<!--========== END PAGE CONTENT ==========-->
@endsection