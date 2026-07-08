@extends('layouts.app')

@section('page_title', 'Administrasi Online')
@section('page_subtitle', 'Ubah data layanan administrasi desa dan kontak WhatsApp admin pusat.')

@section('content')

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<form action="{{ route('admin.contact-services.store') }}" method="POST" class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
    @csrf
    
    <div class="p-6 md:p-8 space-y-6">
        <div>
            <h3 class="text-base font-bold text-gray-900 mb-4 pb-2 border-b flex items-center gap-2">
                <span class="w-1.5 h-4 bg-blue-600 rounded-full"></span>
                Informasi Layanan Pusat
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Layanan -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Layanan Utama <span class="text-red-500">*</span></label>
                    <input type="text" name="service_name" value="{{ old('service_name', $service->service_name) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" required autofocus maxlength="150" placeholder="Contoh: Pusat Pelayanan Administrasi Terpadu">
                    @error('service_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Deskripsi Layanan -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Layanan (Opsional)</label>
                    <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Contoh: Melayani pembuatan pengantar KTP, KK, dan Akta Kelahiran secara online.">{{ old('description', $service->description) }}</textarea>
                    <span class="text-[11px] text-gray-400 mt-1 block">Jelaskan secara singkat layanan apa saja yang bisa dibantu secara online.</span>
                    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Nama Petugas -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Admin / Petugas</label>
                    <input type="text" name="officer_name" value="{{ old('officer_name', $service->officer_name) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" maxlength="150" placeholder="Contoh: Bpk. Budi">
                    @error('officer_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Nomor WhatsApp -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp Admin</label>
                    <input type="text" name="phone" value="{{ old('phone', $service->phone) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" maxlength="20" placeholder="Contoh: 08123456789">
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Jam Operasional -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Operasional</label>
                    <input type="text" name="office_hours" value="{{ old('office_hours', $service->office_hours) }}" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm" maxlength="100" placeholder="Contoh: Senin - Jumat 08:00 - 15:00">
                    @error('office_hours') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Status Aktif -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status Layanan</label>
                    <select name="is_active" class="w-full rounded-lg border-gray-300 shadow-xs focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="1" {{ old('is_active', $service->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $service->is_active) == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition-colors text-sm">
            Simpan Perubahan
        </button>
    </div>
</form>
@endsection
