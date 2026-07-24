@extends('layouts.app')

@section('page_title', 'Tambah Data Penduduk & RT/RW')
@section('page_subtitle', 'Masukkan data baru untuk RT/RW beserta rincian jumlah penduduknya.')

@section('content')
<form action="{{ route('admin.rt-rws.store') }}" method="POST">
    @csrf
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-base font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3">Informasi Wilayah & Penduduk</h3>
        <div class="space-y-5">
            
            <div class="mb-5">
                <label for="area_name" class="block text-sm font-bold text-gray-700 mb-1">Nama Dusun / Wilayah <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                <input type="text" name="area_name" id="area_name" value="{{ old('area_name') }}" maxlength="100"
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                       placeholder="Contoh: Dusun Gondang">
                @error('area_name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="rw_number" class="block text-sm font-bold text-gray-700 mb-1">Nomor RW <span class="text-red-500">*</span></label>
                    <input type="text" name="rw_number" id="rw_number" value="{{ old('rw_number') }}" required maxlength="10"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                           placeholder="Contoh: 01">
                    @error('rw_number')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="rt_number" class="block text-sm font-bold text-gray-700 mb-1">Nomor RT <span class="text-gray-400 font-normal text-xs">(Kosongkan jika ini data tingkat RW)</span></label>
                    <input type="text" name="rt_number" id="rt_number" value="{{ old('rt_number') }}" maxlength="10"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                           placeholder="Contoh: 01">
                    @error('rt_number')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="head_name" class="block text-sm font-bold text-gray-700 mb-1">Nama Ketua <span class="text-red-500">*</span></label>
                    <input type="text" name="head_name" id="head_name" value="{{ old('head_name') }}" required maxlength="150"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                           placeholder="Nama Ketua RT/RW">
                    @error('head_name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="head_phone" class="block text-sm font-bold text-gray-700 mb-1">No HP Ketua</label>
                    <input type="text" name="head_phone" id="head_phone" value="{{ old('head_phone') }}" maxlength="20"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                           placeholder="Contoh: 081234567890">
                    @error('head_phone')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="total_male" class="block text-sm font-bold text-gray-700 mb-1">Jumlah Laki-laki</label>
                    <input type="number" name="total_male" id="total_male" value="{{ old('total_male', 0) }}" min="0"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                    @error('total_male')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="total_female" class="block text-sm font-bold text-gray-700 mb-1">Jumlah Perempuan</label>
                    <input type="number" name="total_female" id="total_female" value="{{ old('total_female', 0) }}" min="0"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                    @error('total_female')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="total_kk" class="block text-sm font-bold text-gray-700 mb-1">Jumlah Kepala Keluarga (KK)</label>
                    <input type="number" name="total_kk" id="total_kk" value="{{ old('total_kk', 0) }}" min="0"
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                    @error('total_kk')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-100">
                <label class="relative inline-flex items-center cursor-pointer group">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">Tampilkan di Publik</span>
                </label>
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    Simpan Data
                </button>
                <a href="{{ route('admin.rt-rws.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors text-center">
                    Batal
                </a>
            </div>

        </div>
    </div>
</form>
@endsection
