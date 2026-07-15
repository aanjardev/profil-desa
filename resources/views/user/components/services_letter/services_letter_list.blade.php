<div class="container g-padding-y-80--xs"> 
        @if($letters->count() > 0)
            <div class="row">
                <div class="col-md-4 col-sm-5 g-margin-b-30--xs g-margin-b-0--md">
                    <div class="list-group vertical-tabs-wrapper" role="tablist" style="box-shadow: 0 4px 12px rgba(0,0,0,0.03); border-radius: 4px; overflow: hidden; background: #fff;">
                        @foreach($letters as $key => $letter)
                            <a href="#letter-tab-{{ $letter->id }}" class="list-group-item vertical-tab-letter-item {{ $key === 0 ? 'active' : '' }}" data-toggle="tab" role="tab" style="padding: 18px 20px; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: 14px; border: none; border-bottom: 1px solid #eee; color: #555; transition: all 0.2s ease; white-space: normal; word-wrap: break-word; line-height: 1.5;">
                                {{ $letter->letter_name ?? 'Nama Surat Tidak Ditemukan' }}
                                <i class="ti-angle-right pull-right" style="margin-top: 3px; font-size: 11px;"></i>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-8 col-sm-7">
                    <div class="tab-content g-bg-color--white" style="padding: 0 40px 40px 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); min-height: 400px; background: #fff;">
                        
                       @foreach($letters as $key => $letter)
                            <div class="tab-pane {{ $key === 0 ? 'active' : '' }}" id="letter-tab-{{ $letter->id }}" style="display: flex; flex-direction: column;">
                                
                                <div class="tab-main-body" style="margin-bottom: 80px;">
                                    <div style="display: flex; align-items: center; margin-bottom: 25px; padding-top: 18px;">
                                        <div style="width: 4px; height: 26px; background-color: #dc3545; border-radius: 2px; margin-right: 12px;"></div>
                                        <h3 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0; font-family: 'Montserrat', sans-serif;">
                                            {{ $letter->letter_name }}
                                        </h3>
                                    </div>

                                    <div class="g-margin-b-15--xs">
                                        <span style="font-size: 12px; text-transform: uppercase; color: #dc3545; font-family: 'Montserrat', sans-serif; font-weight: 600; letter-spacing: 0.5px;">Persyaratan Dokumen:</span>
                                    </div>

                                    <div class="letter-requirements-content" style="color: #475569; font-family: 'Montserrat', sans-serif; font-size: 14px; line-height: 1.8;">
                                        {!! $letter->parsed_requirements !!}
                                    </div>
                                </div>
                                <div style="padding-top: 20px; padding-bottom: 15px; border-top: 1px dashed #e2e8f0;">
                                    <div class="row" style="display: flex; align-items: center;">
                                        <div class="col-xs-6">
                                            <p style="margin-bottom: 4px; font-family: 'Montserrat', sans-serif; font-size: 12px; color: #94a3b8; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Estimasi Waktu</p>
                                            <span style="font-family: 'Montserrat', sans-serif; font-size: 14px; font-weight: 600; color: #1e293b;">
                                                <i class="ti-timer" style="color: #dc3545; margin-right: 5px;"></i> {{ $letter->estimated_time ?? 'Tidak ditentukan' }}
                                            </span>
                                        </div>
                                        <div class="col-xs-6">
                                            <p style="margin-bottom: 4px; font-family: 'Montserrat', sans-serif; font-size: 12px; color: #94a3b8; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px;">Biaya Layanan</p>
                                            <span style="font-family: 'Montserrat', sans-serif; font-size: 14px; font-weight: 600; color: #25D366;">
                                                <i class="ti-wallet" style="margin-right: 5px;"></i> {{ $letter->fee ?? 'Gratis' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-xs-12 text-center" style="padding: 80px 0;">
                    <i class="ti-files g-font-size-60--xs" style="font-family: 'Montserrat', sans-serif; color: #ccc; display: block; margin-bottom: 20px;"></i>
                    <h3 class="g-font-size-20--xs g-font-weight--600" style="color: #444; font-family: 'Montserrat', sans-serif;">Data Belum Tersedia</h3>
                    <p class="g-font-size-14--xs g-color--gray-dark" style="font-family: 'Montserrat', sans-serif; max-width: 500px; color: #dc3545; margin: 0 auto; line-height: 1.6;">
                        Belum ada jenis layanan surat yang di-up oleh pihak admin pelayanan Desa Tulungrejo.
                    </p>
                </div>
            </div>
        @endif

    </div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var targetHash = $(e.target).attr("href");
            var metaTargetHash = targetHash + "-meta";
            $('.tab-content ' + metaTargetHash).tab('show');
        });
    });
</script>
@endpush