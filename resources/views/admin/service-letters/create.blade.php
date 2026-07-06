@extends('layouts.app')

@section('page_title', 'Tambah Layanan Surat')
@section('page_subtitle', 'Masukkan jenis layanan surat dan persyaratan yang dibutuhkan warga.')

@section('content')
<form action="{{ route('admin.service-letters.store') }}" method="POST">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- ── Kolom Utama ── --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3">Informasi Utama</h3>
                <div class="space-y-5">
                    <div>
                        <label for="letter_name" class="block text-sm font-bold text-gray-700 mb-1">Nama Layanan Surat <span class="text-red-500">*</span></label>
                        <input type="text" name="letter_name" id="letter_name" value="{{ old('letter_name') }}" required maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: Surat Keterangan Usaha (SKU)">
                        @error('letter_name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="requirements" class="block text-sm font-bold text-gray-700 mb-1">Persyaratan Dokumen <span class="text-red-500">*</span></label>
                        <textarea name="requirements" id="requirements" rows="6" required
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm resize-none"
                                  placeholder="Contoh:&#10;- Fotokopi KTP Pemohon&#10;- Fotokopi Kartu Keluarga&#10;- Surat Pengantar RT/RW">{{ old('requirements') }}</textarea>
                        <p class="text-xs text-gray-500 mt-2">Sebutkan persyaratan secara jelas agar warga mudah memahaminya.</p>
                        @error('requirements')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Kolom Sidebar ── --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3">Pengaturan Layanan</h3>
                <div class="space-y-5">
                    <div>
                        <label for="estimated_time" class="block text-sm font-bold text-gray-700 mb-1">Estimasi Waktu <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                        <input type="text" name="estimated_time" id="estimated_time" value="{{ old('estimated_time') }}" maxlength="100"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: 1 Hari Kerja, 30 Menit">
                        @error('estimated_time')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="fee" class="block text-sm font-bold text-gray-700 mb-1">Biaya Layanan <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                        <input type="text" name="fee" id="fee" value="{{ old('fee') }}" maxlength="100"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: Gratis, Rp 15.000">
                        @error('fee')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-2">Status Layanan</label>
                        <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg border border-gray-100 bg-gray-50 hover:bg-blue-50/50 hover:border-blue-200 transition-colors has-[:checked]:border-blue-300 has-[:checked]:bg-blue-50">
                            <div class="relative">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                                <div class="w-10 h-5 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                            </div>
                            <div>
                                <span class="text-sm font-semibold text-gray-700">Layanan Aktif</span>
                                <p class="text-[11px] text-gray-400">Tampil di halaman web warga</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <button type="submit" class="w-full px-5 py-3 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    Simpan Layanan
                </button>
                <a href="{{ route('admin.service-letters.index') }}" class="w-full px-5 py-3 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors text-center">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
