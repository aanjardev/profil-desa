<div class="g-bg-color--gray-light g-padding-y-80--xs g-padding-y-125--sm">
    <div class="container">
        <div class="g-text-center--xs g-margin-b-60--xs">
            <h2 class="g-font-size-32--xs g-font-size-36--md g-font-weight--700">Pengumuman Desa</h2>
            <p class="g-color--dark g-font-size-16--xs">Informasi dan pengumuman penting untuk warga.</p>
        </div>
        
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div style="padding: 30px; border-radius: 12px; background: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                    <ul class="list-unstyled g-margin-b-0--xs">
                        @forelse($pengumuman as $peng)
                        <li class="g-margin-b-20--xs" style="{{ !$loop->last ? 'border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 20px;' : 'padding-bottom: 0;' }}">
                            <span class="g-font-size-13--xs g-color--primary g-font-weight--700 block g-margin-b-5--xs"><i class="ti-announcement g-margin-r-5--xs"></i> {{ $peng->created_at->translatedFormat('d F Y') }}</span>
                            <h4 class="g-font-size-18--xs g-margin-b-10--xs">
                                <a href="#" class="g-color--dark g-color--primary--hover" style="text-decoration: none;">{{ $peng->title }}</a>
                            </h4>
                            <p class="g-font-size-15--xs g-color--dark g-margin-b-0--xs">{{ Str::limit($peng->excerpt, 150) }}</p>
                        </li>
                        @empty
                        <li class="text-center">
                            <p class="g-color--dark">Belum ada pengumuman.</p>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
