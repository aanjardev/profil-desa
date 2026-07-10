<div class="col-md-4">
    <style>
        .sidebar-widget {
            background-color: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
        }
        .sidebar-link {
            text-decoration: none;
            color: #4a5568;
            transition: opacity 0.2s;
        }
        .sidebar-link:hover {
            opacity: 0.8;
        }
        .sidebar-list-item {
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 12px;
            margin-bottom: 12px;
            display: block;
        }
        .sidebar-list-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }
    </style>

    <!-- Category Widget -->
    @if(isset($categories) && $categories->count() > 0)
    <div class="sidebar-widget">
        <h3 class="g-font-size-18--xs g-font-weight--700 g-margin-b-20--xs">Kategori Galeri</h3>
        <ul class="list-unstyled g-margin-b-0--xs">
            <li>
                <a href="{{ route('galeri') }}" class="sidebar-link sidebar-list-item">
                    <i class="ti-angle-right g-margin-r-5--xs" style="color: #a0aec0;"></i> Semua Galeri
                </a>
            </li>
            @foreach($categories as $cat)
                <li>
                    <a href="{{ route('galeri', ['category' => $cat->category]) }}" class="sidebar-link sidebar-list-item" style="{{ request('category') == $cat->category ? 'font-weight: 700; color: #dc3545;' : '' }}">
                        <i class="ti-angle-right g-margin-r-5--xs" style="color: #a0aec0;"></i> {{ $cat->category }}
                        <span class="pull-right">({{ $cat->total }})</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Recent Galleries Widget -->
    @if(isset($recentGalleries) && $recentGalleries->count() > 0)
    <div class="sidebar-widget">
        <h3 class="g-font-size-18--xs g-font-weight--700 g-margin-b-20--xs">Foto Terbaru</h3>
        <div class="row g-margin-b-0--xs" style="display: flex; flex-wrap: wrap; margin: -5px;">
            @foreach($recentGalleries as $recent)
                <div class="col-xs-4" style="padding: 5px;">
                    <a href="{{ route('galeri.show', $recent->id) }}" title="{{ $recent->title }}" style="display: block; aspect-ratio: 1; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                        <img src="{{ asset('storage/'.$recent->image_path) }}" alt="{{ $recent->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Archive Widget -->
    @if(isset($archives) && $archives->count() > 0)
    <div class="sidebar-widget">
        <h3 class="g-font-size-18--xs g-font-weight--700 g-margin-b-20--xs">Arsip Galeri</h3>
        <ul class="list-unstyled g-margin-b-0--xs">
            @foreach($archives as $archive)
                <li>
                    <a href="{{ route('galeri', ['month' => $archive->month, 'year' => $archive->year]) }}" class="sidebar-link sidebar-list-item" style="{{ request('month') == $archive->month && request('year') == $archive->year ? 'font-weight: 700; color: #dc3545;' : '' }}">
                        <i class="ti-calendar g-margin-r-5--xs" style="color: #a0aec0;"></i> {{ $archive->month_name }} {{ $archive->year }}
                        <span class="pull-right">({{ $archive->count }})</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
