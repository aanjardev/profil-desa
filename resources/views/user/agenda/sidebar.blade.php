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
            /* Text color remains the same, no primary color hover */
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

    <!-- Search Widget -->
    <div class="sidebar-widget">
        <h3 class="g-font-size-18--xs g-font-weight--700 g-margin-b-20--xs">Pencarian</h3>
        <form action="{{ route('agenda-kegiatan') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari agenda..." value="{{ request('search') }}" style="height: 50px; border-color: #e2e8f0; color: #4a5568; background-color: #fff;">
                <span class="input-group-btn">
                    <button class="btn s-btn s-btn--primary-bg" type="submit" style="height: 50px;"><i class="ti-search"></i></button>
                </span>
            </div>
        </form>
    </div>

    <!-- Category Widget -->
    @if(isset($categories) && $categories->count() > 0)
    <div class="sidebar-widget">
        <h3 class="g-font-size-18--xs g-font-weight--700 g-margin-b-20--xs">Kategori</h3>
        <ul class="list-unstyled g-margin-b-0--xs">
            @foreach($categories as $cat)
                <li>
                    <a href="{{ route('agenda-kegiatan', ['category' => $cat->category]) }}" class="sidebar-link sidebar-list-item">
                        <i class="ti-angle-right g-margin-r-5--xs" style="color: #a0aec0;"></i> {{ $cat->category }}
                        <span class="pull-right">({{ $cat->total }})</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Upcoming Agendas Widget -->
    @if(isset($upcomingAgendas) && $upcomingAgendas->count() > 0)
    <div class="sidebar-widget">
        <h3 class="g-font-size-18--xs g-font-weight--700 g-margin-b-20--xs">Agenda Mendatang</h3>
        @foreach($upcomingAgendas as $upcoming)
            <div class="sidebar-list-item">
                <h4 class="g-font-size-15--xs g-margin-b-5--xs" style="line-height: 1.4; font-weight: 600; color: #2d3748;">
                    {{ $upcoming->title }}
                </h4>
                <div class="g-font-size-12--xs g-margin-b-5--xs" style="color: #718096;"><i class="ti-calendar g-margin-r-5--xs"></i>{{ \Carbon\Carbon::parse($upcoming->start_date)->translatedFormat('d M Y') }}</div>
                <div class="g-font-size-12--xs" style="color: #718096;"><i class="ti-location-pin g-margin-r-5--xs"></i>{{ $upcoming->location }}</div>
            </div>
        @endforeach
    </div>
    @endif

    <!-- Archive Widget -->
    @if(isset($archives) && $archives->count() > 0)
    <div class="sidebar-widget">
        <h3 class="g-font-size-18--xs g-font-weight--700 g-margin-b-20--xs">Arsip Agenda</h3>
        <ul class="list-unstyled g-margin-b-0--xs">
            @foreach($archives as $archive)
                <li>
                    <a href="{{ route('agenda-kegiatan', ['month' => $archive->month, 'year' => $archive->year]) }}" class="sidebar-link sidebar-list-item">
                        <i class="ti-calendar g-margin-r-5--xs" style="color: #a0aec0;"></i> {{ $archive->month_name }} {{ $archive->year }}
                        <span class="pull-right">({{ $archive->count }})</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
