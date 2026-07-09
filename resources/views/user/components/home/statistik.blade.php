<div style="background: url('{{ asset('images/auth-bg.jpeg') }}') center center no-repeat fixed; background-size: cover; position: relative;">
    <!-- Red Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(122, 29, 38, 0.81); z-index: 1;"></div>
    
    <div class="g-padding-y-80--xs g-padding-y-125--sm" style="position: relative; z-index: 2;">
        <div class="container g-text-center--xs">
            <div class="row">
                <div class="col-sm-4 g-margin-b-60--xs g-margin-b-0--md">
                    <i class="ti-map-alt g-font-size-50--xs g-color--white g-margin-b-20--xs"></i>
                    <div class="g-font-size-40--xs g-font-weight--700 g-color--white g-margin-b-10--xs">{{ $statistics['luas_wilayah'] }}</div>
                    <div class="text-uppercase g-font-size-14--xs g-color--white-opacity">Luas Wilayah (Ha)</div>
                </div>
                <div class="col-sm-4 g-margin-b-60--xs g-margin-b-0--md">
                    <i class="ti-user g-font-size-50--xs g-color--white g-margin-b-20--xs"></i>
                    <div class="g-font-size-40--xs g-font-weight--700 g-color--white g-margin-b-10--xs">{{ $statistics['jumlah_penduduk'] }}</div>
                    <div class="text-uppercase g-font-size-14--xs g-color--white-opacity">Jumlah Penduduk</div>
                </div>
                <div class="col-sm-4">
                    <i class="ti-home g-font-size-50--xs g-color--white g-margin-b-20--xs"></i>
                    <div class="g-font-size-40--xs g-font-weight--700 g-color--white g-margin-b-10--xs">{{ $statistics['jumlah_rt_rw'] }}</div>
                    <div class="text-uppercase g-font-size-14--xs g-color--white-opacity">RT / RW</div>
                </div>
            </div>
        </div>
    </div>
</div>
