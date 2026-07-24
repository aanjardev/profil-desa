@extends('layouts.app')

@section('page_title', 'Edit Data Penduduk & RT/RW')
@section('page_subtitle', 'Perbarui data RT/RW beserta rincian jumlah penduduknya.')

@section('content')
<form action="{{ route('admin.rt-rws.update', $rtRw->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-bold text-gray-900 mb-5 border-b border-gray-100 pb-3">Informasi Wilayah & Penduduk</h3>
                <div class="space-y-5">
                    <div class="mb-5">
                        <label for="area_name" class="block text-sm font-bold text-gray-700 mb-1">Nama Dusun / Wilayah <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                        <input type="text" name="area_name" id="area_name" value="{{ old('area_name', $rtRw->area_name) }}" maxlength="100"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                               placeholder="Contoh: Dusun Gondang">
                        @error('area_name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="rw_number" class="block text-sm font-bold text-gray-700 mb-1">Nomor RW <span class="text-red-500">*</span></label>
                            <input type="text" name="rw_number" id="rw_number" value="{{ old('rw_number', $rtRw->rw_number) }}" required maxlength="10"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                   placeholder="Contoh: 01">
                            @error('rw_number')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="rt_number" class="block text-sm font-bold text-gray-700 mb-1">Nomor RT <span class="text-gray-400 font-normal text-xs">(Kosongkan jika ini data tingkat RW)</span></label>
                            <input type="text" name="rt_number" id="rt_number" value="{{ old('rt_number', $rtRw->rt_number) }}" maxlength="10"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm"
                                   placeholder="Contoh: 01">
                            @error('rt_number')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="head_name" class="block text-sm font-bold text-gray-700 mb-1">Nama Ketua <span class="text-red-500">*</span></label>
                            <input type="text" name="head_name" id="head_name" value="{{ old('head_name', $rtRw->head_name) }}" required maxlength="150"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                            @error('head_name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="head_phone" class="block text-sm font-bold text-gray-700 mb-1">No HP Ketua</label>
                            <input type="text" name="head_phone" id="head_phone" value="{{ old('head_phone', $rtRw->head_phone) }}" maxlength="20"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                            @error('head_phone')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label for="total_male" class="block text-sm font-bold text-gray-700 mb-1">Laki-laki</label>
                            <input type="number" name="total_male" id="total_male" value="{{ old('total_male', $rtRw->total_male) }}" min="0"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                            @error('total_male')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="total_female" class="block text-sm font-bold text-gray-700 mb-1">Perempuan</label>
                            <input type="number" name="total_female" id="total_female" value="{{ old('total_female', $rtRw->total_female) }}" min="0"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                            @error('total_female')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="total_kk" class="block text-sm font-bold text-gray-700 mb-1">Jumlah KK</label>
                            <input type="number" name="total_kk" id="total_kk" value="{{ old('total_kk', $rtRw->total_kk) }}" min="0"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors text-sm">
                            @error('total_kk')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $rtRw->is_active) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            <span class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">Tampilkan di Publik</span>
                        </label>
                    </div>
                    
                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.rt-rws.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors text-center">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-red-100 p-6">
                <h3 class="text-sm font-bold text-red-600 mb-2">Zona Berbahaya</h3>
                <p class="text-xs text-gray-500 mb-3">Hapus data ini secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                <button type="button" onclick="if(confirm('Yakin ingin menghapus data ini?')) document.getElementById('delete-form').submit();"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-200 text-red-600 text-sm font-semibold rounded-lg hover:bg-red-100 transition-colors w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Data
                </button>
            </div>
        </div>
    </div>
</form>

<form id="delete-form" action="{{ route('admin.rt-rws.destroy', $rtRw->id) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection
