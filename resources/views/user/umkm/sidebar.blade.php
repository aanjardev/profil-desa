<div class="col-md-4">
    <style>
        .sidebar-widget {
            background-color: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
        }
        .sidebar-widget-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #1e293b;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f1f5f9;
            position: relative;
        }
        .sidebar-widget-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: #dc3545;
        }
        
        /* Search Box Styles */
        .sidebar-search-input {
            height: 48px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 30px 0 0 30px !important;
            color: #334155 !important;
            background-color: #fff !important;
            padding-left: 20px !important;
            box-shadow: none !important;
            transition: all 0.3s ease !important;
        }
        .sidebar-search-input:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15) !important;
        }
        .sidebar-search-btn {
            height: 48px !important;
            border: 1px solid #dc3545 !important;
            background-color: #dc3545 !important;
            color: #fff !important;
            border-radius: 0 30px 30px 0 !important;
            padding: 0 20px !important;
            font-size: 15px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.15) !important;
        }
        .sidebar-search-btn:hover {
            background-color: #c82333 !important;
            border-color: #bd2130 !important;
            box-shadow: 0 6px 14px rgba(220, 53, 69, 0.25) !important;
        }

        /* Category Item Styles */
        .sidebar-link {
            text-decoration: none !important;
            color: #475569 !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            margin-bottom: 6px;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            font-weight: 500;
        }
        .sidebar-link i {
            font-size: 11px;
            margin-right: 8px;
            color: #94a3b8;
            transition: transform 0.3s ease;
        }
        .sidebar-link:hover {
            background-color: rgba(220, 53, 69, 0.04);
            color: #dc3545 !important;
            transform: translateX(4px);
        }
        .sidebar-link:hover i {
            color: #dc3545;
            transform: translateX(2px);
        }
        
        /* Active Category Style */
        .sidebar-link-active {
            background-color: rgba(220, 53, 69, 0.08) !important;
            color: #dc3545 !important;
            font-weight: 700 !important;
            border-left: 3px solid #dc3545;
            border-radius: 0 8px 8px 0;
            padding-left: 11px; /* Compensate for border */
        }
        .sidebar-link-active i {
            color: #dc3545 !important;
        }
        
        .sidebar-cat-count {
            background: #f1f5f9;
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        .sidebar-link:hover .sidebar-cat-count,
        .sidebar-link-active .sidebar-cat-count {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }
    </style>

    <!-- Search Widget (hidden on mobile, replaced by top mobile search bar) -->
    <div class="sidebar-widget hidden-xs">
        <h3 class="sidebar-widget-title">Pencarian</h3>
        <form action="{{ route('umkm') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control sidebar-search-input" placeholder="Cari UMKM..." value="{{ request('search') }}">
                <span class="input-group-btn">
                    <button class="btn sidebar-search-btn" type="submit"><i class="ti-search"></i></button>
                </span>
            </div>
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
        </form>
    </div>

    <!-- Category Widget -->
    @if(isset($categories) && $categories->count() > 0)
    <div class="sidebar-widget">
        <h3 class="sidebar-widget-title">Kategori</h3>
        <ul class="list-unstyled g-margin-b-0--xs">
            @foreach($categories as $cat)
                <li>
                    <a href="{{ route('umkm', ['category' => $cat->category]) }}" class="sidebar-link {{ request('category') == $cat->category ? 'sidebar-link-active' : '' }}">
                        <span>
                            <i class="ti-angle-right"></i> {{ $cat->category }}
                        </span>
                        <span class="sidebar-cat-count">{{ $cat->total }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
