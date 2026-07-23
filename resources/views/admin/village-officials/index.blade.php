@extends('layouts.app')

@section('page_title', 'Perangkat Desa')
@section('page_subtitle', 'Kelola struktur organisasi dan data perangkat desa.')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
@endpush

@section('content')

@if(session('success'))
<div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 text-emerald-700">
    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

{{-- Header Bar --}}
<div class="bg-white p-4 md:p-6 rounded-xl border border-gray-100 shadow-sm mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-sm text-gray-500 mt-0.5">
                Total: 
                <span class="font-bold text-gray-800">{{ $officials->count() }} perangkat</span>
                &nbsp;•&nbsp;
                <span class="text-emerald-600 font-semibold">{{ $officials->where('status','aktif')->count() }} aktif</span>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs text-gray-400 hidden md:block">Drag kartu untuk ubah urutan</span>
            <a href="{{ route('admin.village-officials.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Perangkat
            </a>
        </div>
    </div>
</div>

{{-- Save order indicator --}}
<div id="save-indicator" class="hidden mb-4 p-3 rounded-lg bg-blue-50 border border-blue-100 text-blue-700 text-sm font-medium flex items-center gap-2">
    <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
    </svg>
    Menyimpan urutan...
</div>
<div id="save-success" class="hidden mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    Urutan berhasil disimpan.
</div>

@foreach($groupedOfficials as $level => $levelOfficials)
<div class="mb-8">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
            <span class="text-blue-600 font-black text-sm">{{ $level }}</span>
        </div>
        <div>
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">
                @if($level == 1) Level 1 — Puncak / Root
                @else Level {{ $level }} @endif
            </h2>
            <p class="text-xs text-gray-400 mt-0.5">{{ $levelOfficials->count() }} perangkat • @if($level == 1) tidak memiliki atasan @else di bawah level {{ $level - 1 }} @endif</p>
        </div>
    </div>

    <div id="sortable-level{{ $level }}" class="sortable-container grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3" data-level="{{ $level }}">
        @forelse($levelOfficials as $official)
            @include('admin.village-officials._card', ['official' => $official])
        @empty
            <div class="col-span-full py-10 flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-xl text-gray-400">
                <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <p class="text-sm">Belum ada perangkat level {{ $level }}</p>
            </div>
        @endforelse
    </div>
</div>
@endforeach

{{-- SortableJS Logic --}}
@push('scripts')
<script>
    const reorderUrl = '{{ route('admin.village-officials.reorder') }}';
    const csrfToken = '{{ csrf_token() }}';
    const saveIndicator = document.getElementById('save-indicator');
    const saveSuccess   = document.getElementById('save-success');

    let saveTimeout;

    function getSortedIds(container) {
        return [...container.querySelectorAll('[data-id]')].map(el => parseInt(el.dataset.id));
    }

    function saveOrder(container) {
        clearTimeout(saveTimeout);
        saveIndicator.classList.remove('hidden');
        saveSuccess.classList.add('hidden');

        saveTimeout = setTimeout(() => {
            const ids = getSortedIds(container);
            fetch(reorderUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ ids }),
            })
            .then(r => r.json())
            .then(data => {
                saveIndicator.classList.add('hidden');
                if (data.success) {
                    saveSuccess.classList.remove('hidden');
                    setTimeout(() => saveSuccess.classList.add('hidden'), 3000);
                }
            })
            .catch(() => {
                saveIndicator.classList.add('hidden');
            });
        }, 600); // debounce 600ms
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.sortable-container').forEach(el => {
            Sortable.create(el, {
                animation: 180,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                fallbackClass: 'sortable-fallback',
                forceFallback: true,
                handle: '.drag-handle',
                onEnd() {
                    saveOrder(el);
                }
            });
        });
    });
</script>
@endpush

<style>
    .sortable-ghost  { opacity: 0.35; }
    .sortable-chosen { box-shadow: 0 0 0 2px #3b82f6, 0 10px 25px -5px rgba(59,130,246,0.25); }
    .sortable-fallback { opacity: 0.9; cursor: grabbing !important; }
    .drag-handle     { cursor: grab; }
    .drag-handle:active { cursor: grabbing; }
</style>

@endsection
