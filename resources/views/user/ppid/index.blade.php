@extends('layouts.user')

@section('title', 'Dokumen PPID')

@section('content')

<!--========== PARALLAX HEADER ==========-->
<div class="g-padding-y-80--xs" style="background-image: url('{{ \App\Models\WebSetting::first()?->background_image ? asset('storage/' . \App\Models\WebSetting::first()->background_image) : asset('images/auth-bg.jpg') }}'); background-size: cover; background-position: center center; background-attachment: fixed; position: relative; padding-top: 130px !important;">
    <!-- Dark Overlay -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(26, 32, 44, 0.85); z-index: 1;"></div>
    
    <div class="container text-center" style="position: relative; z-index: 2;">
        <h1 class="g-font-size-32--xs g-font-size-40--sm g-font-weight--700 g-color--white g-margin-b-10--xs">Dokumen PPID</h1>
        <p class="g-font-size-16--xs g-color--white-opacity" style="max-width: 600px; margin: 0 auto;">Pejabat Pengelola Informasi dan Dokumentasi. Menyediakan layanan informasi publik yang transparan dan akuntabel.</p>
    </div>
</div>
<!--========== END PARALLAX HEADER ==========-->

<!--========== PAGE CONTENT ==========-->
<div class="g-bg-color--sky-light g-padding-y-60--xs">
    <div class="container">
        
        <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); padding: 30px; border: 1px solid #e2e8f0;">
            
            <!-- Filters -->
            <form action="{{ route('dokumen-ppid') }}" method="GET" class="g-margin-b-30--xs" style="background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
                <div class="row">
                    <div class="col-sm-4 g-margin-b-15--xs g-margin-b-0--sm">
                        <label class="g-font-size-13--xs g-font-weight--700 g-color--dark">Pencarian</label>
                        <input type="text" name="search" class="form-control" placeholder="Cari judul, nomor, atau deskripsi..." value="{{ request('search') }}" style="border-radius: 6px;">
                    </div>
                    <div class="col-sm-3 g-margin-b-15--xs g-margin-b-0--sm">
                        <label class="g-font-size-13--xs g-font-weight--700 g-color--dark">Kategori</label>
                        <select name="category" class="form-control" style="border-radius: 6px;">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 g-margin-b-15--xs g-margin-b-0--sm">
                        <label class="g-font-size-13--xs g-font-weight--700 g-color--dark">Tahun</label>
                        <select name="year" class="form-control" style="border-radius: 6px;">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ request('year') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label class="g-font-size-13--xs g-font-weight--700" style="color: transparent; display: block;">&nbsp;</label>
                        <button type="submit" class="btn btn-block s-btn s-btn--primary-bg g-radius--50" style="padding: 10px 15px;"><i class="ti-search g-margin-r-5--xs"></i> Tampilkan</button>
                    </div>
                </div>
                @if(request('search') || request('category') || request('year'))
                <div class="g-margin-t-15--xs text-right">
                    <a href="{{ route('dokumen-ppid') }}" class="g-font-size-13--xs g-color--primary"><i class="ti-close"></i> Hapus Filter</a>
                </div>
                @endif
            </form>

            <!-- Pagination (Top) -->
            <div class="g-margin-b-15--xs custom-pagination" style="display: flex; justify-content: flex-end;">
                <style>
                    .custom-pagination ul.pagination { margin: 0 !important; }
                </style>
                @if ($documents->lastPage() > 1)
                    {{ $documents->links('pagination::bootstrap-4') }}
                @else
                    <ul class="pagination">
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">&lsaquo;</span></li>
                        <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">&rsaquo;</span></li>
                    </ul>
                @endif
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover table-striped" style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                    <thead class="g-bg-color--dark g-color--white">
                        <tr>
                            <th style="padding: 15px; border-bottom: none; width: 5%;">No</th>
                            <th style="padding: 15px; border-bottom: none; width: 15%;">Nomor Register</th>
                            <th style="padding: 15px; border-bottom: none; width: 25%;">Judul / Nama Dokumen</th>
                            <th style="padding: 15px; border-bottom: none; width: 10%;">Tahun</th>
                            <th style="padding: 15px; border-bottom: none; width: 15%;">Kategori</th>
                            <th style="padding: 15px; border-bottom: none; width: 15%;">Tgl Ditetapkan</th>
                            <th style="padding: 15px; border-bottom: none; width: 15%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $index => $doc)
                        <tr>
                            <td style="padding: 15px; vertical-align: middle;">{{ $documents->firstItem() + $index }}</td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 600;">{{ $doc->register_no ?? '-' }}</td>
                            <td style="padding: 15px; vertical-align: middle;">
                                <strong style="display: block; margin-bottom: 5px; color: #2d3748;">{{ $doc->title }}</strong>
                                @if($doc->description)
                                    <span class="g-font-size-12--xs" style="color: #718096; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $doc->description }}</span>
                                @endif
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">{{ $doc->year ?? '-' }}</td>
                            <td style="padding: 15px; vertical-align: middle;">
                                @if($doc->category)
                                    <span class="g-font-size-11--xs g-bg-color--primary-opacity-lightest g-color--primary g-padding-x-10--xs g-padding-y-3--xs g-radius--50">{{ $doc->category }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                                {{ $doc->established_date ? \Carbon\Carbon::parse($doc->established_date)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                                @if($doc->file_path)
                                    <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="s-btn s-btn--xs s-btn--primary-bg g-radius--50" style="padding: 8px 15px; white-space: nowrap;">
                                        <i class="ti-download g-margin-r-5--xs"></i> {{ $doc->file_label ?? 'Unduh' }}
                                    </a>
                                @else
                                    <span class="g-font-size-12--xs g-color--text">Tidak ada file</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center g-padding-y-40--xs">
                                <i class="ti-files g-font-size-30--xs g-color--primary g-margin-b-10--xs" style="display: block;"></i>
                                <h4 class="g-font-size-16--xs g-color--dark g-margin-b-0--xs">Data Dokumen Tidak Ditemukan</h4>
                                <p class="g-font-size-13--xs g-color--text">Belum ada dokumen yang diunggah atau tidak ada yang sesuai dengan filter Anda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination (Bottom) -->
            <div class="g-margin-t-20--xs text-center custom-pagination" style="display: flex; justify-content: center;">
                @if ($documents->lastPage() > 1)
                    {{ $documents->links('pagination::bootstrap-4') }}
                @else
                    <ul class="pagination">
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">&lsaquo;</span></li>
                        <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">&rsaquo;</span></li>
                    </ul>
                @endif
            </div>

        </div>
        
    </div>
</div>
<!--========== END PAGE CONTENT ==========-->
@endsection
