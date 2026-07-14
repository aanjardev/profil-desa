@extends('layouts.app')

@section('title', 'Pengaturan Beranda')

@section('content')
<div class="p-6 max-w-screen-xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pengaturan Highlight Beranda</h1>
        <p class="text-sm text-gray-500 mt-1">Pilih maksimal <strong>3 Wisata</strong> dan <strong>3 UMKM</strong> yang akan ditampilkan di halaman beranda.</p>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm">
        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Alert error validasi --}}
    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 text-sm">
        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    </div>
    @endif

    <form action="{{ route('admin.homepage-featured.update') }}" method="POST" id="featured-form">
        @csrf

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

            {{-- ===== PANEL WISATA ===== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                {{-- Panel Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-semibold text-gray-800 text-sm">Tempat Wisata</h2>
                            <p class="text-xs text-gray-400">Pilih yang tampil di beranda</p>
                        </div>
                    </div>
                    {{-- Counter badge --}}
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-gray-500">Dipilih:</span>
                        <span id="counter-tourism"
                            class="inline-flex items-center justify-center min-w-[2.5rem] px-2.5 py-1 rounded-full text-xs font-bold
                            {{ $featuredTourismCount >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                            {{ $featuredTourismCount }}/3
                        </span>
                    </div>
                </div>

                {{-- Item List --}}
                <div class="p-4 flex flex-col gap-3 max-h-[520px] overflow-y-auto" id="list-tourism">
                    @forelse($tourisms as $tourism)
                    <label class="featured-item-tourism flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all duration-150
                        {{ $tourism->is_featured ? 'border-blue-400 bg-blue-50 shadow-sm' : 'border-gray-200 bg-white hover:border-gray-300 hover:bg-gray-50' }}"
                        for="tourism_{{ $tourism->id }}">

                        {{-- Thumbnail --}}
                        <div class="w-14 h-14 rounded-lg overflow-hidden shrink-0 bg-gray-100">
                            @if($tourism->main_image)
                                <img src="{{ asset('storage/' . $tourism->main_image) }}" alt="{{ $tourism->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-800 truncate">{{ $tourism->name }}</p>
                            @if($tourism->location)
                            <p class="text-xs text-gray-400 truncate mt-0.5">
                                <svg class="w-3 h-3 inline mr-0.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $tourism->location }}
                            </p>
                            @endif
                        </div>

                        {{-- Checkbox custom --}}
                        <div class="shrink-0 flex items-center">
                            <input type="checkbox"
                                id="tourism_{{ $tourism->id }}"
                                name="featured_tourisms[]"
                                value="{{ $tourism->id }}"
                                class="tourism-checkbox hidden"
                                {{ $tourism->is_featured ? 'checked' : '' }}>
                            <div class="checkbox-visual w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all duration-150
                                {{ $tourism->is_featured ? 'border-blue-500 bg-blue-500' : 'border-gray-300 bg-white' }}">
                                <svg class="w-3.5 h-3.5 text-white {{ $tourism->is_featured ? '' : 'hidden' }} check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                    </label>
                    @empty
                    <div class="text-center py-12 text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm">Belum ada wisata aktif.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- ===== PANEL UMKM ===== --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                {{-- Panel Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-semibold text-gray-800 text-sm">UMKM</h2>
                            <p class="text-xs text-gray-400">Pilih yang tampil di beranda</p>
                        </div>
                    </div>
                    {{-- Counter badge --}}
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-gray-500">Dipilih:</span>
                        <span id="counter-umkm"
                            class="inline-flex items-center justify-center min-w-[2.5rem] px-2.5 py-1 rounded-full text-xs font-bold
                            {{ $featuredUmkmCount >= 3 ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                            {{ $featuredUmkmCount }}/3
                        </span>
                    </div>
                </div>

                {{-- Item List --}}
                <div class="p-4 flex flex-col gap-3 max-h-[520px] overflow-y-auto" id="list-umkm">
                    @forelse($umkms as $umkm)
                    <label class="featured-item-umkm flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all duration-150
                        {{ $umkm->is_featured ? 'border-emerald-400 bg-emerald-50 shadow-sm' : 'border-gray-200 bg-white hover:border-gray-300 hover:bg-gray-50' }}"
                        for="umkm_{{ $umkm->id }}">

                        {{-- Thumbnail --}}
                        <div class="w-14 h-14 rounded-lg overflow-hidden shrink-0 bg-gray-100">
                            @if($umkm->main_image)
                                <img src="{{ asset('storage/' . $umkm->main_image) }}" alt="{{ $umkm->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-800 truncate">{{ $umkm->name }}</p>
                            <div class="flex items-center gap-2 mt-0.5">
                                @if($umkm->category)
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">{{ $umkm->category }}</span>
                                @endif
                                @if($umkm->owner_name)
                                <p class="text-xs text-gray-400 truncate">{{ $umkm->owner_name }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Checkbox custom --}}
                        <div class="shrink-0 flex items-center">
                            <input type="checkbox"
                                id="umkm_{{ $umkm->id }}"
                                name="featured_umkms[]"
                                value="{{ $umkm->id }}"
                                class="umkm-checkbox hidden"
                                {{ $umkm->is_featured ? 'checked' : '' }}>
                            <div class="checkbox-visual w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all duration-150
                                {{ $umkm->is_featured ? 'border-emerald-500 bg-emerald-500' : 'border-gray-300 bg-white' }}">
                                <svg class="w-3.5 h-3.5 text-white {{ $umkm->is_featured ? '' : 'hidden' }} check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                    </label>
                    @empty
                    <div class="text-center py-12 text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm">Belum ada UMKM aktif.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ===== Footer Actions ===== --}}
        <div class="mt-6 flex items-center justify-between bg-white border border-gray-100 rounded-2xl shadow-sm px-6 py-4">
            <div class="text-sm text-gray-500 flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Jika tidak ada yang dipilih, beranda akan otomatis menampilkan 3 data terbaru.
            </div>
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-700 transition-colors duration-150 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Pengaturan
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const MAX = 3;

    // ── Wisata ──────────────────────────────────────────────
    initGroup({
        checkboxClass:  'tourism-checkbox',
        labelClass:     'featured-item-tourism',
        counterId:      'counter-tourism',
        activeColor:    { border: 'border-blue-400', bg: 'bg-blue-50', circle: 'border-blue-500 bg-blue-500' },
        inactiveColor:  { border: 'border-gray-200', bg: 'bg-white', circle: 'border-gray-300 bg-white' },
        badgeActiveClass: 'bg-blue-600',
    });

    // ── UMKM ────────────────────────────────────────────────
    initGroup({
        checkboxClass:  'umkm-checkbox',
        labelClass:     'featured-item-umkm',
        counterId:      'counter-umkm',
        activeColor:    { border: 'border-emerald-400', bg: 'bg-emerald-50', circle: 'border-emerald-500 bg-emerald-500' },
        inactiveColor:  { border: 'border-gray-200', bg: 'bg-white', circle: 'border-gray-300 bg-white' },
        badgeActiveClass: 'bg-emerald-600',
    });

    function initGroup({ checkboxClass, labelClass, counterId, activeColor, inactiveColor, badgeActiveClass }) {
        const checkboxes = document.querySelectorAll('.' + checkboxClass);
        const counter    = document.getElementById(counterId);

        // Click handler pada label
        document.querySelectorAll('.' + labelClass).forEach(function (label) {
            label.addEventListener('click', function (e) {
                e.preventDefault();

                const cb     = label.querySelector('.' + checkboxClass);
                const visual = label.querySelector('.checkbox-visual');
                const icon   = label.querySelector('.check-icon');

                const checkedCount = document.querySelectorAll('.' + checkboxClass + ':checked').length;

                if (cb.checked) {
                    // Uncheck
                    cb.checked = false;
                    visual.className = 'checkbox-visual w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all duration-150 ' + inactiveColor.circle;
                    icon.classList.add('hidden');
                    label.classList.remove(activeColor.border, activeColor.bg, 'shadow-sm');
                    label.classList.add(inactiveColor.border, inactiveColor.bg);
                } else {
                    // Check jika belum penuh
                    if (checkedCount >= MAX) {
                        // Animasi shake ringan
                        counter.classList.add('scale-125');
                        setTimeout(() => counter.classList.remove('scale-125'), 200);
                        return;
                    }
                    cb.checked = true;
                    visual.className = 'checkbox-visual w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all duration-150 ' + activeColor.circle;
                    icon.classList.remove('hidden');
                    label.classList.remove(inactiveColor.border, inactiveColor.bg);
                    label.classList.add(activeColor.border, activeColor.bg, 'shadow-sm');
                }

                updateCounter();
            });
        });

        function updateCounter() {
            const count = document.querySelectorAll('.' + checkboxClass + ':checked').length;
            counter.textContent = count + '/3';

            if (count >= MAX) {
                counter.classList.remove('bg-gray-100', 'text-gray-700');
                counter.classList.add(badgeActiveClass, 'text-white');
            } else {
                counter.classList.remove(badgeActiveClass, 'text-white');
                counter.classList.add('bg-gray-100', 'text-gray-700');
            }
        }

        updateCounter();
    }
});
</script>
@endpush
@endsection
