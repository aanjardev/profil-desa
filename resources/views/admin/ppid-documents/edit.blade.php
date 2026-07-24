@extends('layouts.app')

@section('page_title', 'Edit Produk Hukum')
@section('page_subtitle', 'Perbarui data atau file produk hukum desa.')

@section('content')
<form action="{{ route('admin.ppid-documents.update', $ppidDocument->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- ── Kolom Utama ── --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3">Informasi Produk Hukum</h3>
                <div class="space-y-5">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="year" class="block text-sm font-bold text-gray-700 mb-1">Tahun Register <span class="text-red-500">*</span></label>
                            <input type="number" name="year" id="year" value="{{ old('year', $ppidDocument->year) }}" required min="2000" max="{{ date('Y') + 1 }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                            @error('year')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="register_no" class="block text-sm font-bold text-gray-700 mb-1">Nomor Register <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                            <input type="text" name="register_no" id="register_no" value="{{ old('register_no', $ppidDocument->register_no) }}" maxlength="50"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                            @error('register_no')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-1">Judul Produk Hukum <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $ppidDocument->title) }}" required maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                        @error('title')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="category" class="block text-sm font-bold text-gray-700 mb-1">Jenis Produk Hukum <span class="text-red-500">*</span></label>
                            <select name="category" id="category" required
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                                <option value="" disabled>Pilih jenis dokumen...</option>
                                <option value="Peraturan Desa" {{ old('category', $ppidDocument->category) == 'Peraturan Desa' ? 'selected' : '' }}>Peraturan Desa</option>
                                <option value="Peraturan Kepala Desa" {{ old('category', $ppidDocument->category) == 'Peraturan Kepala Desa' ? 'selected' : '' }}>Peraturan Kepala Desa</option>
                                <option value="Keputusan Kepala Desa" {{ old('category', $ppidDocument->category) == 'Keputusan Kepala Desa' ? 'selected' : '' }}>Keputusan Kepala Desa</option>
                                <option value="SK Kades" {{ old('category', $ppidDocument->category) == 'SK Kades' ? 'selected' : '' }}>SK Kades</option>
                                <option value="Dokumen Lainnya" {{ old('category', $ppidDocument->category) == 'Dokumen Lainnya' ? 'selected' : '' }}>Dokumen Lainnya</option>
                            </select>
                            @error('category')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="established_date" class="block text-sm font-bold text-gray-700 mb-1">Tanggal Ditetapkan <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                            <input type="date" name="established_date" id="established_date" value="{{ old('established_date', $ppidDocument->established_date ? \Carbon\Carbon::parse($ppidDocument->established_date)->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm text-gray-600">
                            @error('established_date')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                </div>
            </div>

            {{-- Danger Zone --}}
            <div class="bg-white rounded-xl shadow-sm border border-red-100 p-6">
                <h3 class="text-sm font-bold text-red-600 mb-2">Zona Berbahaya</h3>
                <p class="text-xs text-gray-500 mb-3">Menghapus data ini akan menghapus catatan beserta file dokumen yang terkait dari server secara permanen.</p>
                <button type="submit" form="delete-form"
                        onclick="return confirm('Hapus dokumen {{ addslashes($ppidDocument->title) }} secara permanen?')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-200 text-red-600 text-sm font-semibold rounded-lg hover:bg-red-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Dokumen Ini
                </button>
            </div>
        </div>

        {{-- ── Kolom Sidebar ── --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" x-data="{ 
                hasFile: {{ $ppidDocument->file_path ? 'true' : 'false' }},
                removeFile: false,
                fileName: '',
                fileSize: '',
                handleFile(e) {
                    const file = e.target.files[0];
                    if(file) {
                        this.fileName = file.name;
                        this.fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                        this.removeFile = false;
                        this.hasFile = false; // Hide existing view
                    } else {
                        this.fileName = '';
                        this.fileSize = '';
                    }
                }
            }">
                <h3 class="text-base font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3">File Dokumen (Aksi)</h3>
                
                <div class="space-y-4">
                    {{-- Existing File Info --}}
                    <div x-show="hasFile && !removeFile" class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-sm font-semibold text-gray-900 truncate">Dokumen Tersimpan</p>
                                    <a href="{{ $ppidDocument->file_path ? Storage::url($ppidDocument->file_path) : '#' }}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat File</a>
                                </div>
                            </div>
                            <button type="button" @click="removeFile = true" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-md transition-colors" title="Hapus File">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="remove_file" :value="removeFile ? '1' : '0'">

                    {{-- Upload Baru --}}
                    <div x-show="!hasFile || removeFile" class="relative">
                        <label for="document_file" class="flex flex-col items-center justify-center w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-xl appearance-none cursor-pointer hover:border-blue-400 hover:bg-blue-50 focus:outline-none" :class="{ 'bg-blue-50 border-blue-400': fileName }">
                            <span class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" :class="{ 'text-blue-500': fileName }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <span class="font-medium text-gray-600 text-sm" x-show="!fileName">
                                    Unggah dokumen baru...
                                </span>
                                <span class="font-bold text-blue-600 text-sm" x-show="fileName" x-text="fileName"></span>
                            </span>
                            <span class="text-xs text-gray-400 mt-2" x-show="!fileName">Maks. 10MB (PDF/Word)</span>
                            <span class="text-xs text-gray-500 mt-2 font-medium bg-white px-2 py-0.5 rounded border border-gray-200" x-show="fileName" x-text="'Ukuran: ' + fileSize"></span>
                            
                            <input type="file" id="document_file" name="document_file" accept=".pdf,.doc,.docx,.xls,.xlsx" class="hidden" @change="handleFile">
                        </label>
                        @error('document_file')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror

                        <div x-show="removeFile && {{ $ppidDocument->file_path ? 'true' : 'false' }}" class="mt-3 text-center">
                            <button type="button" @click="removeFile = false; document.getElementById('document_file').value = ''; fileName = ''; fileSize = '';" class="text-xs font-semibold text-gray-500 hover:text-gray-800 underline">Batal Hapus File Lama</button>
                        </div>
                    </div>
                    
                    <div class="pt-2">
                        <label for="file_label" class="block text-sm font-bold text-gray-700 mb-1">Label Teks File <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                        <input type="text" name="file_label" id="file_label" value="{{ old('file_label', $ppidDocument->file_label) }}" maxlength="100"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: SK Produk Desa.pdf">
                        <p class="mt-1 text-xs text-gray-500">Teks ini akan tampil sebagai nama tombol tautan file.</p>
                        @error('file_label')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-3">Status Visibilitas</h3>
                <label class="relative inline-flex items-center cursor-pointer group">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $ppidDocument->is_active) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">Tampilkan di Publik</span>
                </label>
            </div>
            
            {{-- Info Sistem --}}
            <div class="bg-gray-50 rounded-xl border border-gray-100 p-4 text-xs text-gray-500 space-y-1.5">
                <div class="flex justify-between"><span class="font-semibold text-gray-600">ID</span><span>#{{ $ppidDocument->id }}</span></div>
                <div class="flex justify-between"><span class="font-semibold text-gray-600">Ditambahkan</span><span>{{ $ppidDocument->created_at->format('d M Y') }}</span></div>
                <div class="flex justify-between"><span class="font-semibold text-gray-600">Diperbarui</span><span>{{ $ppidDocument->updated_at->format('d M Y') }}</span></div>
            </div>

            <div class="flex flex-col gap-3">
                <button type="submit" class="w-full px-5 py-3 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.ppid-documents.index') }}" class="w-full px-5 py-3 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors text-center">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>

<form id="delete-form" action="{{ route('admin.ppid-documents.destroy', $ppidDocument->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection
