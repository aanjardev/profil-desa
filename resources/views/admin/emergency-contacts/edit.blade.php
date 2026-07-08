@extends('layouts.app')

@section('page_title', 'Edit Kontak Darurat')
@section('page_subtitle', 'Ubah informasi kontak darurat yang sudah ada.')

@section('content')
<form action="{{ route('admin.emergency-contacts.update', $emergencyContact->id) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @csrf
    @method('PUT')
    
    <div class="p-6 md:p-8 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Layanan</label>
                <input type="text" name="name" value="{{ old('name', $emergencyContact->name) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required placeholder="Contoh: Polsek Kecamatan...">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $emergencyContact->phone) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required placeholder="Contoh: 021-12345678">
                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                <input type="text" name="category" value="{{ old('category', $emergencyContact->category) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Contoh: Keamanan, Kesehatan, Bencana...">
                @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Urutan</label>
                <input type="number" name="order_num" value="{{ old('order_num', $emergencyContact->order_num) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                @error('order_num') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat</label>
            <textarea name="description" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Deskripsi layanan atau jam operasional (opsional)">{{ old('description', $emergencyContact->description) }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
            <textarea name="address" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Alamat lengkap (opsional)">{{ old('address', $emergencyContact->address) }}</textarea>
            @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        
        <div class="flex items-center gap-3 mt-4">
            <input type="checkbox" name="is_active" id="is_active" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ old('is_active', $emergencyContact->is_active) ? 'checked' : '' }}>
            <label for="is_active" class="text-sm font-semibold text-gray-700">Aktif (Tampilkan di website)</label>
        </div>
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
        <a href="{{ route('admin.emergency-contacts.index') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2 px-6 rounded-lg transition-colors text-sm">
            Batal
        </a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition-colors text-sm">
            Simpan Perubahan
        </button>
    </div>
</form>
@endsection
